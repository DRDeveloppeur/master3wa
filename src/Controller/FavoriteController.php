<?php

namespace App\Controller;

use App\Entity\Basket;
use App\Entity\Order;
use App\Repository\BasketRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Repository\StockRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class FavoriteController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->entityManager = $manager;
    }
    
    /**
     * @Route("/favorite/{product_id}", name="favorite")
     */
    public function index($product_id, ProductRepository $productRepository, StockRepository $stockRepository, OrderRepository $orderRepository, BasketRepository $basketRepository, UserInterface $user = null, Request $request): Response
    {
        $product = $productRepository->find($product_id);
        $stock = $stockRepository->findAll();
        $stock = $stock[0];

        if ($user) {
            $user_basket = $basketRepository->findOneBy([
                'user_id' => $user,
                'name' => 'Favoris'
            ]);
            $now = new DateTime('now');

            if (!$user_basket) {
                $basket = new Basket();
                $basket->setUserId($user);
                $basket->setName("Favoris");
                $basket->setIsPayed(false);
                $basket->setRefOrder(uniqid());
                $basket->setCreatedAt($now);
                $this->entityManager->persist($basket);
            } else {
                $basket = $user_basket;
            }
            
            $basket_order = $orderRepository->findOneBy([
                'basket_id' => $basket,
                'product_id' => $product_id
            ]);
            if ($basket_order) {
                $basket->removeOrder($basket_order);
                $this->entityManager->persist($basket);
            } else {
                $order = new Order();
                $order->setBasketId($basket);
                $order->setProductId($product);
                $order->setStockId($stock);
                $order->setAmount(1);
                $this->entityManager->persist($order);
            }

            // foreach ($basket->getOrders() as $key => $value) {
            //     dd($key, $value);
            // }

            $this->entityManager->flush();
        }
        
        return new RedirectResponse($request->headers->get('referer'));
        
        // return $this->redirect($request->getReferer());
    }
}
