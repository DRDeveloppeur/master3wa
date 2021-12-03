<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Utilisateur')
            ->setEntityLabelInPlural('Utilisateurs')
            ->setPaginatorPageSize(20)
            ->setSearchFields(['email', 'roles', 'civility', 'firstname', 'lastname', 'address', 'aditional_address', 'city', 'zip_code', 'country', 'phone', 'home_phone', 'birth'])
            ->setDefaultSort(['id' => 'DESC']);
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('roles', ["ROLE_ADMIN", "ROLE_USER"])
            ->add('email')
            ->add('civility')
            ->add('firstname')
            ->add('lastname')
            ->add('address')
            ->add('city')
            ->add('zip_code')
            ->add('country')
            ->add('phone')
            ->add('home_phone')
            ->add('birth')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield ChoiceField::new('civility', 'Civiliité')
            ->autocomplete()
            ->setChoices([
                'Monsieur' => 'M.',
                'Madame' => 'Mme.',
                'Mademoiselle' => 'Mlle.',
            ])
            ->setColumns(3);
        yield TextField::new('firstname', 'Prenom')->setColumns(2);
        yield TextField::new('lastname', 'Nom')->setColumns(2);
        yield EmailField::new('email')->setColumns(2);
        yield ChoiceField::new('roles', 'Roles')
            ->allowMultipleChoices()
            ->autocomplete()
            ->setChoices([
                "Utilisateur" => "ROLE_USER",
                "Admin" => "ROLE_ADMIN",
                "Super Admin" => "ROLE_SUPER_ADMIN",
            ])
            ->setColumns(4);
        yield TextField::new('password', 'Mot de passe')
            ->setFormType(PasswordType::class)
            ->setRequired($pageName === Crud::PAGE_NEW)
            ->onlyOnForms()
            ->hideWhenUpdating();
        yield TextField::new('address', 'Adresse')->setColumns(3);
        yield TextField::new('aditional_address', 'Adresse complémentaire')->hideOnIndex()->setColumns(3);
        yield TextField::new('city', 'Ville')->setColumns(3);
        yield TextField::new('zip_code', 'Code postale')->setColumns(3);
        yield ChoiceField::new('country', 'Pays')
            ->autocomplete()
            ->setChoices([
                'France' => 'FR',
                'Suisse' => 'CH',
            ])
            ->setColumns(3);
        yield FormField::addRow();
        yield TelephoneField::new('phone', 'Portable')->setColumns(3);
        yield TelephoneField::new('home_phone', 'Fix')->setColumns(3);
        yield DateField::new('birth', 'Date de naissance')->setColumns(3);
        yield FormField::addRow();
        yield BooleanField::new('isVerified', 'Vérifier')->setColumns(3);
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->encodePassword($entityInstance);
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->encodePassword($entityInstance);
        parent::updateEntity($entityManager, $entityInstance);
    }

    private function encodePassword(User $user)
    {
        if ($user->getPassword() !== null) {
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
        }
    }
}
