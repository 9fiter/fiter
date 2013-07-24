<?php

namespace Fiter\DefaultBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class MapType extends AbstractType{
    
    public function buildForm(FormBuilderInterface  $builder, array $options){
        $builder
            ->add('lat', 'text', array(
                 'label'=> 'lat',
            ))
            ->add('lang', 'text', array(
                 'label'=> 'lat',
            ))
        ;
    }
    public function getDefaultOptions(array $options){
        return array(
            'data_class' => 'Fiter\DefaultBundle\Entity\Map',
        );
    }
    public function getName(){ return 'map'; }
}

?>