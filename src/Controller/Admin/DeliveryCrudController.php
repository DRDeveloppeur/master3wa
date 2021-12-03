<?php

namespace App\Controller\Admin;

use App\Entity\Delivery;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DeliveryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Delivery::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Mode de livraison')
            ->setEntityLabelInPlural('Modes de livraison')
            ->setSearchFields(['name', 'threshold', 'price_before', 'price_after'])
            ->setDefaultSort(['name' => 'DESC']);
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('name')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'Libellé')->setColumns(3);
        yield FormField::addPanel();
        yield MoneyField::new('threshold', 'Seuil')->setColumns(3)->setCurrency('EUR');
        yield MoneyField::new('price_before', 'Prix de la livraison avant le seuil')->setColumns(3)->setCurrency('EUR');
        yield MoneyField::new('price_after', 'Prix de la livraison après le seuil')->setColumns(3)->setCurrency('EUR');
        yield FormField::addPanel();
        yield TextEditorField::new('description');
    }
}
