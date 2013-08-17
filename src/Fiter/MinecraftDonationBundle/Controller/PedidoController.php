<?php

namespace Fiter\MinecraftDonationBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Fiter\MinecraftDonationBundle\Entity\Pedido;
use Fiter\MinecraftDonationBundle\Form\PedidoType;



use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Pedido controller.
 * @Route("/pedido")
 */
class PedidoController extends Controller {

    /**
     * Creates a new Pedido entity.
     * @Route("/nuevo", name="pedido_nuevo")
     * @Template()
     */
    public function nuevoAction(Request $request){
        $session  = $this->get("session");
        $cart = $session->get("cart");
        $dem = $this->getDoctrine()->getManager();
        $cart['amount']=0.00;
        $emptycart = true;
        //ladybug_dump($cart);

        if($cart){
            foreach ($cart['products'] as &$product) {
                //$product['product'] = $dem->getRepository('FiterMinecraftDonationBundle:Product')->findOneById($product['id']);
                $productdb=$dem->getRepository('FiterMinecraftDonationBundle:Product')->findOneById($product['id']);
                $product['price'] = $productdb->getPrice();
                //$product['subtotal'] = $product['price']*$product['qty'];
                //ladybug_dump($cart['amount']);
                //ladybug_dump($product['price']);
                //ladybug_dump($product['qty']);
                $cart['amount'] += $product['price']*$product['qty'];
                //ladybug_dump($cart['amount']);
                $emptycart = false;
            }
        }
        $em = $this->getDoctrine()->getManager('minecraft');
        $session  = $this->get("session");
        $user = $session->get("MinecraftUser");
        if(!$user){
            $translated = $this->get('translator')->trans('main.notlogued');
            $session->getFlashBag()->add('error', $translated);
            return $this->redirect($this->generateUrl('donation_cart'));
        }
        if(!array_key_exists('orderId', $cart)){
            $entity  = new Pedido();
            $entity->setOrderNumber($user.time());
            $entity->setAmount($cart['amount']);
            //ladybug_dump($cart['amount']);
            //ladybug_dump($entity->getAmount());
            $entity->setCart(serialize($cart));
            $entity->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $cart['orderId']=$entity->getId();
            $session->set("cart", $cart );    
            //ladybug_dump($cart);
              return $this->redirect($this->generateUrl('payment_details', array('orderId' => $entity->getId()  )));
        }else return $this->redirect($this->generateUrl('payment_details', array('orderId' => $cart['orderId']  )));
        
    }
    /**
     * Lists all Pedido entities.
     * @Route("/", name="pedido")
     * @Template()
     */
    public function indexAction(){
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMIN')) throw new AccessDeniedException("No tienes permiso para listar los pedidos");

        $em = $this->getDoctrine()->getManager();
        //$entities = $em->getRepository('FiterMinecraftDonationBundle:Pedido')->findAll();
        //return array(
        //    'entities' => $entities,
        //);

        $paginador = $this->get('ideup.simple_paginator');
        $paginador->setItemsPerPage(10);
        $paginador->setMaxPagerItems(10);
        $entities = 
        $paginador->paginate(
            $em->getRepository('FiterMinecraftDonationBundle:Pedido')->findAll()
        )->getResult();
        
        return array(
            'entities' => $entities,
            'paginador' => $paginador
        );

    }
    /**
     * Finds and displays a Pedido entity.
     * @Route("/{id}/show", name="pedido_show")
     * @Template()
     */
    public function showAction($id){
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMIN')) throw new AccessDeniedException("No tienes permiso para ver los pedidos");

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FiterMinecraftDonationBundle:Pedido')->find($id);
        if (!$entity) throw $this->createNotFoundException('Unable to find Pedido entity.');
        $deleteForm = $this->createDeleteForm($id);

        $cart = unserialize($entity->getCart());
        return array(
            'entity'      => $entity,
            'cart'      => $cart,
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Displays a form to create a new Pedido entity.
     * @Route("/new", name="pedido_new")
     * @Template()
     */
    public function newAction(){
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMINo')) throw new AccessDeniedException("No tienes permiso para realizar esta accion");

        $entity = new Pedido();
        $form   = $this->createForm(new PedidoType(), $entity);
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
    /**
     * Creates a new Pedido entity.
     * @Route("/create", name="pedido_create")
     * @Method("POST")
     * @Template("FiterMinecraftDonationBundle:Pedido:new.html.twig")
     */
    public function createAction(Request $request){
        $entity  = new Pedido();
        $form = $this->createForm(new PedidoType(), $entity);
        $form->bind($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('pedido_show', array('id' => $entity->getId())));
        }
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
    /**
     * Displays a form to edit an existing Pedido entity.
     * @Route("/{id}/edit", name="pedido_edit")
     * @Template()
     */
    public function editAction($id) {
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMINo')) throw new AccessDeniedException("No tienes permiso para editar pedidos");

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FiterMinecraftDonationBundle:Pedido')->find($id);
        if (!$entity) throw $this->createNotFoundException('Unable to find Pedido entity.');
        $editForm = $this->createForm(new PedidoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Edits an existing Pedido entity.
     * @Route("/{id}/update", name="pedido_update")
     * @Method("POST")
     * @Template("FiterMinecraftDonationBundle:Pedido:edit.html.twig")
     */
    public function updateAction(Request $request, $id){
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMINo')) throw new AccessDeniedException("No tienes permiso para actualizar los pedidos");


        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FiterMinecraftDonationBundle:Pedido')->find($id);
        if (!$entity) throw $this->createNotFoundException('Unable to find Pedido entity.');
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PedidoType(), $entity);
        $editForm->bind($request);
        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('pedido_edit', array('id' => $id)));
        }
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Pedido entity.
     * @Route("/{id}/delete", name="pedido_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id){
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMINo')) throw new AccessDeniedException("No tienes permiso para borrar los pedidos");


        $form = $this->createDeleteForm($id);
        $form->bind($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FiterMinecraftDonationBundle:Pedido')->find($id);
            if (!$entity) throw $this->createNotFoundException('Unable to find Pedido entity.');
            $em->remove($entity);
            $em->flush();
        }return $this->redirect($this->generateUrl('pedido'));
    }
    private function createDeleteForm($id){
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
