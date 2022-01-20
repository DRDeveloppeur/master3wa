<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Form\SearchForm;
use App\Repository\MarkRepository;
use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatalogueController extends AbstractController
{
    /**
     * @Route("/catalogue", name="catalogue")
     */
    public function index(ProductRepository $productRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $data = new SearchData();
        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);

        $produits = $productRepository->findSearch($data);
        $filters = $produits["filters"] ?? "";
        $produits = $produits["result"];

        $products = $paginator->paginate(
            $produits,
            $request->get('page', 1),
            24
        );
        return $this->render('catalogue/index.html.twig', [
            'products' => $products,
            'form' => $form->createView(),
            'filters' => $filters,
        ]);
    }
}
