<?php

namespace Fiter\DefaultBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SubCategoriaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('categoria')
            ->add('imagen')
            //->add('slug')
            //->add('fechaPublicacion')
            //->add('fechaActualizacion')
            //->add('activo')
            //->add('visitas')
            //->add('likes')
            //->add('usuario')
            //->add('orden')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fiter\DefaultBundle\Entity\SubCategoria'
        ));
    }

    public function getName()
    {
        return 'fiter_defaultbundle_subcategoriatype';
    }
}
