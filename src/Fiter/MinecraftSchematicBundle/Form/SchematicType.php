<?php

namespace Fiter\MinecraftSchematicBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SchematicType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){

        $locale = $options['label'];

        $builder
            ->add('activo', 'checkbox', array(
                 'required' => false,
                 'label'=> 'main.active',
                 'attr' => array('class' => 'myValue'),
            ))
            ->add('activarComentarios', 'checkbox', array(
                 'required' => false,
                 'label'=> 'Activar comentarios',
            ))
            ->add('titulo', 'text' ,array(
                 'label'=> 'main.title',
                 'required' => true,
            ))
            //->add('categoria', null ,array(
            //     'label'=> 'main.categorias',
            //))
            //->add('subCategoria', null ,array(
            //     'label'=> 'main.subcategorias',
            //     'required' => false,
            //))
            ->add('mostrarImagen', 'checkbox', array(
                 'required' => false,
                 'label'=> 'main.showImage',
            ))
            ->add('mostrarMiniaturas', 'checkbox', array(
                 'required' => false,
                 'label'=> 'main.showMiniaturas',
            ))
            ->add('mostrarSlide', 'checkbox', array(
                 'required' => false,
                 'label'=> 'main.showSlide',
            ))
            ->add('mostrarContenido', 'checkbox', array(
                 'required' => false,
                 'label'=> 'main.showContent',
            ))    
            ->add('imagen', 'file' ,array(
                 'required' => false,
                 'label'=> 'main.image',
            ))
            ->add('contenido', 'ckeditor', array(
                 'language' => $locale,
                 'label'=> 'main.content',
            ))
            ->add('aleatorio', 'hidden', array('data' => 'true'))
            ->add('schematic', 'file' ,array(
                 'required' => false,
                 'label'=> 'main.schematic',
            ))


            ////->add('videosYoutube', 'collection', array('type' => new VideoYoutubeType()))  
            //->add('videosYoutube', 'collection', array(
            //     'required' => false,
            //      'type' => new VideoYoutubeType(),
            //      'allow_add' => true,
            //      'allow_delete' => true,
            //      'by_reference' => false,
            //      'label'=> ' ',
            //))
        ;



    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fiter\MinecraftSchematicBundle\Entity\Schematic'
        ));
    }

    public function getName()
    {
        return 'fiter_minecraftschematicbundle_schematictype';
    }
}
