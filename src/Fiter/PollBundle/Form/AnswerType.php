<?php

namespace Fiter\PollBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Fiter\PollBundle\Form\AnswerGroupType;
use Fiter\PollBundle\Entity\AnswerGroup;
use Fiter\PollBundle\Entity\Field;



class AnswerType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            //->add('value')
            ->add('field')
            // ->add('field', 'hidden', array(
            //     'data_class' => 'Fiter\PollBundle\Entity\Field'
            // ))
            //->add('answerGroup')
            // ->add('answerGroup', 'form', array(
            //      'required' => false,
            //       'type' => new AnswerGroupType(),
            //       'allow_add' => true,
            //       'allow_delete' => true,
            //       'by_reference' => false,
            //       'label'=> ' ',
            // ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array(
            'data_class' => 'Fiter\PollBundle\Entity\Answer'
        ));
    }

    public function getName(){
        return 'fiter_pollbundle_answertype';
    }
}
