<?php

namespace Fiter\DefaultBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoriaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('translations', 'a2lix_translations', array(
                'label' => 'Traducciones',
                'locales' => array('gl', 'ca', 'en'),   // [optional|required - depends on the presence in config.yml] See above
                'required' => false,                     // [optional] Overrides default_required if need
                'fields' => array(                      // [optional] Manual configuration of fields to display and options. If not specified, all translatable fields will be display, and options will be auto-detected
                    'nombre' => array(
                        //'label' => 'titulo',              // [optional] Custom label. Ucfirst, otherwise
                        'type' => 'text',           // [optional] Custom type
                        //**OTHER_OPTIONS**               // [optional] max_length, required, trim, read_only, constraints, ...
                    ),
                )
            ))
            ->add('imagen')
            //->add('slug')
            //->add('fechaPublicacion')
            //->add('fechaActualizacion')
            //->add('activo')
            //->add('visitas')
            //->add('likes')
            //->add('usuario')
            //->add('orden')
            ->add('aleatorio', 'hidden', array('data' => 'true'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fiter\DefaultBundle\Entity\Categoria'
        ));
    }

    public function getName()
    {
        return 'fiter_defaultbundle_categoriatype';
    }
}
