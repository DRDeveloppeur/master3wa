<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Entity\Delivery;
use App\Entity\Image;
use App\Entity\Invoice;
use App\Entity\Mark;
use App\Entity\Product;
use App\Entity\Stock;
use App\Entity\Store;
use App\Entity\SubCategorie;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        // return parent::index();
        // $routeBuilder = $this->get(CrudUrlGenerator::class)->build();
        // $url = $routeBuilder->setController(ProductCrudController::class)->generateUrl();

        // return $this->redirect($url);
        return $this->render("bundles/EasyAdminBundle/welcome.html.twig", [
            'user' => []
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Carré De La Mode');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToRoute('Back to site', 'fas fa-globe-europe', 'home');
        yield MenuItem::section('BDD');
        yield MenuItem::linkToCrud('Catégorie', 'fas fa-list', Categorie::class);
        yield MenuItem::linkToCrud('Mode de livraison', 'fas fa-list', Delivery::class);
        yield MenuItem::linkToCrud('Images produit', 'fas fa-list', Image::class);
        yield MenuItem::linkToCrud('Factures', 'fas fa-list', Invoice::class); // à voir si on garde
        yield MenuItem::linkToCrud('Marque', 'fas fa-list', Mark::class);
        yield MenuItem::linkToCrud('Produit', 'fas fa-list', Product::class);
        yield MenuItem::linkToCrud('Stock', 'fas fa-list', Stock::class);
        yield MenuItem::linkToCrud('Magasins', 'fas fa-list', Store::class);
        yield MenuItem::linkToCrud('Sous-Catégorie', 'fas fa-list', SubCategorie::class);
        // yield MenuItem::linkToCrud('Utilisateur', 'fas fa-list', User::class);
    }
}
