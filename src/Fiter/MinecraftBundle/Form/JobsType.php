<?php

namespace Fiter\MinecraftBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class JobsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('experience')
            ->add('level')
            ->add('job')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fiter\MinecraftBundle\Entity\Jobs'
        ));
    }

    public function getName()
    {
        return 'fiter_minecraftbundle_jobstype';
    }
}
