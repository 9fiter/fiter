<?php

namespace Fiter\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticuloType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            //->add('usuario')
            ->add('activo', 'checkbox', array(
                 'required' => false,
                 'label'=> 'main.active',
                 'attr' => array('class' => 'myValue'),
            ))
            ->add('titulo', 'text' ,array(
                 'label'=> 'main.title',
            ))
            ->add('categoria', null ,array(
                 'label'=> 'main.categorias',
            ))
            ->add('mostrarImagen', 'checkbox', array(
                 'required' => false,
                 'label'=> 'main.showImage',
            ))
            ->add('imagen', 'file' ,array(
                 'required' => false,
                 'label'=> 'main.image',
            ))
            ->add('contenido', 'ckeditor', array(
                 'language' => "es_ES",
                 'label'=> 'main.content',
            ))
            ->add('aleatorio', 'hidden', array('data' => 'true'))
            //->add('videosYoutube', 'collection', array('type' => new VideoYoutubeType()))
                
            ->add('videosYoutube', 'collection', array(
                 'required' => false,
                  'type' => new VideoYoutubeType(),
                  'allow_add' => true,
                  'allow_delete' => true,
                  'by_reference' => false,
                  'label'=> ' ',
            ))
            ->add('listasYoutube', 'collection', array(
                 'required' => false,
                  'type' => new ListaYoutubeType(),
                  'allow_add' => true,
                  'allow_delete' => true,
                  'by_reference' => false,
                  'label'=> ' ',
            ))
            ->add('canalYoutube','text' , array(
                  'required' => false,
                  'label'=> 'main.yt_channel',
            ))
            ->add('rss','text' , array(
                  'required' => false,
                  'label'=> 'Rss'
            ))
            ->add('twitter','text' , array(
                  'required' => false,
                  'label'=> 'twitter'
            )) 
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fiter\DefaultBundle\Entity\Articulo'
        ));
    }

    public function getName()
    {
        return 'fiter_adminbundle_articulotype';
    }
}
