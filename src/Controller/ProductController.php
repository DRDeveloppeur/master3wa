<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Repository\StockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/{model}/{ref}/{stock_id}", name="product")
     */
    public function index($model, $ref, $stock_id = null, ProductRepository $productRepository, StockRepository $stockRepository): Response
    {
        $product = $productRepository->findOneBy(["ref" => $ref]);
        
        if ($stock_id) {
            $stk = $stockRepository->findOneBy(["id" => $stock_id]);
        } else {
            $stk = null;
        }

        return $this->render('product/index.html.twig', [
            'product' => $product,
            'stk' => $stk,
        ]);
    }
}
