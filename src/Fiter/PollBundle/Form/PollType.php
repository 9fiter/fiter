<?php

namespace Fiter\PollBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PollType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'label' => 'main.question'
            ))
            ->add('isActive', 'checkbox', array(
                 'required' => false,
                 'attr' => array('class' => 'myValue'),
                 'label' => 'main.isActive'
            ))
            ->add('principal', 'checkbox', array(
                 'required' => false,
                 'label' => 'main.principal'
            ))
            ->add('answersVisible', 'checkbox', array(
                 'required' => false,
                 'attr' => array('class' => 'myValue'),
                 'label' => 'main.answersVisible'
            ))
            ->add('endAt', 'genemu_jquerydate', array(
                'widget' => 'single_text',
                'label' => 'main.endAt'
            ))
            ->add('fields', 'collection', array(
                 'required' => false,
                  'type' => new FieldType(),
                  'allow_add' => true,
                  'allow_delete' => true,
                  'by_reference' => false,
                  'label'=> ' ',
            ))
            // ->add('createdAt', 'genemu_jquerydate', array(
            //     'widget' => 'single_text',
            //     'label' => 'main.createdAt'
            // ))
            // ->add('deletedAt', 'genemu_jquerydate', array(
            //     'widget' => 'single_text',
            //     'label' => 'main.deletedAt'
            // ))
            // ->add('startAt', 'genemu_jquerydate', array(
            //     'widget' => 'single_text',
            //     'label' => 'main.startAt'
            // ))
            // ->add('type', 'text', array(
            //     'label' => 'main.type'
            // ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fiter\PollBundle\Entity\Poll'
        ));
    }

    public function getName()
    {
        return 'fiter_pollbundle_polltype';
    }
}
