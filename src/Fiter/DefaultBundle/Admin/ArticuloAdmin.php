<?php

namespace Fiter\DefaultBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

use Fiter\AdminBundle\Form\VideoYoutubeType;
use Fiter\AdminBundle\Form\ListaYoutubeType;

 
class ArticuloAdmin extends Admin{

	protected function configureListFields(ListMapper $mapper){
        $mapper
            ->add('activo')
            ->addIdentifier('titulo', null, array('label' => 'Título'))
            ->add('categoria')
            ->add('subCategoria')
            ->add('mostrarImagen')
            ->add('mostrarContenido')
            //->add('contenido')
            ->add('videosYoutube')
            ->add('listasYoutube')
            ->add('canalYoutube')
            ->add('rss')
            ->add('twitter')
        ;
    }
    protected function configureDatagridFilters(DatagridMapper $mapper){
        $mapper
            ->add('activo')
            ->add('titulo')
            ->add('categoria')
            ->add('subCategoria')
            ->add('mostrarImagen')
            ->add('mostrarContenido')
            ->add('canalYoutube')
            ->add('rss')
            ->add('twitter')
        ;
    }

    protected function configureFormFields(FormMapper $mapper){
        $mapper
        	->add('activo')
            ->add('titulo')


            ->add('titulo-i18n', 'translatable_field', array(
                'field'                => 'titulo',
                'personal_translation' => 'Fiter\DefaultBundle\Entity\Translation\ArticuloTranslation',
                'property_path'        => 'translations',
                'widget'               => 'text',
            ))




            ->add('usuario')
            //->add('categoria')
            ->add('categoria', 'sonata_type_model', array(
                'by_reference' => true,
                'multiple' => true,
                'expanded' => true,
                'compound' => true,
                'required' => true,
            ))
            ->add('subCategoria', 'sonata_type_model', array(
                'by_reference' => true,
                'multiple' => true,
                'expanded' => true,
                'compound' => true,
                'required' => false,
            ))          
            //->add('mostrarImagen')
            ->add('mostrarImagen', null, array(
                'required' => false,
            )) 




            //->add('imagen', 'file', array('required' => false))
            //->add('mostrarContenido')
            ->add('mostrarContenido', null, array(
                'required' => false,
            )) 
            //->add('contenido')
            ->add('contenido', 'ckeditor', array(
                 'language' => 'es',
                 'label'=> 'main.content',
            ))
            ->add('contenidoI18n', 'translatable_field', array(
                'field'                => 'contenido',
                'personal_translation' => 'Fiter\DefaultBundle\Entity\Translation\ArticuloTranslation',
                'property_path'        => 'translations',
                'widget'               => 'ckeditor',
            ))




           



            ->add('videosYoutube', 'sonata_type_model', array(
                'by_reference' => true,
                'multiple' => true,
                'expanded' => true,
                'compound' => true,
                'required' => false,
            ))  
            ->add('listasYoutube', 'sonata_type_model', array(
                'by_reference' => true,
                'multiple' => true,
                'expanded' => true,
                'compound' => true,
                'required' => false,
            ))  
            ->add('canalYoutube')
            // ->add('videosYoutube', 'sonata_type_collection', array(
            //      'required' => false,
            //       'type' => new VideoYoutubeType(),
            //       //'allow_add' => true,
            //       //'allow_delete' => true,
            //       'by_reference' => false,
            //       'label'=> 'VideoYoutube',
            // ))
            // ->add('videosYoutube', 'sonata_type_collection',
            //     array('by_reference' => false),
            //     array(
            //        'edit' => 'inline',
            //        'sortable' => 'pos',
            //        'inline' => 'table',
            // ))
            // ->add('videosYoutube', 'sonata_type_collection', array(), array(
            //     'edit' => 'inline',
            //     'inline' => 'table',
            //     'sortable'  => 'position'
            // ))
            //->add('videosYoutube', 'sonata_type_model', array('expanded' => true))
            //->add('videosYoutube', 'sonata_type_model', array(), array('edit' => 'list'))
            // ->add('videosYoutube', 'sonata_type_admin', array(
            //     'data_class'=> null,
            //     'required' => false,
            //     //'edit' => 'inline',
            //     //'class'    => 'FiterDefaultBundle:VideoYoutube',
            //     //'expanded' => true,
            //     'by_reference' => false,
            //     //'multiple' => true
            // ))
            // ->add('listasYoutube', 'collection', array(
            //      'required' => false,
            //       'type' => new ListaYoutubeType(),
            //       'allow_add' => true,
            //       'allow_delete' => true,
            //       'by_reference' => false,
            //       'label'=> 'ListaYoutube',
            // ))
            // ->add('videosYoutube','collection', array(
            //   'type' =>  new VideoYoutubeType(),
            //   'allow_add' => true,
            //   'prototype' => true,
            //   'by_reference' => true,
            // ))
            ->add('rss')
            ->add('twitter')
            

            
        ;
    }
}