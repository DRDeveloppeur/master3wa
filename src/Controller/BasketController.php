<?php

namespace App\Controller;

use App\Entity\Basket;
use App\Entity\Order;
use App\Repository\BasketRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Repository\StockRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class BasketController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->entityManager = $manager;
    }

    /**
     * @Route("/basket/{stock_id}/{product_id}", name="basket")
     */
    public function index($stock_id, $product_id, StockRepository $stockRepository, ProductRepository $productRepository, BasketRepository $basketRepository, OrderRepository $orderRepository, UserInterface $user = null, Request $request): Response
    {
        $product = $productRepository->find($product_id);
        $stock = $stockRepository->find($stock_id);
        
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
}
