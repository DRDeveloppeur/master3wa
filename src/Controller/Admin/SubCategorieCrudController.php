<?php

namespace App\Controller\Admin;

use App\Entity\SubCategorie;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SubCategorieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SubCategorie::class;
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Sous-categorie')
            ->setEntityLabelInPlural('Sous-categories')
            ->setPaginatorPageSize(10)
            ->setSearchFields(['name', 'categorie_id'])
            ->setDefaultSort(['id' => 'DESC']);
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('name')
            ->add('categorie_id')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'Nom')->setColumns(2);
        yield AssociationField::new('categorie_id', 'Catégorie')->setColumns(2);
    }
}
