<?php

namespace Fiter\DefaultBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
 
class CategoriaAdmin extends Admin{

	protected function configureListFields(ListMapper $mapper){
        $mapper
        ->addIdentifier('nombre', null)
        ->add('subCategoria')
        //->add('imagen')
        ->add('imagen', 'file', array('required' => false));
        ;
    }
    protected function configureDatagridFilters(DatagridMapper $mapper){
        $mapper
            ->add('nombre')
        ;
    }
    protected function configureFormFields(FormMapper $mapper){
        $mapper
            ->add('nombre', null, array('required' => true) )
            ->add('nombre-i18n', 'translatable_field', array(
                'field'                => 'titulo',
                'personal_translation' => 'Fiter\DefaultBundle\Entity\Translation\CategoriaTranslation',
                'property_path'        => 'translations',
                'widget'               => 'text',
            ))
            ->add('usuario')
            ->add('subCategoria', 'sonata_type_model', array(
                'by_reference' => true,
                'multiple' => true,
                'expanded' => true,
                'compound' => true,
                'required' => true,
            )) 
            ->add('imagen', 'file', array('required' => false))
            ->add('aleatorio', 'hidden', array('data' => 'true'))
        ;
    }
}