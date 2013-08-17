<?php

namespace Fiter\MinecraftDonationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller{

    /**
     * @Route("/thanks", name="donation_thanks")
     * @Template()
     */
    public function thanksAction(){
        $session  = $this->get("session");
        $session->remove("cart"); 

        $user = $session->get("MinecraftUser");
        return array( 'username' => $user );
    }
    /**
     * @Route("/cart", name="donation_cart")
     * @Template()
     */
    public function cartAction(){
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMIN')) throw new AccessDeniedException("Servicio en desarrollo");
        $session  = $this->get("session");
        $cart = $session->get("cart");
        //ladybug_dump($cart);
        $dem = $this->getDoctrine()->getManager();
        $emptycart = true;
        //ladybug_dump($cart);
        if($cart){
            foreach ($cart['products'] as &$product) {
                $product['product'] = $dem->getRepository('FiterMinecraftDonationBundle:Product')->findOneById($product['id']);
                $emptycart = false;
            }
        }
        $usuario = null;
        $em = $this->getDoctrine()->getManager('minecraft');
        $session  = $this->get("session");
        $user = $session->get("MinecraftUser");

        if($user) $usuario = $em->getRepository('FiterMinecraftBundle:Authme')->findOneByUsername($user);
        return array(
            'username' => $user,
            'usuario' => $usuario,
            'cart' => $cart,
            'emptycart' => $emptycart
        );
    }
    /**
     * @Route("/cart/clear", name="donation_cart_clear")
     * @Template("FiterMinecraftDonationBundle:Default:cart.html.twig")
     */
    public function clearCartAction(){
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMIN')) throw new AccessDeniedException("Servicio en desarrollo");
        $session  = $this->get("session");
        $emptycart = true;
        $session->remove("cart"); 
        $cart=null;
        $usuario = null;
        $em = $this->getDoctrine()->getManager('minecraft');
        $session  = $this->get("session");
        $user = $session->get("MinecraftUser");
        if($user) $usuario = $em->getRepository('FiterMinecraftBundle:Authme')->findOneByUsername($user);
        return array(
            'username' => $user,
            'usuario' => $usuario,
            'cart' => $cart,
            'emptycart' => $emptycart
        );
    }
    /**
     * @Route("/add/{productId}", name="add_product")
     * @Template()
     */
    public function addAction($productId){
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMIN')) throw new AccessDeniedException("Servicio en desarrollo");
        $session  = $this->get("session");
        $cart = $session->get("cart");

        //$em = $this->getDoctrine()->getManager();
        //$pedido = $em->getRepository('FiterMinecraftDonationBundle:Pedido')->find($cart['orderId']);
        //if (!$pedido) throw $this->createNotFoundException('Unable to find Pedido entity.');
        //$em->remove($pedido);
        //$em->flush();
        unset($cart['orderId']);

        if($cart){
            $itemInList= false;
            foreach ($cart['products'] as &$product) {
                if($product['id']==$productId) {
                    $product['qty'] = $product['qty'] +1;
                    $itemInList= true;
                }
            }
            if(!$itemInList) array_push($cart['products'], array('id'=> $productId,'qty'=>1));
            $session->set("cart", $cart );    
        }else{
            $cart = array(
                'products'=> array(
                    array('id'=> $productId,'qty'=>1),
                    //array('id'=> $productId,'qty'=>'1'),
                ),
                //'currency'=> 'bitcoin'
            );
            $session->set("cart", $cart );    
        }return $this->redirect($this->generateUrl('donation_cart'));
    }
    /**
     * @Route("/delete/{productId}", name="delete_product")
     * @Template()
     */
    public function deleteAction($productId){
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMIN')) throw new AccessDeniedException("Servicio en desarrollo");
        $session  = $this->get("session");
        $cart = $session->get("cart");
        unset($cart['orderId']);
        if($cart){
            foreach ($cart['products'] as $key => &$product) 
                if($product['id']==$productId) unset($cart['products'][$key]); 
            $session->set("cart", $cart );    
        }return $this->redirect($this->generateUrl('donation_cart'));
    }
    /**
     * @Route("/update/{productId}", name="update_product")
     * @Template()
     */
    public function updateAction(Request $request, $productId){
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMIN')) throw new AccessDeniedException("Servicio en desarrollo");
        $post = $this->get('request')->request->all();
        $qty = $post['qty'];
        $session  = $this->get("session");
        $cart = $session->get("cart");
        unset($cart['orderId']);
        if($cart){
            foreach ($cart['products'] as $key => &$product) 
                if($product['id']==$productId) $product['qty']=$qty;
            $session->set("cart", $cart );    
        }return $this->redirect($this->generateUrl('donation_cart'));
    }
}
