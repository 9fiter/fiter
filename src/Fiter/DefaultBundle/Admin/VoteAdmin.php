<?php

namespace Fiter\DefaultBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
 
class VoteAdmin extends Admin{

	protected function configureListFields(ListMapper $mapper){
        $mapper
            ->add('id')
            ->add('author')
            ->add('comment')
            ->add('createdAt')
            ->add('value')
            
        ;
    }
    protected function configureDatagridFilters(DatagridMapper $mapper){
        $mapper
            ->add('id')
            ->add('author')
            ->add('comment')
            ->add('createdAt')
            ->add('value')
        ;
    }
    protected function configureFormFields(FormMapper $mapper){
        $mapper
            ->add('author')
            ->add('comment')
            ->add('createdAt')
            ->add('value')
        ;
    }
}