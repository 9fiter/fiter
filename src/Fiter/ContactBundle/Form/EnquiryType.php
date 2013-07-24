<?php

namespace Fiter\ContactBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface; 
use Symfony\Component\Form\FormBuilder;

class EnquiryType  extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){

    	$builder
	        ->add('name', 'text', array(
	             'label'=> 'main.name',
	        ))
	        ->add('email', 'email', array(
	             'label'=> 'Email',
	        ))
	        ->add('subject', 'text', array(
	             'label'=> 'main.subject',
	        ))
	        ->add('body', 'textarea', array(
	             'label'=> 'main.content',
	        ))
        ;
    }

    public function getName(){
        return 'fiter_contactbundle_enquirytype';
    }
}