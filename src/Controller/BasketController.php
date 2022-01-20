<?php

namespace App\Controller;

use App\Entity\Basket;
use App\Entity\Invoice;
use App\Entity\Order;
use App\Repository\BasketRepository;
use App\Repository\DeliveryRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Repository\StockRepository;
use App\Security\EmailVerifier;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Address;

class BasketController extends AbstractController
{
    private $entityManager;
    private EmailVerifier $emailVerifier;

    public function __construct(EntityManagerInterface $manager, EmailVerifier $emailVerifier)
    {
        $this->entityManager = $manager;
        $this->emailVerifier = $emailVerifier;
    }

    /**
     * @Route("/panier", name="basket")
     */
    public function index(DeliveryRepository $deliveryRepository, BasketRepository $basketRepository): Response
    {
        $user = $this->getUser();
        $deliveries = $deliveryRepository->findAll();
        $basket = $basketRepository->findOneBy([
            'user_id' => $user,
            'name' => "Panier"
        ]);

        // dd($basket);

        return $this->render('basket/index.html.twig', [
            'deliveries' => $deliveries,
            'basket' => $basket,
        ]);
    }

    /**
     * @Route("/less/{order_id}", name="basket_less")
     */
    public function less(Request $request, $order_id, OrderRepository $orderRepository): Response
    {
        $order = $orderRepository->find($order_id);
        if ($order->getAmount() > 1) {
            $order->setAmount($order->getAmount()-1);
            $this->entityManager->persist($order);
            $this->entityManager->flush();
        }

        return new RedirectResponse($request->headers->get('referer'));
    }

    /**
     * @Route("/more/{order_id}", name="basket_more")
     */
    public function more(Request $request, $order_id, OrderRepository $orderRepository): Response
    {
        $order = $orderRepository->find($order_id);
        // dd($order->getAmount(), $order->getStockId()->getAmount());
        if ($order->getAmount() < $order->getStockId()->getAmount()) {
            $order->setAmount($order->getAmount()+1);
            $this->entityManager->persist($order);
            $this->entityManager->flush();
        } else {
            $this->addFlash("info", "Nous en avons pas plus.");
        }

        return new RedirectResponse($request->headers->get('referer'));
    }

    /**
     * @Route("/delete/{order_id}", name="basket_delete")
     */
    public function delete(Request $request, $order_id, OrderRepository $orderRepository): Response
    {
        $order = $orderRepository->find($order_id);
        $basket = $order->getBasketId();

        $this->entityManager->remove($order);
        $this->entityManager->flush();

        if (count($basket->getOrders()) === 0) {
            $this->entityManager->remove($basket);
            $this->entityManager->flush();
        }
        
        $this->addFlash("info", "Le produit '".$order->getProductId()->getModel()."' à été enlevé du panier.");
        
        return new RedirectResponse($request->headers->get('referer'));
    }

    /**
     * @Route("/delivery/{basket_id}/{delivery_id}", name="basket_choice_delivery")
     */
    public function choiceDelivery(Request $request, $basket_id, $delivery_id, BasketRepository $basketRepository, DeliveryRepository $deliveryRepository): Response
    {
        $basket = $basketRepository->find($basket_id);
        $delivery = $deliveryRepository->find($delivery_id);
        $basket->setDeliveryId($delivery);
        $this->entityManager->persist($basket);
        $this->entityManager->flush();

        return new RedirectResponse($request->headers->get('referer'));
    }

    /**
     * @Route("/basket/{stock_id}/{product_id}", name="basket_add")
     */
    public function add($stock_id, $product_id, StockRepository $stockRepository, ProductRepository $productRepository, BasketRepository $basketRepository, OrderRepository $orderRepository, Request $request): Response
    {
        $product = $productRepository->find($product_id);
        $stock = $stockRepository->find($stock_id);
        $user = $this->getUser();
        
        if ($user) {
            $user_basket = $basketRepository->findOneBy([
                'user_id' => $user,
                'name' => 'Panier'
            ]);
            $ref = uniqid($product->getRef());
            $now = new DateTime('now');
            
            if (!$user_basket) {
                $basket = new Basket();

                $basket->setUserId($user);
                $basket->setName("Panier");
                $basket->setIsPayed(false);
                $basket->setRefOrder($ref);
                $basket->setCreatedAt($now);
                $this->entityManager->persist($basket);
            } else {
                $basket = $user_basket;
            }
            
            $basket_order = $orderRepository->findOneBy([
                'basket_id' => $basket,
                'stock_id' => $stock
            ]);
            if ($basket_order) {
                $basket_order->setAmount($basket_order->getAmount()+1);
                $this->entityManager->persist($basket_order);
            } else {
                $order = new Order();
                $order->setBasketId($basket);
                $order->setProductId($product);
                $order->setStockId($stock);
                $order->setAmount(1);
                $this->entityManager->persist($order);
            }
            
            $this->entityManager->flush();

            $this->addFlash('info', $product->getModel().' à bien été ajouté au panier.');
        } else {
            $this->addFlash('warning', 'Veuillez vous connecter pour pouvoir ajouter des articles au panier.');
        }

        return new RedirectResponse($request->headers->get('referer'));
    }

    /**
     * @Route("/payed/{basket_id}", name="basket_pay")
     */
    public function payed(Request $request, $basket_id, BasketRepository $basketRepository): Response
    {
        $user = $this->getUser();

        $now = new DateTime('now');
        $basket = $basketRepository->find($basket_id);
        $basket->setName("Facture");
        $basket->setIsPayed(true);
        $this->entityManager->persist($basket);

        $invoice = new Invoice();
        $invoice->setBasketId($basket);
        $invoice->setName("Facture");
        $invoice->setCreatedAt($now);
        $this->entityManager->persist($invoice);
        
        $this->entityManager->flush();

        if ($user && $user->isVerified()) {
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('raul3wa@gmail.com', 'Carrée de la mode'))
                    ->to($user->getEmail())
                    ->subject('Confirmation de commande')
                    ->htmlTemplate('emails/confirm_cmde.html.twig')
                    ->context([
                        'user' => $user,
                        'invoice' => $invoice,
                    ])
            );
        }
        
        $this->addFlash("success", "Payement effectuer. Vous recevrez votre facture par mail à l'adresse ".$basket->getUserId()->getEmail().".");

        return $this->redirectToRoute('home');
    }
}
