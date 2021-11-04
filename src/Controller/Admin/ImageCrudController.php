<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class ImageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Image::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Image')
            ->setEntityLabelInPlural('Images')
            ->setPaginatorPageSize(10)
            ->setSearchFields(['productId', 'path'])
            ->setDefaultSort(['id' => 'DESC']);
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('product_id')
            ->add('path')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('product_id', 'Produit')->setColumns(3);
        yield ImageField::new('path', 'Image')
            ->setBasePath('uploads/product/')
            ->setUploadDir('public/uploads/product')
            ->setCustomOption('multiple', true)
            // ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->hideWhenUpdating();
    }
}
