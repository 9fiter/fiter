<?php

namespace Fiter\PhotoContestBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Fiter\PhotoContestBundle\Entity\Contest;
use Fiter\PhotoContestBundle\Form\ContestType;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Contest controller.
 * @Route("/contest")
 */
class ContestController extends Controller{

    /**
     * Lists all Contest entities.
     * @Route("/", name="_contest")
     * @Template()
     */
    public function indexAction(){
        $em = $this->getDoctrine()->getManager('minecraft');
        $entities = $em->getRepository('FiterPhotoContestBundle:Contest')->findAllContestByFechaInicio();

        $session  = $this->get("session");
        $user = $session->get("MinecraftUser");
        $usuario = null;
        if($user) $usuario = $em->getRepository('FiterMinecraftBundle:Authme')->findOneByUsername($user);
        
        //ladybug_dump($usuario);
        $fechaActual=new \DateTime("now");
        foreach ($entities as $entity) {
            $fechaInicio=$entity->getFechaInicio();
            $fechaFin=$entity->getFechaFin();
            if($fechaActual>$fechaInicio && $fechaActual<$fechaFin) $entity->setIniciado(1);
            else $entity->setIniciado(0);
        }

        return array(
            'entities' => $entities,
            'usuario' => $usuario,
        );
    }
    /**
     * Finds and displays a Contest entity.
     * @Route("/{id}/{slug}/show", name="_contest_show")
     * @Template()
     */
    public function showAction($id, $slug){
        $em = $this->getDoctrine()->getManager('minecraft');
        $entity = $em->getRepository('FiterPhotoContestBundle:Contest')->find($id);
        if (!$entity) throw $this->createNotFoundException('Unable to find Contest entity.');
        $deleteForm = $this->createDeleteForm($id);

        $entity->incrementaVisitas();
        $em->persist($entity);
        $em->flush();

        $fechaActual=new \DateTime("now");
        $fechaInicio=$entity->getFechaInicio();
        $fechaFin=$entity->getFechaFin();
        if($fechaActual>$fechaInicio && $fechaActual<$fechaFin) $entity->setIniciado(1);
        else $entity->setIniciado(0);


        $session  = $this->get("session");
        $user = $session->get("MinecraftUser");
        $usuario = null;
        if($user) $usuario = $em->getRepository('FiterMinecraftBundle:Authme')->findOneByUsername($user);

        return array(
            'entity'      => $entity,
            'usuario' => $usuario,
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Displays a form to create a new Contest entity.
     * @Route("/new", name="_contest_new")
     * @Template()
     */
    public function newAction(){
        $entity = new Contest();
        $form   = $this->createForm(new ContestType(), $entity);
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
    /**
     * Creates a new Contest entity.
     * @Route("/create", name="_contest_create")
     * @Method("POST")
     * @Template("FiterPhotoContestBundle:Contest:new.html.twig")
     */
    public function createAction(Request $request){
        $entity  = new Contest();
        $form = $this->createForm(new ContestType(), $entity);
        $form->bind($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager('minecraft');

            //$contest = $em->getRepository('FiterPhotoContestBundle:Contest')->findByUsuario($entity->getUsername());
            //if ($contest) throw $this->createNotFoundException('Ya estás participando en el concurso.');
            //else{
                $em->persist($entity);
                $em->flush();
                return $this->redirect($this->generateUrl('contest_show', array('id' => $entity->getId())));    
            //}
        }
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
    /**
     * Displays a form to edit an existing Contest entity.
     * @Route("/{id}/edit", name="_contest_edit")
     * @Template()
     */
    public function editAction($id){
        $em = $this->getDoctrine()->getManager('minecraft');
        $entity = $em->getRepository('FiterPhotoContestBundle:Contest')->find($id);
        if (!$entity) throw $this->createNotFoundException('Unable to find Contest entity.');
        $editForm = $this->createForm(new ContestType(), $entity);
        $deleteForm = $this->createDeleteForm($id);
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Edits an existing Contest entity.
     * @Route("/{id}/update", name="_contest_update")
     * @Method("POST")
     * @Template("FiterPhotoContestBundle:Contest:edit.html.twig")
     */
    public function updateAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager('minecraft');
        $entity = $em->getRepository('FiterPhotoContestBundle:Contest')->find($id);
        if (!$entity) throw $this->createNotFoundException('Unable to find Contest entity.');
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ContestType(), $entity);
        $editForm->bind($request);
        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('contest_edit', array('id' => $id)));
        }
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Contest entity.
     * @Route("/{id}/delete", name="contest_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id){
        $form = $this->createDeleteForm($id);
        $form->bind($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager('minecraft');
            $entity = $em->getRepository('FiterPhotoContestBundle:Contest')->find($id);
            if (!$entity) throw $this->createNotFoundException('Unable to find Contest entity.');
            $em->remove($entity);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('contest'));
    }
    private function createDeleteForm($id){
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
