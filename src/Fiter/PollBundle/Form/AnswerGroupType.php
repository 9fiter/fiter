<?php

namespace Fiter\PollBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AnswerGroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('clientIp')
            //->add('author')
            ->add('createdAt', 'genemu_jquerydate', array(
                'widget' => 'single_text'
            ))
            ->add('poll')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fiter\PollBundle\Entity\AnswerGroup'
        ));
    }

    public function getName()
    {
        return 'fiter_pollbundle_answergrouptype';
    }
}
