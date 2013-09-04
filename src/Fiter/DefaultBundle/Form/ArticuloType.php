<?php

namespace Fiter\DefaultBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\HttpFoundation\Session;

use Fiter\PollBundle\Form\PollType;

use Symfony\Component\Security\Core\SecurityContext;


class ArticuloType extends AbstractType{

    private $securityContext;

    public function __construct(SecurityContext $securityContext){
        $this->securityContext = $securityContext;
    }

    public function buildForm(FormBuilderInterface $builder, array $options){ 
        $locale = $options['label']; //$locale = 'es-ES';

        $user = $this->securityContext->getToken()->getUser(); //ladybug_dump($user);
        if ($user->hasRole('ROLE_EDITOR') or $user->hasRole('ROLE_ADMIN')){
          $builder->add(
            'activo', 'checkbox', array(
            'required' => false,
            'label'=> 'main.active',
            'attr' => array('class' => 'myValue'),
          ));
        }else{
          $builder->add(
            'activo', 'checkbox', array(
            'required' => false,
            'label'=> 'main.active',
            'attr' => array('class' => 'myValue'),
            'disabled'=> 'true',
          ));  
        }

        $builder
            ->add('activarComentarios', 'checkbox', array(
                 'required' => false,
                 'label'=> 'Activar comentarios',
            ))
            ->add('titulo', 'text' ,array(
                 'label'=> 'main.title',
                 'required' => true,
            ))
            ->add('categoria', null ,array(
                 'label'=> 'main.categorias',
            ))
            ->add('subCategoria', null ,array(
                 'label'=> 'main.subcategorias',
                 'required' => false,
            ))
            ->add('mostrarImagen', 'checkbox', array(
                 'required' => false,
                 'label'=> 'main.showImage',
            ))
            ->add('mostrarMiniaturas', 'checkbox', array(
                 'required' => false,
                 'label'=> 'main.showMiniaturas',
            ))
            ->add('mostrarSlide', 'checkbox', array(
                 'required' => false,
                 'label'=> 'main.showSlide',
            ))
            ->add('mostrarContenido', 'checkbox', array(
                 'required' => false,
                 'label'=> 'main.showContent',
            ))    
            ->add('imagen', 'file' ,array(
                 'required' => false,
                 'label'=> 'main.image',
            ))
            ->add('contenido', 'ckeditor', array(
                 'language' => $locale,
                 'label'=> 'main.content',
            ))
            // ->add('contenidoI18n', 'translatable_field', array(
            //     'field'                => 'contenido',
            //     'personal_translation' => 'Fiter\DefaultBundle\Entity\Translation\ArticuloTranslation',
            //     'property_path'        => 'translations',
            //     'widget'               => 'ckeditor',
            // ))
            //->add('translations', 'a2lix_translations')

            ->add('translations', 'a2lix_translations', array(
                'label' => 'Traducciones',
                'locales' => array('gl', 'ca', 'en'),   // [optional|required - depends on the presence in config.yml] See above
                'required' => false,                     // [optional] Overrides default_required if need
                'fields' => array(                      // [optional] Manual configuration of fields to display and options. If not specified, all translatable fields will be display, and options will be auto-detected
                    'titulo' => array(
                        //'label' => 'titulo',              // [optional] Custom label. Ucfirst, otherwise
                        'type' => 'text',           // [optional] Custom type
                        //**OTHER_OPTIONS**               // [optional] max_length, required, trim, read_only, constraints, ...
                    ),
                    'contenido' => array(
                        //'label' => 'Desc.'              // [optional]
                        //'locale_options' => array(              // [optional] Manual configuration of field for a dedicated locale -- Higher priority
                        //    'es' => array(
                        //        'label' => 'descripción'        // [optional] Higher priority
                        //        **OTHER_OPTIONS**               // [optional] Same possibilities as above
                        //    ),
                        //    'fr' => array(
                        //        'display' => false              // [optional] Prevent display of the field for this locale
                        //    )
                        //)
                        'type' => 'ckeditor'           // [optional] Custom type
                    ),
                )
            ))

            ->add('aleatorio', 'hidden', array('data' => 'true'))
            //->add('videosYoutube', 'collection', array('type' => new VideoYoutubeType()))  
            ->add('videosYoutube', 'collection', array(
                 'required' => false,
                  'type' => new VideoYoutubeType(),
                  'allow_add' => true,
                  'allow_delete' => true,
                  'by_reference' => false,
                  'label'=> ' ',
            ))
            ->add('listasYoutube', 'collection', array(
                 'required' => false,
                  'type' => new ListaYoutubeType(),
                  'allow_add' => true,
                  'allow_delete' => true,
                  'by_reference' => false,
                  'label'=> ' ',
            ))
            ->add('canalYoutube','text' , array(
                  'required' => false,
                  'label'=> 'main.yt_channel',
            ))
            ->add('rss','text' , array(
                  'required' => false,
                  'label'=> 'Rss'
            ))
            ->add('twitter','text' , array(
                  'required' => false,
                  'label'=> 'twitter'
            )) 
            ->add('poll', null ,array(
                 'label'=> 'main.poll',
            ))
            // ->add('map', null ,array(
            //      'label'=> 'map',
            //      'type' => new MapType(),
            // ))
            ->add('maps', 'collection', array(
                 'required' => false,
                  'type' => new MapType(),
                  'allow_add' => true,
                  'allow_delete' => true,
                  'by_reference' => false,
                  'label'=> 'maps',
            ))
            // ->add('map', 'entity', array(
            //     'class' => 'FiterDefaultBundle:Map',
            //     'property' => 'username',
            // ))
        ;
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array(
            'required'   => false,
            'data_class' => 'Fiter\DefaultBundle\Entity\Articulo'
        ));
    }
    public function getName(){
        return 'fiter_defaultbundle_articulotype';
    }

}
