<?php

namespace Fiter\PhotoContestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContestType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        $locale = $options['label'];
        $builder
            ->add('titulo')
            ->add('activo', 'checkbox', array(
                 'required' => false,
                 'label'=> 'main.active',
            ))
            ->add('activarComentarios', 'checkbox' ,array(
                 'required' => false,
                 'label'=> 'Activar comentarios',
            ))
            ->add('imagen', 'file' ,array(
                 'required' => true,
                 'label'=> 'main.image',
            ))
            ->add('descripcion', 'ckeditor', array(
                 'language' => $locale,
                 'label'=> 'main.description',
            ))
            ->add('aleatorio', 'hidden', array('data' => 'true'))

            //->add('fechaInicio', 'genemu_jquerydate')
            ->add('fechaInicio', 'genemu_jquerydate', array(
                'widget' => 'single_text',
                'label'=> 'main.fechaInicio',
            ))
            ->add('fechaVotaciones', 'genemu_jquerydate', array(
                'widget' => 'single_text',
                'label'=> 'main.fechaVotaciones',
            ))
            ->add('fechaFin', 'genemu_jquerydate', array(
                'widget' => 'single_text',
                'label'=> 'main.fechaFin',
            ))
            
        ;
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array(
            'data_class' => 'Fiter\PhotoContestBundle\Entity\Contest'
        ));
    }
    public function getName(){
        return 'fiter_photocontestbundle_contesttype';
    }
}
