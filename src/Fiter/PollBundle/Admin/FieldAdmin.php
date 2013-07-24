<?php

namespace Fiter\PollBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
 
class FieldAdmin extends Admin{

	protected function configureListFields(ListMapper $mapper){
        $mapper
            ->add('id')
            ->add('isActive')
            ->add('required')
            ->addIdentifier('title', null)
            ->add('poll')
            ->add('position')
            ->add('createdAt')
            ->add('deletedAt')
            ->add('type')
            ->add('assetPath')
            ->add('description')
            ->add('children')
            ->add('parent')
        ;
    }
    protected function configureDatagridFilters(DatagridMapper $mapper){
        $mapper
            ->add('id')
            ->add('isActive')
            ->add('required')
            ->add('title')
            ->add('poll')
            ->add('position')
            ->add('createdAt')
            ->add('deletedAt')
            ->add('type')
            ->add('assetPath')
            ->add('description')
            //->add('children')
            ->add('parent')

        ;
    }
    protected function configureFormFields(FormMapper $mapper){
        $mapper
            // ->add('id')
            // ->add('isActive')
            // ->add('required')
            ->add('title')
            // ->add('poll')
            // ->add('position')
            // ->add('createdAt')
            // ->add('deletedAt')
            ->add('type')
            // ->add('assetPath')
            // ->add('description')
            //->add('children')
            // ->add('parent')
        ;
    }
}