<?php

namespace App\Controller\Admin;

use App\Entity\Store;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class StoreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Store::class;
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Magasin')
            ->setEntityLabelInPlural('Magasins')
            ->setPaginatorPageSize(10)
            ->setSearchFields(['nom', 'address', 'zip_code', 'city', 'phone'])
            ->setDefaultSort(['id' => 'DESC']);
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('name')
            ->add('country')
            // ->add(EntityFilter::new('Categorie'))
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'Nom')->setColumns(2);
        yield TextField::new('address', 'Adresse')->setColumns(2);
        yield TextField::new('zip_code', 'Code postal')->setColumns(2);
        yield TextField::new('city', 'Ville')->setColumns(2);
        yield ChoiceField::new('country', 'Pays')
            ->setChoices([
                "France" => "FR",
                "Suisse" => "CH",
            ])
            ->setColumns(2);
        yield TextField::new('phone', 'Téléphone')->setColumns(2);
    }
}
