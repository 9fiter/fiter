<?php

namespace Fiter\DefaultBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware{

    public function mainMenu(FactoryInterface $factory, array $options){
        $em = $this->container->get('doctrine.orm.entity_manager');
        $entities = $em->getRepository('FiterDefaultBundle:Categoria')->findMenuCategoriasNoVacias();
        //ladybug_dump($this);
        //ladybug_dump($this->container);

        $menu = $factory->createItem('root');


        $active="";
        foreach ($options as $key => $option) {
            if ($key == "active"){
                $active = $options[$key];
            }
        }
        //ladybug_dump($active);




        $translator = $this->container->get('translator');

       
        if ($translator->trans('main.inicio') == $active) {
            $menu->addChild($translator->trans('main.inicio'), array(
                'route' => 'inicio',
                'attributes' => array(
                    'class' => "listaActiva"
                )
            ));    
        }else{
            $menu->addChild($translator->trans('main.inicio'), array(
                'route' => 'inicio',
            ));
        }
        foreach ($entities as $entity) {

            if ($entity->getSlug() == $active) {
                $menu->addChild( $entity->getNombre() , array(
                    'route' => 'articulocategoria',
                    'routeParameters' => array('slug' => $entity->getSlug()),
                    'attributes' => array(
                        'class' => "listaActiva"
                    )
                ));
            }else{
                $menu->addChild( $entity->getNombre() , array(
                    'route' => 'articulocategoria',
                    'routeParameters' => array('slug' => $entity->getSlug())
                ));
            }
            foreach ($entity->getSubCategoria() as $subCategoria) {
                if ($subCategoria->getSlug() == $active) {
                    $menu[$entity->getNombre()]->addChild( $subCategoria->getNombre() , array(
                        'route' => 'articulosubcategoria',
                        'routeParameters' => array(
                            'slug' => $subCategoria->getSlug(),
                            'slugCategoria' => $entity->getSlug()
                        ),
                        'attributes' => array(
                            'class' => "listaActiva"
                        )
                    ));
                }else{
                    $menu[$entity->getNombre()]->addChild( $subCategoria->getNombre() , array(
                        'route' => 'articulosubcategoria',
                        'routeParameters' => array(
                            'slug' => $subCategoria->getSlug(),
                            'slugCategoria' => $entity->getSlug()
                        )
                    ));
                }

            }
        }

        if($menu['Minecraft']){
            $menu['Minecraft']->addChild($translator->trans('main.contests') , array(
                'route' => 'contest'
            ));
            $menu['Minecraft']->addChild(
                'schematics'
                //$this->get('translator')->trans('Symfony2 is great');
                , array(
                'route' => 'schematic'
            ));
        }
        

        //$menu->addChild('About Me', array(
        //    'route' => 'subcategoria_show',
        //    'routeParameters' => array('id' => 42)
        //));

        //$menu->addChild('Home', array(
        //    'route' => 'inicio',
        //    'attributes' => array(
        //        'id' => 'back_to_homepage'
        //    )
        //));

        return $menu;
    }
}