<?php

namespace Fiter\MinecraftBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Fiter\MinecraftBundle\Entity\Skillz;
use Fiter\MinecraftBundle\Form\SkillzType;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Skillz controller.
 * @Route("/minecraft/skills")
 */
class SkillzController extends Controller{


    /**
     * show more info about users
     * @Route("/info", name="skillz_info")
     * @Template()
     */
    public function infoAction(){
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMIN')) throw new AccessDeniedException("No tienes permiso para ver los usuarios baneados");

        $mc_folder = $this->container->getParameter('minecraft_folder');
        $ruta = $mc_folder."plugins/Skillz/skills.yml";
        if(file_exists($ruta)) {
            $info =  yaml_parse_file($ruta); //ladybug_dump($info); 
            unset($info['useMySQL']);
            unset($info['MySQL-User']);
            unset($info['MySQL-Pass']);
            unset($info['MySQL-Host']);
            unset($info['MySQL-Port']);
            unset($info['MySQL-Database']);
            unset($info['MySQL-Table']);
        }else throw $this->createNotFoundException('No se ha encontrado el archivo: skills.yml');
        return array(
            'info' => $info,
        );
    }



    /**
     * Lists all Skillz entities.
     * @Route("/", name="skillz")
     * @Template()
     */
    public function indexAction(){
        $em = $this->getDoctrine()->getManager('minecraft');
        $paginador = $this->get('ideup.simple_paginator');
        $paginador->setItemsPerPage(60);
        $paginador->setMaxPagerItems(10);
        $entities = 
        $paginador->paginate(
            $em->createQuery('SELECT o FROM FiterMinecraftBundle:Skillz o ORDER BY o.level DESC')
        )->getResult();
        return array(
            'entities' => $entities,
            'paginador' => $paginador
        );
    }
    /**
     * Finds and displays a Skillz entity.
     * @Route("/{id}/show", name="skillz_show")
     * @Template()
     */
    public function showAction($id){
        $em = $this->getDoctrine()->getManager('minecraft');
        $entity = $em->getRepository('FiterMinecraftBundle:Skillz')->find($id);
        if (!$entity) throw $this->createNotFoundException('Unable to find Skillz entity.');
        $deleteForm = $this->createDeleteForm($id);
        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Finds and displays a Skillz entity.
     * @Route("/{username}/show/user", name="skillz_show_user")
     * @Template()
     */
    public function showUserAction($username){
        $em = $this->getDoctrine()->getManager('minecraft');
        $entities = $em->getRepository('FiterMinecraftBundle:Skillz')->findByPlayer($username);
        //if (!$entities) throw $this->createNotFoundException('Unable to find Skillz entity.');
        return array(
            'entities'      => $entities,
            'username'      => $username,
        );
    }
    /**
     * Displays a form to create a new Skillz entity.
     * @Route("/new", name="skillz_new")
     * @Template()
     */
    public function newAction(){
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMIN'))
            throw new AccessDeniedException('No tienes permiso para listar skills');

        $entity = new Skillz();
        $form   = $this->createForm(new SkillzType(), $entity);
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
    /**
     * Creates a new Skillz entity.
     * @Route("/create", name="skillz_create")
     * @Method("POST")
     * @Template("FiterMinecraftBundle:Skillz:new.html.twig")
     */
    public function createAction(Request $request){
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMIN'))
            throw new AccessDeniedException('No tienes permiso para crear los skills');
        
        $entity  = new Skillz();
        $form = $this->createForm(new SkillzType(), $entity);
        $form->bind($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager('minecraft');
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('skillz_show', array('id' => $entity->getId())));
        }
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
    /**
     * Displays a form to edit an existing Skillz entity.
     * @Route("/{id}/edit", name="skillz_edit")
     * @Template()
     */
    public function editAction($id){
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMIN'))
            throw new AccessDeniedException('No tienes permiso para editar skills');

        $em = $this->getDoctrine()->getManager('minecraft');
        $entity = $em->getRepository('FiterMinecraftBundle:Skillz')->find($id);
        if (!$entity) throw $this->createNotFoundException('Unable to find Skillz entity.');
        $editForm = $this->createForm(new SkillzType(), $entity);
        $deleteForm = $this->createDeleteForm($id);
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Skillz entity.
     * @Route("/{id}/update", name="skillz_update")
     * @Method("POST")
     * @Template("FiterMinecraftBundle:Skillz:edit.html.twig")
     */
    public function updateAction(Request $request, $id){
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMIN'))
            throw new AccessDeniedException('No tienes permiso para modificar skills');

        $em = $this->getDoctrine()->getManager('minecraft');
        $entity = $em->getRepository('FiterMinecraftBundle:Skillz')->find($id);
        if (!$entity) throw $this->createNotFoundException('Unable to find Skillz entity.');
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new SkillzType(), $entity);
        $editForm->bind($request);
        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('skillz_edit', array('id' => $id)));
        }
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Skillz entity.
     * @Route("/{id}/delete", name="skillz_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id){
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMIN'))
            throw new AccessDeniedException('No tienes permiso para eliminar skills');

        $form = $this->createDeleteForm($id);
        $form->bind($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager('minecraft');
            $entity = $em->getRepository('FiterMinecraftBundle:Skillz')->find($id);
            if (!$entity) throw $this->createNotFoundException('Unable to find Skillz entity.');
            $em->remove($entity);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('skillz'));
    }
    private function createDeleteForm($id){
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}