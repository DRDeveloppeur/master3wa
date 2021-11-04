<?php

namespace App\Controller\Admin;

use App\Entity\Mark;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MarkCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Mark::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Marque')
            ->setEntityLabelInPlural('Marques')
            ->setPaginatorPageSize(10)
            ->setSearchFields(['name', 'description'])
            ->setDefaultSort(['id' => 'DESC']);
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
        yield TextField::new('name', 'Nom');
        yield ImageField::new('logo', 'Logo')
            ->setBasePath('uploads/marque/')
            ->setUploadDir('public/uploads/marque')
            ->hideWhenUpdating();
        // yield FormField::addPanel('Contact information')
        //     ->setIcon('phone')->addCssClass('optional')
        //     ->setHelp('Phone number is preferred');
        // yield TextEditorField::new('description');
    }
}
