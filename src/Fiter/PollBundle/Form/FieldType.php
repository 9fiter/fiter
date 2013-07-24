<?php

namespace Fiter\PollBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FieldType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'label' => 'main.answer'
            ))
            // ->add('description', 'textarea', array(
            //     'label' => 'main.description'
            // ))
            // ->add('assetPath', 'text', array(
            //     'label' => 'main.assetPath'
            // ))
            // ->add('position', 'text', array(
            //     'label' => 'main.position'
            // ))
            // ->add('validationConstraints', 'text', array(
            //     'label' => 'main.validationConstraints'
            // ))
            // ->add('type', 'text', array(
            //     'label' => 'main.type'
            // ))
            // ->add('createdAt', 'genemu_jquerydate', array(
            //     'widget' => 'single_text',
            //     'label' => 'main.createdAt'
            // ))
            // ->add('deletedAt', 'genemu_jquerydate', array(
            //     'widget' => 'single_text',
            //     'label' => 'main.deletedAt'
            // ))
            // ->add('isActive', 'checkbox', array(
            //      'required' => false,
            //      'label'=> 'main.isActive',
            //      'attr' => array('class' => 'myValue'),
            // ))
            
            // ->add('required', 'checkbox', array(
            //      'label'=> 'main.required',
            //      'attr' => array('class' => 'myValue'),
            // ))
            // ->add('poll', 'entity', array(
            //     'class' => 'FiterPollBundle:Poll',
            //     'label' => 'main.poll'
            // ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array(
            'data_class' => 'Fiter\PollBundle\Entity\Field'
        ));
    }

    public function getName()
    {
        return 'fiter_pollbundle_fieldtype';
    }
}
