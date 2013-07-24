<?php

namespace Fiter\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Fiter\DefaultBundle\Util\Util;





class DefaultController extends Controller{
    /**
     * @Route("/",name="inicio")
     * @Template()
     */
    public function indexAction(){
        return $this->forward('FiterDefaultBundle:Articulo:index');
    }
    
    /**
     * @Route("/watch",name="video")
     * @Method({"GET"})
     * @Template()
     */
    public function videoAction(Request $request){
        return $this->render('FiterDefaultBundle:Articulo:video.html.twig', array(
            'v' => $request->query->get('v')
        ));
    }

    /**
     * @Route("/map/{lat}/{lang}/{height/{zoom}",name="map", requirements={"height" = "\d+"}, requirements={"zoom" = "20"})
     * @Template()
     */
    public function mapAction($lat,$lang,$height,$zoom=20){
        return array(
            'lat' => $lat,
            'lang' => $lang,
            'height' => $height,
            'zoom' => $zoom
        );
    }






}
