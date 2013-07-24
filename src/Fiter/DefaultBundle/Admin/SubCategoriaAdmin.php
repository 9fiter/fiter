<?php

namespace Fiter\DefaultBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
 
class SubCategoriaAdmin extends Admin{

	protected function configureListFields(ListMapper $mapper){
        $mapper
        ->addIdentifier('nombre', null)
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
                'field'                => 'nombre',
                'personal_translation' => 'Fiter\DefaultBundle\Entity\Translation\SubCategoriaTranslation',
                'property_path'        => 'translations',
                'widget'               => 'text',
            )) 
            ->add('usuario')
            ->add('categoria')
            ->add('imagen', 'file', array('required' => false))
            //->add('aleatorio', 'hidden', array('data' => 'true'))
        ;
    }
}