<?php

namespace Fiter\MinecraftAuthBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AuthmeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            //->add('password')
            ->add('ip')
            ->add('lastlogin')
            ->add('x')
            ->add('y')
            ->add('z')
            ->add('world')
            ->add('email')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fiter\MinecraftAuthBundle\Entity\Authme'
        ));
    }

    public function getName()
    {
        return 'fiter_minecraftauthbundle_authmetype';
    }
}
