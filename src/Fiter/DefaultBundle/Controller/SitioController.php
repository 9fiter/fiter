<?php
namespace Fiter\DefaultBundle\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
 
class SitioController extends Controller {
     
    /**
     * @Route("/sitio/{pagina}", name="estatica")
     * @Template()
     */
    public function estaticaAction($pagina){
        return $this->render('FiterDefaultBundle:Sitio:'.$pagina.'.html.twig');
    }
}
