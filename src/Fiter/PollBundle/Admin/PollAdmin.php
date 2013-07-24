<?php

namespace Fiter\PollBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Fiter\PollBundle\Form\FieldType;
 
class PollAdmin extends Admin{

	protected function configureListFields(ListMapper $mapper){
        $mapper
            ->addIdentifier('title', null)
            ->add('principal')
            ->add('usuario')
            ->add('id')
            ->add('fields')
            ->add('isActive')
            ->add('answersVisible')
            ->add('createdAt')
            ->add('deletedAt')
            ->add('startAt')
            ->add('endAt')
            ->add('type')
        ;
    }
    protected function configureDatagridFilters(DatagridMapper $mapper){
        $mapper
            ->add('title')
            ->add('principal')
            ->add('usuario')
            ->add('id')
            ->add('fields')
            ->add('isActive')
            ->add('answersVisible')
            ->add('createdAt')
            ->add('deletedAt')
            ->add('startAt')
            ->add('endAt')
            ->add('type')       

        ;
    }
    protected function configureFormFields(FormMapper $mapper){
        $mapper
            ->add('title')
            //->add('principal')

            ->add('principal', null, 
                array(  'required'     => false,
            ))
            ->add('isActive')
            //->add('answersVisible')
            //->add('usuario')
            //->add('fields')




            // ->add('fields', 'sonata_type_admin', array(
            //     //'data_class'=> null,
            //     'required' => false,
            //     //'edit' => 'inline',
            //     //'class'    => 'FiterDefaultBundle:VideoYoutube',
            //     //'expanded' => true,
            //     'by_reference' => false,
            //     //'multiple' => true
            // ))

            // ->add('fields', 'sonata_type_collection',
            //     array(
            //         // "attr" => array(""),
            //         // "block_name" => '',
            //         // "by_reference" => '',
            //         // "cascade_validation" => '',
            //         // "compound" => '',
            //         // "constraints" => '',
            //         // "csrf_field_name" => '',
            //         // "csrf_protection" => '',
            //         // "csrf_provider" => '',
            //         // "data" => '',
            //         // "data_class" => "\Fiter\PollBundle\Entity\Poll",
            //         // "disabled" => '',
            //         // "empty_data" => '',
            //         // "error_bubbling" => '',
            //         // "error_mapping" => '',
            //         // "extra_fields_message" => '',
            //         // "intention" => '',
            //         // "invalid_message" => '',
            //         // "invalid_message_parameters" => '',
            //         // "label" => '',
            //         // "label_attr" => array(""),
            //         // "mapped" => '',
            //         // "max_length" => '',
            //         // "modifiable" => '',
            //         // "pattern" => '',
            //         // "post_max_size_message" => '',
            //         // "property_path" => '',
            //         // "read_only" => '',
            //         // "required" => '',
            //         // "sonata_admin" => '',
            //         // "sonata_field_description" => '',
            //         // "translation_domain" => '',
            //         // "trim" => '',
            //         // "type" => '',
            //         // "type_options" => '',
            //         // "validation_constraint" => '',
            //         // "validation_groups" => '',
            //         // "virtual"=> ''
            //     )
            // )



            ->add('fields', 'sonata_type_collection', 
                array(  'required'     => false,
                        //"data_class" => "\Fiter\PollBundle\Entity\Field",
                        'label'        => 'Some Label',
                        'type' => new FieldType(),
                        'by_reference' => false,
                ),array(//'edit'            => 'inline',
                        'inline'          => 'table',
                        'template' => 'Some Template'
            ))

            // ->add('fields', 'sonata_type_model', array(
            //     // 'attr' => '',
            //     // 'block_name' => '',
            //     // 'by_reference' => '',
            //     // 'cascade_validation' => '',
            //     // 'choice_list' => '',
            //     // 'choices' => '',
            //     // 'class' => '',
            //     // 'compound' => 'true',
            //     // 'constraints' => '',
            //     // 'csrf_field_name' => '',
            //     // 'csrf_protection' => '',
            //     // 'csrf_provider' => '',
            //     // 'data' => '',
            //     // 'data_class' => '',
            //     // 'disabled' => '',
            //     // 'empty_data' => '',
            //     // 'empty_value' => '',
            //     // 'error_bubbling' => '',
            //     // 'error_mapping' => '',
            //     // 'expanded' => 'true',
            //     // 'extra_fields_message' => '',
            //     // 'intention' => '',
            //     // 'invalid_message' => '',
            //     // 'invalid_message_parameters' => '',
            //     // 'label' => '',
            //     // 'label_attr' => '',
            //     // 'mapped' => '',
            //     // 'max_length' => '',
            //     // 'model_manager' => '',
            //     'multiple' => 'true',
            //     // 'pattern' => '',
            //     // 'post_max_size_message' => '',
            //     // 'preferred_choices' => '',
            //     // 'property' => '',
            //     // 'property_path' => '',
            //     // 'query' => '',
            //     // 'read_only' => '',
            //     // 'required' => '',
            //     // 'sonata_admin' => '',
            //     // 'sonata_field_description' => '',
            //     // 'template' => '',
            //     // 'translation_domain' => '',
            //     // 'trim' => '',
            //     // 'validation_constraint' => '',
            //     // 'validation_groups' => '',
            //     // 'virtual' => '',
            //     ))
            



            //->add('createdAt')
            //->add('deletedAt')
            ->add('startAt')
            ->add('endAt')
            //->add('type')
        ;
    }
}