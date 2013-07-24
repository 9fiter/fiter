<?php

namespace Fiter\DefaultBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
 
class ThreadAdmin extends Admin{

	protected function configureListFields(ListMapper $mapper){
        $mapper
        //->addIdentifier('nombre', null)
        ->add('id')
        ->add('isCommentable')
        ->add('numComments')
        ->add('lastCommentAt')
        ->add('permalink')
        ;
    }
    protected function configureDatagridFilters(DatagridMapper $mapper){
        $mapper
            ->add('id')
	        ->add('isCommentable')
	        ->add('numComments')
	        ->add('lastCommentAt')
	        ->add('permalink')       

        ;
    }
    protected function configureFormFields(FormMapper $mapper){
        $mapper
            ->add('id')
	        ->add('isCommentable')
	        ->add('numComments')
	        ->add('lastCommentAt')
	        ->add('permalink')  
        ;
    }
}