<?php

namespace Fiter\MinecraftDonationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){

        $builder
            ->add('activo', 'checkbox', array(
                 'required' => false,
                 'label'=> 'main.active',
                 'attr' => array('class' => 'myValue'),
            ))
            ->add('mostrarImagen', 'checkbox', array(
                 'required' => false,
                 'label'=> 'main.showImage',
            ))
            ->add('imagen', 'file' ,array(
                 'required' => false,
                 'label'=> 'main.image',
            ))
            ->add('aleatorio', 'hidden', array('data' => 'true'))






            ->add('name', 'text', array(
                 'label'=> 'main.name',
            ))
            ->add('description', 'ckeditor', array(
                 'language' => "es_ES",
                 'label'=> 'main.description',
            ))
            ->add('price', 'text', array(
                 'label'=> 'main.price',
            ))
            ->add('expiresin', 'text', array(
                 'label'=> 'main.expiresin',
            ))
            //->add('category', 'text', array(
            //     'label'=> 'main.category',
            //))
            //->add('stocklimit', 'text', array(
            //     'label'=> 'main.stocklimit',
            //))
            //->add('userlimit', 'text', array(
            //     'label'=> 'main.userlimit',
            //))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fiter\MinecraftDonationBundle\Entity\Product'
        ));
    }

    public function getName()
    {
        return 'fiter_minecraftdonationbundle_producttype';
    }
}
