<?php

namespace AppBundle\Form;

use AppBundle\Entity\ProductImages;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Yavin\Symfony\Form\Type\TreeType;
class ProductsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array('label' => 'Название'))
            ->add('description', TextareaType::class, array('label' => 'Описание',
        'attr'   =>  array(
            'class'   => 'description-field')))
            ->add('price', MoneyType::class, array('label' => 'Цена', 'currency'=> null))
            ->add('currency', EntityType::class , array('label' => 'Валюта','class' => 'AppBundle:Currency', 'empty_data'  => null, 'required' => true, 'choice_label' => 'name'))
            ->add('availability', ChoiceType::class , array('label' => 'Наличие',
                'choices'  => array(
                    'В наличии' => 'В наличии',
                    'Нет в наличии' => 'Нет в наличии')))
            ->add('manufacturer',EntityType::class, array('label' => 'Продавец','class' => 'AppBundle:Manufacturer', 'empty_data'  => null, 'placeholder' => 'Выберите продавца', 'required' => false, 'choice_label' => 'name'))
            ->add('files', CollectionType::class,array('label' => 'Файл',
                'entry_type' => FilesType::class,
                'allow_add' => true,
                'by_reference' => false
            ))
            ->add('category', TreeType::class, [
                'class' => 'AppBundle:Category', // tree class
                'levelPrefix' => '-',
                'orderFields' => ['treeLeft' => 'asc'],
                'prefixAttributeName' => 'data-level-prefix',
                'treeLevelField' => 'treeLevel',]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Products'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_products';
    }


}
