<?php

namespace Fiter\DefaultBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MedioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('usuario')
            ->add('activo', 'checkbox', array(
                 'required' => false,
                 'label'=> 'Publicado',
                 'attr' => array('class' => 'myValue'),
            ))
            ->add('titulo')
            ->add('categoria')
            ->add('imagen')
            ->add('mostrarImagen', 'checkbox', array(
                 'required' => false,
                 'label'=> 'Mostrar imagen',
            ))    
            ->add('mostrarContenido', 'checkbox', array(
                 'required' => false,
                 'label'=> 'Mostrar contenido',
            ))   
            ->add('contenido', 'ckeditor')
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
                  'label'=> 'Canal de youtube',
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
            'data_class' => 'Fiter\DefaultBundle\Entity\Medio'
        ));
    }

    public function getName()
    {
        return 'fiter_defaultbundle_mediotype';
    }
}
