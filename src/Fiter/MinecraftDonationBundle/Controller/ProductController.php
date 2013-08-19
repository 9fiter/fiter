<?php

namespace Fiter\MinecraftDonationBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Fiter\MinecraftDonationBundle\Entity\Product;
use Fiter\MinecraftDonationBundle\Form\ProductType;


use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


/**
 * Product controller.
 *
 * @Route("/")
 */
class ProductController extends Controller{

    /**
     * Lists all Product entities.
     * @Route("/", name="product")
     * @Template()
     */
    public function indexAction(){
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMIN')) throw new AccessDeniedException("Servicio en desarrollo");


        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('FiterMinecraftDonationBundle:Product')->findAll();
        return array(
            'entities' => $entities,
        );
    }
    /**
     * Finds and displays a Product entity.
     *
     * @Route("/{id}/show", name="product_show")
     * @Template()
     */
    public function showAction($id){
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMIN')) throw new AccessDeniedException("Servicio en desarrollo");

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FiterMinecraftDonationBundle:Product')->find($id);
        if (!$entity) throw $this->createNotFoundException('Unable to find Product entity.');
        $deleteForm = $this->createDeleteForm($id);
        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Product entity.
     * @Route("/new", name="product_new")
     * @Template()
     */
    public function newAction(){
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMIN')) throw new AccessDeniedException("No tienes permiso para añadir productos");

        $entity = new Product();
        $form   = $this->createForm(new ProductType(), $entity);
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Product entity.
     * @Route("/create", name="product_create")
     * @Method("POST")
     * @Template("FiterMinecraftDonationBundle:Product:new.html.twig")
     */
    public function createAction(Request $request){
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMIN')) throw new AccessDeniedException("No tienes permiso para añadir productos");


        $entity  = new Product();
        $form = $this->createForm(new ProductType(), $entity);
        $form->bind($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('product_show', array('id' => $entity->getId())));
        }
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Product entity.
     * @Route("/{id}/edit", name="product_edit")
     * @Template()
     */
    public function editAction($id){
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMIN')) throw new AccessDeniedException("No tienes permiso para editar este producto");

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FiterMinecraftDonationBundle:Product')->find($id);
        if (!$entity) throw $this->createNotFoundException('Unable to find Product entity.');
        $editForm = $this->createForm(new ProductType(), $entity);
        $deleteForm = $this->createDeleteForm($id);
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Product entity.
     * @Route("/{id}/update", name="product_update")
     * @Method("POST")
     * @Template("FiterMinecraftDonationBundle:Product:edit.html.twig")
     */
    public function updateAction(Request $request, $id){
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMIN')) throw new AccessDeniedException("No tienes permiso para actualizar este producto");


        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FiterMinecraftDonationBundle:Product')->find($id);
        if (!$entity) throw $this->createNotFoundException('Unable to find Product entity.');
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ProductType(), $entity);
        $editForm->bind($request);
        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('product_edit', array('id' => $id)));
        }
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Product entity.
     * @Route("/{id}/delete", name="product_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id){
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMIN')) throw new AccessDeniedException("No tienes permiso para eliminar este producto");

        $form = $this->createDeleteForm($id);
        $form->bind($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FiterMinecraftDonationBundle:Product')->find($id);
            if (!$entity) throw $this->createNotFoundException('Unable to find Product entity.');
            $em->remove($entity);
            $em->flush();
        }return $this->redirect($this->generateUrl('product'));
    }
    private function createDeleteForm($id){
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}