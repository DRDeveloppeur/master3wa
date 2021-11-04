<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Produit')
            ->setEntityLabelInPlural('Produits')
            ->setPaginatorPageSize(10)
            ->setSearchFields(['ref', 'categorie.name', 'subCategorie.id', 'mark_id', 'model', 'tag'])
            ->setDefaultSort(['id' => 'DESC']);
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            // ->add(EntityFilter::new('Mark'))
            ->add('mark_id')
            // ->add(EntityFilter::new('categorie'))
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('ref', 'Réf')->setColumns(2);
        yield TextField::new('model', 'Modèl')->setColumns(2);
        yield ChoiceField::new('tag', 'Tag')
            ->autocomplete()
            ->setChoices([
                "Épuisé" => "Épuisé",
                "Nouveau" => "Nouveau",
                "Solde" => "Solde",
            ])
            ->setColumns(3);
        yield ImageField::new('pictures[0]', 'Image')
            ->setBasePath('uploads/product/')
            ->setUploadDir('public/uploads/product')
            ->onlyOnIndex();
        yield TextField::new('ray', 'Rayon')->setColumns(2);
        yield AssociationField::new('mark_id')->setColumns(3);
        yield AssociationField::new('categorie_id')->setColumns(3);
        yield AssociationField::new('sub_categorie_id')->setColumns(3);
        yield FormField::addPanel();
        yield TextEditorField::new('description')->hideOnIndex();
    }
}
