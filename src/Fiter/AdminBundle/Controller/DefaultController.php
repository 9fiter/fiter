<?php

namespace Fiter\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller{
    /**
     * @Route("/",name="admin_inicio")
     * @Template()
     */
    public function indexAction(){
        return $this->forward('FiterAdminBundle:Articulo:index');
    }
}
