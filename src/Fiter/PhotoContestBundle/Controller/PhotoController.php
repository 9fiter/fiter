<?php

namespace Fiter\PhotoContestBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Fiter\PhotoContestBundle\Entity\Photo;
use Fiter\PhotoContestBundle\Entity\Categoria;
use Fiter\PhotoContestBundle\Form\PhotoType;
use Doctrine\Common\Collections\ArrayCollection;

use Fiter\PhotoContestBundle\Entity\PhotoLike;
use Symfony\Component\HttpFoundation\RedirectResponse;


/**
 * Photo controller.
 * @Route("/photo")
 */
class PhotoController extends Controller {


        /**
     * Adds a like to an Photo entity.
     *
     * @Route("/{id}/like", name="photo_like")
     * @Template()
     */
    public function likeAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager('minecraft');
        $entity = $em->getRepository('FiterPhotoContestBundle:Photo')->find($id);
        if (!$entity) throw $this->createNotFoundException('Unable to find photo entity.');

        $al  = new PhotoLike();

        $session  = $this->get("session");
        $user = $session->get("MinecraftUser");
        if(!$user) return $this->redirect($this->generateUrl('authme_login'));
        else $al->setUsuario($user);        


        $al->setPhoto($entity); 
        $al->setNotLike(false); 
        $al->setClientIp($request->getClientIp());


