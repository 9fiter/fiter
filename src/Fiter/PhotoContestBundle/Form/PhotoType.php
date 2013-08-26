<?php

namespace Fiter\PhotoContestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PhotoType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $locale = $options['label'];

        $builder
            ->add('titulo', 'text' ,array(
                 'label'=> 'main.title',
                 'required' => true,
            ))
            //->add('contest', null ,array(
            //     'label'=> 'main.photoContest',
            //))
            //->add('contest', 'hidden' )
            ->add('imagen', 'file' ,array(
                 'required' => true,
                 'label'=> 'main.image',
            ))
            ->add('descripcion', 'ckeditor', array(
                 'language' => $locale,
                 'label'=> 'main.description',
            ))
            ->add('aleatorio', 'hidden', array('data' => 'true'))
            //->add('activarComentarios')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array(
            'data_class' => 'Fiter\PhotoContestBundle\Entity\Photo'
        ));
    }
    public function getName(){
        return 'fiter_photocontestbundle_phototype';
    }
}
