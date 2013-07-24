<?php

namespace Fiter\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Fiter\DefaultBundle\Entity\SubCategoria;
use Fiter\DefaultBundle\Form\SubCategoriaType;

/**
 * SubCategoria controller.
 *
 * @Route("/subcategoria")
 */
class SubCategoriaController extends Controller
{
    /**
     * Lists all SubCategoria entities.
     *
     * @Route("/", name="subcategoria")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FiterDefaultBundle:SubCategoria')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a SubCategoria entity.
     *
     * @Route("/{id}/show", name="subcategoria_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FiterDefaultBundle:SubCategoria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SubCategoria entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new SubCategoria entity.
     *
     * @Route("/new", name="subcategoria_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new SubCategoria();
        $form   = $this->createForm(new SubCategoriaType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new SubCategoria entity.
     *
     * @Route("/create", name="subcategoria_create")
     * @Method("POST")
     * @Template("FiterDefaultBundle:SubCategoria:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new SubCategoria();
        $form = $this->createForm(new SubCategoriaType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('subcategoria_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing SubCategoria entity.
     *
     * @Route("/{id}/edit", name="subcategoria_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FiterDefaultBundle:SubCategoria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SubCategoria entity.');
        }

        $editForm = $this->createForm(new SubCategoriaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing SubCategoria entity.
     *
     * @Route("/{id}/update", name="subcategoria_update")
     * @Method("POST")
     * @Template("FiterDefaultBundle:SubCategoria:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FiterDefaultBundle:SubCategoria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SubCategoria entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new SubCategoriaType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('subcategoria_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a SubCategoria entity.
     *
     * @Route("/{id}/delete", name="subcategoria_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FiterDefaultBundle:SubCategoria')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find SubCategoria entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('subcategoria'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