        $fechaVotaciones=$entity->getContest()[0]->getFechaVotaciones();
        $fechaFin=$entity->getContest()[0]->getFechaFin();
        $fechaActual=new \DateTime("now");
        if($fechaVotaciones<$fechaActual && $fechaActual<$fechaFin){
            $r = $em->getRepository('FiterPhotoContestBundle:PhotoLike')->checkCanLike($user,$id);
            $canLike = !($r[0][1]>0);
            if($canLike){
                $entity->incrementaLikes();
                $em->persist($entity);
                $em->persist($al);
                $em->flush();
                $translated = $this->get('translator')->trans('main.phtotoContestVoteSucces');
                $session->getFlashBag()->add('notice', $translated);
            }else{
                $translated = $this->get('translator')->trans('main.phtotoContestVoteError');
                $session->getFlashBag()->add('error', $translated);
            }
        }elseif($fechaActual>$fechaFin){
            $translated = $this->get('translator')->trans(
                'main.phtotoContestVoteErrorFechaFin %fecha%',
                array('%fecha%' => $fechaFin->format("d M Y H:i:s"))
            );
            $session->getFlashBag()->add('error', $translated);
        }else{
            $translated = $this->get('translator')->trans(
                'main.phtotoContestVoteErrorFechaVotaciones %fecha%',
                array('%fecha%' => $fechaVotaciones->format("d M Y H:i:s"))
            );
            $session->getFlashBag()->add('error', $translated);
        }
        //return $this->redirect($this->generateUrl('articulo_show', array('id' => $entity->getId())));
        $referer = $request->headers->get('referer');      
        return new RedirectResponse($referer);
    }



    /**
     * Adds a dislike to an Photo entity.
     *
     * @Route("/{id}/dislike", name="photo_dislike")
     * @Template()
     */
    public function disLikeAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager('minecraft');
        $entity = $em->getRepository('FiterPhotoContestBundle:Photo')->find($id);
        if (!$entity) throw $this->createNotFoundException('Unable to find Photo entity.');

        $al  = new PhotoLike();
        
        $session  = $this->get("session");
        $user = $session->get("MinecraftUser");
        if(!$user) return $this->redirect($this->generateUrl('authme_login'));
        else $al->setUsuario($user);  


        $al->setPhoto($entity); 
        $al->setNotLike(true); 
        $al->setClientIp($request->getClientIp());


        $fechaVotaciones=$entity->getContest()[0]->getFechaVotaciones();
        $fechaFin=$entity->getContest()[0]->getFechaFin();
        $fechaActual=new \DateTime("now");
        if($fechaVotaciones<$fechaActual && $fechaActual<$fechaFin){
            $r = $em->getRepository('FiterPhotoContestBundle:PhotoLike')->checkCanLike($user,$id);
            $canLike = !($r[0][1]>0);
            if($canLike){
                $entity->incrementaDisLikes();
                $em->persist($entity);
                $em->persist($al);
                $em->flush();
                $translated = $this->get('translator')->trans('main.phtotoContestVoteSucces');
                $session->getFlashBag()->add('notice', $translated);
            }else{
                $translated = $this->get('translator')->trans('main.phtotoContestVoteError');
                $session->getFlashBag()->add('error', $translated);
            } 
        }elseif($fechaActual>$fechaFin){
            $translated = $this->get('translator')->trans(
                'main.phtotoContestVoteErrorFechaFin %fecha%',
                array('%fecha%' => $fechaFin->format("d M Y H:i:s"))
            );
            $session->getFlashBag()->add('error', $translated);
        }else{
            $translated = $this->get('translator')->trans(
                'main.phtotoContestVoteErrorFechaVotaciones %fecha%',
                array('%fecha%' => $fechaVotaciones->format("d M Y H:i:s"))
            );
            $session->getFlashBag()->add('error', $translated);
        }
        //return $this->redirect($this->generateUrl('articulo_show', array('id' => $entity->getId())));
        $referer = $request->headers->get('referer');      
        return new RedirectResponse($referer);
    }






    /**
     * Lists Photo entities by contest.
     * @Route("/contest/{contestSlug}", name="photo_by_context")
     * @Template()
     */
    public function indexByContestAction($contestSlug){
        $em = $this->getDoctrine()->getManager('minecraft');
        $contest = $em->getRepository('FiterPhotoContestBundle:Contest')->findOneBySlug($contestSlug);
        //$entities = $em->getRepository('FiterPhotoContestBundle:Photo')->findAllPhotoActiveContest($contestSlug);

        $paginador = $this->get('ideup.simple_paginator');
        $paginador->setItemsPerPage(1);
        $paginador->setMaxPagerItems(10);
        $entities = 
        $paginador->paginate(
            $entities = $em->getRepository('FiterPhotoContestBundle:Photo')->findAllPhotoActiveContest($contestSlug)
        )->getResult();

        if($entities){
            $entity=$entities[0];
            $entity->incrementaVisitas();
            $em->persist($entity);
            $em->flush();

            $fechaActual = new \DateTime("now");
            if($entity->getContest()[0]->getFechaFin() > $fechaActual ){
                $entity->setUsuario('oculto');    
            }
        }

        return array(
            'entities' => $entities,
            'paginador' => $paginador,
            'contest' => $contest,
        );
    }
    /**
     * Lists all Photo entities.
     * @Route("/", name="photo")
     * @Template()
     */
    public function indexAction(){
        $em = $this->getDoctrine()->getManager('minecraft');
        $entities = $em->getRepository('FiterPhotoContestBundle:Photo')->findAll();
        return array(
            'entities' => $entities,
        );
    }
    /**
     * Finds and displays a Photo entity.
     * @Route("/{id}/show", name="photo_show")
     * @Template()
     */
    public function showAction($id){
        $em = $this->getDoctrine()->getManager('minecraft');
        $entity = $em->getRepository('FiterPhotoContestBundle:Photo')->find($id);
        if (!$entity) throw $this->createNotFoundException('Unable to find Photo entity.');
        $deleteForm = $this->createDeleteForm($id);

        $entity->incrementaVisitas();
        $em->persist($entity);
        $em->flush();

        $fechaActual = new \DateTime("now");
        if($entity->getContest()[0]->getFechaFin() > $fechaActual ){
            $entity->setUsuario('oculto');    
        }

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Displays a form to create a new Photo entity.
     * @Route("/{contestId}/participa", name="photo_new")
     * @Template()
     */
    public function newAction(Request $request, $contestId) {
        $session  = $this->get("session");
        $user = $session->get("MinecraftUser");
        if(!$user) return $this->redirect($this->generateUrl('authme_login'));
        $em = $this->getDoctrine()->getEntityManager('minecraft');
        $contest = $em->getRepository('FiterPhotoContestBundle:Contest')->find($contestId);

        $fechaInicio=$contest->getFechaInicio();
        $fechaVotaciones=$contest->getFechaVotaciones();
        //$fechaFin=$contest->getFechaFin();
        $fechaActual=new \DateTime("now");
        if($fechaActual<$fechaInicio){
            $translated = $this->get('translator')->trans('main.phtotoContestNotInit');
            $session->getFlashBag()->add('error', $translated);
            $referer = $request->headers->get('referer');      
            return new RedirectResponse($referer);
        }
        if($fechaActual>$fechaVotaciones){
            $translated = $this->get('translator')->trans('main.phtotoContestNoNewParticipants');
            $session->getFlashBag()->add('error', $translated);
            $referer = $request->headers->get('referer');      
            return new RedirectResponse($referer);
        }
        $userHasPhoto = $em->getRepository('FiterPhotoContestBundle:Photo')->findAllPhotoContestUser($contestId, $user);
        if($userHasPhoto){
            $translated = $this->get('translator')->trans('main.phtotoContestUserHasPhotoError');
            $session->getFlashBag()->add('error', $translated);
            $referer = $request->headers->get('referer');      
            return new RedirectResponse($referer);
        }
        $entity = new Photo();
        $contest = $em->getRepository('FiterPhotoContestBundle:Contest')->find($contestId);
        if (!$contest) throw $this->createNotFoundException('Unable to find Contest entity.');
        $entity->setContest($contest);
        
        $form   = $this->createForm(new PhotoType(), $entity);
        return array(
            'entity' => $entity,
            'contest' => $contest,
            'form'   => $form->createView(),
            'user' => $user,
        );
    }
    /**
     * Creates a new Photo entity.
     * @Route("/{contestId}/create", name="photo_create")
     * @Method("POST")
     * @Template("FiterPhotoContestBundle:Photo:new.html.twig")
     */
    public function createAction(Request $request, $contestId) {

        $entity  = new Photo();

        $session  = $this->get("session");
        $user = $session->get("MinecraftUser");
        if(!$user) {
            return $this->redirect($this->generateUrl('authme_login'));
        }else{
            $em = $this->getDoctrine()->getEntityManager();
            $entity->setUsuario($user);
        }

        $em = $this->getDoctrine()->getEntityManager('minecraft');
        $contest = $em->getRepository('FiterPhotoContestBundle:Contest')->find($contestId);
        if (!$contest) throw $this->createNotFoundException('Unable to find Contest entity.');
        $entity->setContest($contest);

        $form = $this->createForm(new PhotoType(), $entity);
        $form->bind($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager('minecraft');
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('photo_show', array('id' => $entity->getId())));
        }
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
    /**
     * Displays a form to edit an existing Photo entity.
     * @Route("/{id}/edit", name="photo_edit")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager('minecraft');
        $entity = $em->getRepository('FiterPhotoContestBundle:Photo')->find($id);
        if (!$entity) throw $this->createNotFoundException('Unable to find Photo entity.');
        $editForm = $this->createForm(new PhotoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Edits an existing Photo entity.
     * @Route("/{id}/update", name="photo_update")
     * @Method("POST")
     * @Template("FiterPhotoContestBundle:Photo:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager('minecraft');
        $entity = $em->getRepository('FiterPhotoContestBundle:Photo')->find($id);
        if (!$entity) throw $this->createNotFoundException('Unable to find Photo entity.');
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PhotoType(), $entity);
        $editForm->bind($request);
        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('photo_edit', array('id' => $id)));
        }
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Photo entity.
     * @Route("/{id}/delete", name="photo_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->bind($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager('minecraft');
            $entity = $em->getRepository('FiterPhotoContestBundle:Photo')->find($id);
            if (!$entity) throw $this->createNotFoundException('Unable to find Photo entity.');
            $em->remove($entity);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('photo'));
    }
    private function createDeleteForm($id) {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
