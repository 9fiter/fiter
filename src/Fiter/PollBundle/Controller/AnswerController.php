<?php

namespace Fiter\PollBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Fiter\PollBundle\Entity\Answer;
use Fiter\PollBundle\Entity\Field;
use Fiter\PollBundle\Entity\AnswerGroup;
use Fiter\PollBundle\Form\AnswerType;

/**
 * Answer controller.
 *
 * @Route("/answer")
 */
class AnswerController extends Controller{

    /**
     * Lists all Answer entities.
     * @Route("/", name="answer")
     * @Template()
     */
    public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('FiterPollBundle:Answer')->findAll();
        return array(
            'entities' => $entities,
        );
    }

    /**
     * Lists all Answer entities by field.
     * @Route("/field/{fieldId}", name="answerField")
     * @Template()
     */
    public function indexFieldAction($fieldId){
        $em = $this->getDoctrine()->getManager();
        $field = $em->getRepository('FiterPollBundle:Field')->findOneBy(array('id' => $fieldId ));
        $entities = $em->getRepository('FiterPollBundle:Answer')->findBy(array('field' => $field ));
        return array( 'entities' => $entities, );
    }



    /**
     * Finds and displays a Answer entity.
     *
     * @Route("/{id}/show", name="answer_show")
     * @Template()
     */
    public function showAction($id){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FiterPollBundle:Answer')->find($id);
        if (!$entity) throw $this->createNotFoundException('Unable to find Answer entity.');
        $deleteForm = $this->createDeleteForm($id);
        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Answer entity.
     *
     * @Route("/new/{id}", name="answer_new")
     * @Template()
     */
    public function newAction($id){
        $entity = new Answer();
        $entity->setValue('1');
        $em = $this->getDoctrine()->getManager();
        $field = new Field();
        $field = $em->getRepository('FiterPollBundle:Field')->findOneById($id);
        $entity->setField($field);
        $form   = $this->createForm(new AnswerType(), $entity);
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Answer entity.
     *
     * @Route("/create/{fieldId}", name="answer_create")
     * @Template("FiterPollBundle:Answer:new.html.twig")
     */
    public function createAction(Request $request,$fieldId){
        
        
        $entity  = new Answer();
        $form = $this->createForm(new AnswerType(), $entity);
        $form->bind($request);
        $field  = new Field();
        $em = $this->getDoctrine()->getEntityManager();
        $field = $em->getRepository('FiterPollBundle:Field')->findOneById($fieldId);
        //ladybug_dump($field);
        $entity->asd($field);



        $ag  = new AnswerGroup();
        $usr;
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
            //$em = $this->getDoctrine()->getEntityManager();
            //$usr = $em->getRepository('FiterDefaultBundle:Usuario')->findOneByUsername("Anónimo");
            //$ag->setAuthor($usr);
        }else{
            $usr= $this->get('security.context')->getToken()->getUser();
            $ag->setAuthor($usr);        
        }
        $ag->setPoll($field->getPoll()); 
        $r = $em->getRepository('FiterPollBundle:Answer')->checkCanAnswer($usr->getId(),$field->getPoll()->getId());
        $canAnswer = !($r[0][1]>0);




        if($canAnswer){
            $ag->setClientIp($request->getClientIp());
            //$ag->setPoll()
            $em->persist($ag);
            $entity->setAnswerGroup($ag);
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('poll_results', array('pollId' => $entity->getField()->getPoll()->getId())));
        
       
        return array(
         'entity' => $entity,
         'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Answer entity.
     *
     * @Route("/create2", name="answer_create2")
     * @Method("POST")
     * @Template("FiterPollBundle:Answer:new.html.twig")
     */
    public function create2Action(Request $request){
        $entity  = new Answer();
        $form = $this->createForm(new AnswerType(), $entity);
        $form->bind($request);
        if ($form->isValid()) {
            $ag  = new AnswerGroup();
            $usr;
            if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
                $em = $this->getDoctrine()->getEntityManager();
                $usr = $em->getRepository('FiterDefaultBundle:Usuario')->findOneByUsername("Anónimo");
                $ag->setAuthor($usr);
            }else{
                $usr= $this->get('security.context')->getToken()->getUser();
                $ag->setAuthor($usr);        
            }
            $ag->setClientIp($request->getClientIp());
            //$ag->setPoll()
            //$em->persist($ag);
            $entity->setAnswerGroup($ag);
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            //return $this->redirect($this->generateUrl('answer_show', array('id' => $entity->getId())));
            //ladybug_dump($entity->getField()->getPoll()->getId());
            return $this->redirect($this->generateUrl('poll_results', array('pollId' => $entity->getField()->getPoll()->getId())));
        }
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Answer entity.
     *
     * @Route("/{id}/edit", name="answer_edit")
     * @Template()
     */
    public function editAction($id){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FiterPollBundle:Answer')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Answer entity.');
        }
        $editForm = $this->createForm(new AnswerType(), $entity);
        $deleteForm = $this->createDeleteForm($id);
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Answer entity.
     *
     * @Route("/{id}/update", name="answer_update")
     * @Method("POST")
     * @Template("FiterPollBundle:Answer:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FiterPollBundle:Answer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Answer entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new AnswerType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('answer_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Answer entity.
     *
     * @Route("/{id}/delete", name="answer_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FiterPollBundle:Answer')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Answer entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('answer'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
