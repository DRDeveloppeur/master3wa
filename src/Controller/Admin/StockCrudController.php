<?php

namespace App\Controller\Admin;

use App\Entity\Stock;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class StockCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Stock::class;
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Produit')
            ->setEntityLabelInPlural('Produits')
            ->setPaginatorPageSize(10)
            ->setSearchFields(['amount', 'size', 'color', 'matter', 'price', 'store_id', 'product_id'])
            ->setDefaultSort(['id' => 'DESC']);
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('store_id')
            ->add('product_id')
            ->add('price')
            ->add('amount')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IntegerField::new('amount', 'En stock')->setColumns(2);
        yield TextField::new('size', 'Taille')->setColumns(2);
        yield TextField::new('color', 'Couleur')->setColumns(2);
        yield TextField::new('matter', 'Matière')->setColumns(2);
        yield MoneyField::new('price', 'Prix')->setColumns(2)->setCurrency('EUR');
        yield AssociationField::new('product_id', 'Produit')->setColumns(2);
        yield AssociationField::new('store_id', 'Magasin')->setColumns(2);
    }
}
