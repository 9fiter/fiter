<?php

namespace Fiter\MinecraftBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Fiter\MinecraftBundle\Entity\Jobs;
use Fiter\MinecraftBundle\Form\JobsType;


use Symfony\Component\Security\Core\Exception\AccessDeniedException;


/**
 * Jobs controller.
 *
 * @Route("/minecraft/jobs")
 */
class JobsController extends Controller{


    /**
     * show more info about users
     * @Route("/info", name="jobs_info")
     * @Template()
     */
    public function infoAction(){
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMIN')) throw new AccessDeniedException("No tienes permiso para ver los usuarios baneados");

        $mc_folder = $this->container->getParameter('minecraft_folder');
        $ruta = $mc_folder."plugins/Jobs/jobConfig.yml";
        if(file_exists($ruta)) {
            $info =  yaml_parse_file($ruta); //ladybug_dump($info); 
        }else throw $this->createNotFoundException('No se ha encontrado el archivo: jobConfig.yml');
        return array(
            'info' => $info,
        );
    }


    /**
     * Lists all Jobs entities.
     * @Route("/", name="jobs")
     * @Template()
     */
    public function indexAction(){
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMIN'))
            throw new AccessDeniedException('No tienes permiso para listar los jobs');

        $em = $this->getDoctrine()->getManager('minecraft');
        $paginador = $this->get('ideup.simple_paginator');
        $paginador->setItemsPerPage(50);
        $paginador->setMaxPagerItems(10);
        $entities = 
        $paginador->paginate(
            //$em->getRepository('FiterMinecraftBundle:Jobs')->findAll()
            $em->createQuery('SELECT o FROM FiterMinecraftBundle:Jobs o ORDER BY o.level DESC')
        )->getResult();

        return array(
            'entities' => $entities,
            'paginador' => $paginador
        );
    }

    /**
     * Finds and displays a Jobs entity.
     * @Route("/{id}/show", name="jobs_show")
     * @Template()
     */
    public function showAction($id){
        $em = $this->getDoctrine()->getManager('minecraft');
        $entity = $em->getRepository('FiterMinecraftBundle:Jobs')->find($id);
        if (!$entity) throw $this->createNotFoundException('Unable to find Jobs entity.');
        $deleteForm = $this->createDeleteForm($id);
        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }


    /**
     * Finds and displays a Jobs entity.
     * @Route("/{username}/show/user", name="jobs_show_user")
     * @Template()
     */
    public function showUserAction($username){
        $em = $this->getDoctrine()->getManager('minecraft');
        $entities = $em->getRepository('FiterMinecraftBundle:Jobs')->findByUsername($username);
        //if (!$entities) throw $this->createNotFoundException('Unable to find Jobs entity.');
        return array(
            'entities'      => $entities,
            'username'      => $username,
        );
    }

    /**
     * Displays a form to create a new Jobs entity.
     * @Route("/new", name="jobs_new")
     * @Template()
     */
    public function newAction(){
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMINo'))
            throw new AccessDeniedException('No tienes permiso para crear jobs');

        $entity = new Jobs();
        $form   = $this->createForm(new JobsType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Jobs entity.
     * @Route("/create", name="jobs_create")
     * @Method("POST")
     * @Template("FiterMinecraftBundle:Jobs:new.html.twig")
     */
    public function createAction(Request $request){
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMINo'))
            throw new AccessDeniedException('No tienes permiso para crear jobs');

        $entity  = new Jobs();
        $form = $this->createForm(new JobsType(), $entity);
        $form->bind($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager('minecraft');
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('jobs_show', array('id' => $entity->getId())));
        }
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Jobs entity.
     * @Route("/{id}/edit", name="jobs_edit")
     * @Template()
     */
    public function editAction($id){
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMINo'))
            throw new AccessDeniedException('No tienes permiso para editar jobs');

        $em = $this->getDoctrine()->getManager('minecraft');
        $entity = $em->getRepository('FiterMinecraftBundle:Jobs')->find($id);
        if (!$entity) throw $this->createNotFoundException('Unable to find Jobs entity.');
        $editForm = $this->createForm(new JobsType(), $entity);
        $deleteForm = $this->createDeleteForm($id);
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Jobs entity.
     * @Route("/{id}/update", name="jobs_update")
     * @Method("POST")
     * @Template("FiterMinecraftBundle:Jobs:edit.html.twig")
     */
    public function updateAction(Request $request, $id){
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMIN'))
            throw new AccessDeniedException('No tienes permiso para modificar jobs');

        $em = $this->getDoctrine()->getManager('minecraft');
        $entity = $em->getRepository('FiterMinecraftBundle:Jobs')->find($id);
        if (!$entity) throw $this->createNotFoundException('Unable to find Jobs entity.');
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new JobsType(), $entity);
        $editForm->bind($request);
        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('jobs_edit', array('id' => $id)));
        }
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Jobs entity.
     * @Route("/{id}/delete", name="jobs_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id){
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMINo'))
            throw new AccessDeniedException('No tienes permiso para eliminar jobs');


        $form = $this->createDeleteForm($id);
        $form->bind($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager('minecraft');
            $entity = $em->getRepository('FiterMinecraftBundle:Jobs')->find($id);
            if (!$entity) throw $this->createNotFoundException('Unable to find Jobs entity.');
            $em->remove($entity);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('jobs'));
    }
    private function createDeleteForm($id){
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
