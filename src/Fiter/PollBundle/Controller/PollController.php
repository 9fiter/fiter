<?php

namespace Fiter\PollBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Fiter\DefaultBundle\Entity\Usuario;
use Fiter\PollBundle\Entity\Poll;
use Fiter\PollBundle\Entity\Field;
use Fiter\PollBundle\Form\PollType;

use Symfony\Component\HttpFoundation\Response;

/**
 * Poll controller.
 *
 * @Route("/poll")
 */
class PollController extends Controller{
    /**
     * Finds and displays a Poll entity.
     *
     * @Route("/{pollId}/results", name="_poll_results")
     * @Template()
     */
    public function resultsAction($pollId, $layout=true){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FiterPollBundle:Poll')->find($pollId);
        if (!$entity) throw $this->createNotFoundException('Unable to find Poll entity.');
        $fields = $entity->getFields();
        $res = array();
        foreach ($fields as $field) {
            $val = $em->getRepository('FiterPollBundle:Answer')->countAnswerByFieldIdDQL($field->getId());
            $res[] = $val[0][1];
        }
        $deleteForm = $this->createDeleteForm($pollId);
        if($layout)
            return $this->render('FiterPollBundle:Poll:results.html.twig', array(
                'fields'      => $fields,
                'results'      => $res,
                'entity'=> $entity,
                'delete_form' => $deleteForm->createView(),
            ));
        else
            return $this->render('FiterPollBundle:Poll:resultsSinLayout.html.twig', array(
                'fields'      => $fields,
                'results'      => $res,
                'entity'=> $entity,
                'delete_form' => $deleteForm->createView(),
            ));
    }
    /**
     * Lists all Poll entities.
     *
     * @Route("/", name="_poll")
     * @Template()
     */
    public function indexAction()    {
        $em = $this->getDoctrine()->getManager();
        $paginador = $this->get('ideup.simple_paginator');
        $paginador->setItemsPerPage(10);
        $paginador->setMaxPagerItems(10);
        $entities = 
        $paginador->paginate(
            $em->getRepository('FiterPollBundle:Poll')->findAllPollsActiveNotFinalizedFields()
        )->getResult();
        if (!$entities) throw $this->createNotFoundException('No se ha encontrado ningun resultado');
        return array(
            'entities' => $entities,
            'paginador' => $paginador
        );
    }
    /**
     * Lists2 all Poll entities.
     *
     * @Route("/usuario/{nombre}", name="_pollusuario")
     * @Template()
     */
    public function indexUsuarioAction($nombre,$layout=true)    {
        $em = $this->getDoctrine()->getManager();
        $usuario = new Usuario();
        $usuario = $em->getRepository('FiterDefaultBundle:Usuario')->findOneByUsername($nombre);
        $entities = $em->getRepository('FiterPollBundle:Poll')->findAllPollsByUser($usuario);
//        return array('entities' => $entities);


        $formato = "html";
        if($layout)
            return $this->render('FiterPollBundle:Poll:indexUsuario.'.$formato.'.twig', array(
                'entities' => $entities,
                'nombre' => $nombre,
                
                
            ));
        else
            return $this->render('FiterPollBundle:Poll:indexUsuarioSinLayout.'.$formato.'.twig', array(
                'entities' => $entities,
                'nombre' => $nombre,
                
            ));
    }
    /**
     * Finds and displays a Poll entity.
     *
     * @Route("/{id}/show", name="_poll_show")
     * @Template()
     */
    public function showAction($id){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FiterPollBundle:Poll')->find($id);
        //$entity = $em->getRepository('FiterPollBundle:Poll')->findAllPollsActiveNotFinalizedFields();
        if (!$entity) throw $this->createNotFoundException('Unable to find Poll entity.');
        $fields = $entity->getFields();
        $res = array();
        foreach ($fields as $field) {
            $val = $em->getRepository('FiterPollBundle:Answer')->countAnswerByFieldIdDQL($field->getId());
            $res[] = $val[0][1];
            //ladybug_dump($field);//ladybug_dump($entity);
        }
        //ladybug_dump($res[0][0][1]);
        //ladybug_dump($res[1][0][1]);
        //ladybug_dump($res);
        $deleteForm = $this->createDeleteForm($id);
        return array(
            'fields'      => $fields,
            'results'      => $res,
            'entity'=> $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Displays a form to create a new Poll entity.
     *
     * @Route("/new", name="_poll_new")
     * @Template()
     */
    public function newAction(){
        $entity = new Poll();
        //ladybug_dump($entity->getFields());
        
        $field1 = new Field();
        $field1->setTitle('');
        //$field1->setPoll($entity);
        $entity->addField($field1);

        $field2 = new Field();
        $field2->setTitle('');
        $entity->addField($field2);
        // $field3 = new Field();
        // $field3->setTitle('');
        // $entity->addField($field3);
        $form   = $this->createForm(new PollType(), $entity);
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
    /**
     * Creates a new Poll entity.
     *
     * @Route("/create", name="poll_create")
     * @Method("POST")
     * @Template("FiterPollBundle:Poll:new.html.twig")
     */
    public function createAction(Request $request){
        $entity  = new Poll();
        $form = $this->createForm(new PollType(), $entity);
        $form->bind($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $usr;
            if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
                $em = $this->getDoctrine()->getEntityManager();
                $usr = $em->getRepository('FiterDefaultBundle:Usuario')->findOneByUsername("Anónimo");
                $entity->setUsuario($usr);
            }else{
                $usr= $this->get('security.context')->getToken()->getUser();
                $entity->setUsuario($usr);        
            }
            $fields = $entity->getFields();
            $entity->setFields(null);
            //ladybug_dump($entity->getFields());
            $em->persist($entity);
            $em->flush();
            $entity->setFields($fields);
            foreach ($entity->getFields() as $field ) {
                $field->setPoll($entity);
            }
            $em->persist($entity);
            $em->flush();
            //return $this->redirect($this->generateUrl('poll', array() ));
            return $this->redirect($this->generateUrl('poll_show', array('id' => $entity->getId())));
            //return $this->redirect($this->generateUrl('poll_edit', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
    /**
     * Displays a form to edit an existing Poll entity.
     *
     * @Route("/{id}/edit", name="_poll_edit")
     * @Template()
     */
    public function editAction($id){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FiterPollBundle:Poll')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Poll entity.');
        }
        $editForm = $this->createForm(new PollType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Edits an existing Poll entity.
     *
     * @Route("/{id}/update", name="poll_update")
     * @Method("POST")
     * @Template("FiterPollBundle:Poll:edit.html.twig")
     */
    public function updateAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FiterPollBundle:Poll')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Poll entity.');
        }
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PollType(), $entity);
        $editForm->bind($request);
        if ($editForm->isValid()) {
            foreach ($entity->getFields() as $field ) {
                $field->setPoll($entity);
            }
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('poll_show', array('id' => $id)));
        }
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Poll entity.
     *
     * @Route("/{id}/delete", name="poll_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id){
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FiterPollBundle:Poll')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Poll entity.');
            }

            foreach ($entity->getFields() as $field ) {
                //$field->setPoll($entity);
                $em->remove($field);
            }



            $em->remove($entity);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('poll'));
    }
    private function createDeleteForm($id){
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
