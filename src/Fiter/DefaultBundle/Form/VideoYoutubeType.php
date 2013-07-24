<?php

namespace Fiter\DefaultBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class VideoYoutubeType extends AbstractType{
    
    public function buildForm(FormBuilderInterface  $builder, array $options){
        $builder->add('enlace', 'text', array(
                 'label'=> 'main.yt_video',
            ))
        ;
    }
    public function getDefaultOptions(array $options){
        return array(
            'data_class' => 'Fiter\DefaultBundle\Entity\VideoYoutube',
        );
    }
    public function getName(){ return 'videoYoutube'; }
}

?>