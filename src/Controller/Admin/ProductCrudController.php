<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Entity\Stock;
use App\Controller\Admin\StockCrudController;
use App\Repository\ProductRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        // return Stock::class;
        return Product::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Produit')
            ->setEntityLabelInPlural('Produits')
            ->setPaginatorPageSize(10)
            ->setSearchFields(['ref', 'categorie_id.name', 'sub_categorie_id.name', 'mark_id.name', 'model', 'tag'])
            // ->setEntityPermission('ROLE_ADMIN')
            ->setDefaultSort(['id' => 'DESC']);
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IntegerField::new('ref', 'Réf')->setColumns(2);
        yield TextField::new('model', 'Modèl')->setColumns(2);
        yield ChoiceField::new('tag', 'Tag')
            ->autocomplete()
            ->setChoices([
                "Épuisé" => "Épuisé",
                "Nouveau" => "Nouveau",
                "Solde" => "Solde",
            ])
            ->setColumns(3);
        yield ImageField::new('images[0]', 'Image')
            ->setBasePath('uploads/products/')
            ->setUploadDir('public/uploads/products')
            ->onlyOnIndex();
        yield TextField::new('ray', 'Rayon')->setColumns(2);
        yield FormField::addRow();
        yield AssociationField::new('mark_id', "Marque")->setColumns(3);
        yield AssociationField::new('categorie_id', "Catégorie")->setColumns(3);
        yield AssociationField::new('sub_categorie_id', "Sub-Catégorie")->setColumns(3);
        yield FormField::addRow();
        yield TextEditorField::new('description');
        // yield FormField::addPanel("Stock");
        // yield CollectionField::new('images')->hideOnIndex();
        // yield AssociationField::new('stocks.size')->hideOnIndex();
    }
}
