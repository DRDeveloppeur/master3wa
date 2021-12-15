<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('civility', ChoiceType::class, [
                'choices'  => [
                    'Monsieur' => 'M.',
                    'Madame' => 'Mme.',
                    'Mademoiselle' => 'Mlle.',
                ],
            ])
            ->add('firstname')
            ->add('lastname')
            ->add('address', TextType::class)
            ->add('aditional_address', TextType::class, [
                'required' => false,
            ])
            ->add('city')
            ->add('zip_code')
            ->add('country', ChoiceType::class, [
                'choices'  => [
                    'France' => 'FR',
                    'Suisse' => 'CH',
                ],
            ])
            ->add('phone')
            ->add('home_phone')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
