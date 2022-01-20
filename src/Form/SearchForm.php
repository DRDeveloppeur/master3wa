<?php

namespace App\Form;

use App\Data\SearchData;
use App\Entity\Categorie;
use App\Entity\Mark;
use App\Entity\Stock;
use App\Entity\SubCategorie;
use App\Repository\StockRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('q', HiddenType::class)
            ->add('categories', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Categorie::class,
                'expanded' => true,
                'multiple' => true
            ])
            ->add('marques', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Mark::class,
                'expanded' => true,
                'multiple' => true
            ])
            ->add('subCategories', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => SubCategorie::class,
                'expanded' => true,
                'multiple' => true
            ])
            ->add('sizes', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Stock::class,
                'expanded' => true,
                'multiple' => true,
                'choice_value' => 'size',
                'query_builder' => function(StockRepository $entityRepository)
                {
                    return $entityRepository->createAlphabeticalQueryBuilder();
                }
            ])
            ->add('promo', HiddenType::class);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}