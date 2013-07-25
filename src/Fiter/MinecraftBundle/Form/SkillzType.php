<?php

namespace Fiter\MinecraftBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SkillzType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('player')
            ->add('skill')
            ->add('xp')
            ->add('level')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fiter\MinecraftBundle\Entity\Skillz'
        ));
    }

    public function getName()
    {
        return 'fiter_minecraftbundle_skillztype';
    }
}
