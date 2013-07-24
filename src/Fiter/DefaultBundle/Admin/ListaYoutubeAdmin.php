<?php

namespace Fiter\DefaultBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
 
class ListaYoutubeAdmin extends Admin{

	protected function configureListFields(ListMapper $mapper){
        $mapper
            ->add('id')
            ->add('articulos')
            ->add('enlace')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $mapper){
        $mapper
            ->add('id')
            ->add('articulos')
            ->add('enlace')
        ;
    }

    protected function configureFormFields(FormMapper $mapper){
        $mapper
        	//->add('enlace')
        ;
    }
}