<?php
namespace Fiter\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SitemapsController extends Controller{

    /**
     * @Route("/sitemap.{_format}", name="sample_sitemaps_sitemap", Requirements={"_format" = "xml"})
     * @Template("FiterDefaultBundle:Sitemaps:sitemap.xml.twig")
     */
    public function sitemapAction(){

        $em = $this->getDoctrine()->getEntityManager();
        $urls = array();
        $hostname = $this->getRequest()->getHost();
        
        // add some urls homepage
        $urls[] = array('loc' => $this->get('router')->generate('_portada'), 'changefreq' => 'weekly', 'priority' => '0.5');

        //multi-lang pages
        //$languages = array('es','en','gl');
        // foreach($languages as $lang) {
        //     $urls[] = array(
        //         'loc' => $this->get('router')->generate('portada',
        //         array('_locale' => $lang)),
        //         'changefreq' => 'daily',
        //         'priority' => '0.5'
        //     );
        // }

        $urls[] = array(
            'loc' => $this->get('router')->generate('portada',
            array('_locale' => $this->getRequest()->getLocale())),
            'changefreq' => 'daily',
            'priority' => '0.5'
        );

        foreach ($em->getRepository('FiterDefaultBundle:Categoria')->findMenuCategoriasNoVacias() as $product) {
            $urls[] = array(
                'loc' => $this->get('router')->generate('articulocategoria', 
                array('slug' => $product->getSlug())),
                'changefreq' => 'daily',
                'priority' => '0.5'
            );
        }

        foreach ($em->getRepository('FiterDefaultBundle:Articulo')->findTodosLosArticulosActivos() as $product) {
            $urls[] = array(
                'loc' => $this->get('router')->generate('articulo_show', 
                array(
                    'id' => $product->getId(),
                    'slug' => $product->getSlug(),
                )),
                'priority' => '0.5'
            );
        }

        return array('urls' => $urls, 'hostname' => $hostname);
    }
}