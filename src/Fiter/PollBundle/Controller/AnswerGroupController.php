<?php

namespace Fiter\PollBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Fiter\PollBundle\Entity\AnswerGroup;
use Fiter\PollBundle\Form\AnswerGroupType;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;




/**
 * AnswerGroup controller.
 *
 * @Route("/answergroup")
 */
class AnswerGroupController extends Controller
{
    /**
     * Lists all AnswerGroup entities.
     *
     * @Route("/", name="answergroup")
     * @Template()
     */
    public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('FiterPollBundle:AnswerGroup')->findAll();
        return array(
            'entities' => $entities,
        );
    }

    /**
     * Lists all AnswerGroup entities by user.
     *
     * @Route("/user/{userId}", name="answergroupUser")
     * @Template()
     */
    public function indexUserAction($userId){
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('FiterPollBundle:AnswerGroup')->findAllAnswerGroupByUser($userId);
        return array(
            'entities' => $entities,
        );
    }

    /**
     * Lists all AnswerGroup entities by poll.
     *
     * @Route("/poll/{pollId}", name="answergroupPoll")
     * @Template()
     */
    public function indexPollAction($pollId){
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('FiterPollBundle:AnswerGroup')->findAllAnswerGroupByPoll($pollId);
        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a AnswerGroup entity.
     *
     * @Route("/{id}/show", name="answergroup_show")
     * @Template()
     */
    public function showAction($id){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FiterPollBundle:AnswerGroup')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AnswerGroup entity.');
        }
        $deleteForm = $this->createDeleteForm($id);
        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new AnswerGroup entity.
     *
     * @Route("/new", name="answergroup_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new AnswerGroup();
        $form   = $this->createForm(new AnswerGroupType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new AnswerGroup entity.
     *
     * @Route("/create", name="answergroup_create")
     * @Method("POST")
     * @Template("FiterPollBundle:AnswerGroup:new.html.twig")
     */
    public function createAction(Request $request){
        $entity  = new AnswerGroup();
        $usr;
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            $em = $this->getDoctrine()->getEntityManager();
            $usr = $em->getRepository('FiterDefaultBundle:Usuario')->findOneByUsername("Anónimo");
            $entity->setAuthor($usr);
        }else{
            $usr= $this->get('security.context')->getToken()->getUser();
            $entity->setAuthor($usr);        
        }
        //ladybug_dump($request);
        $entity->setClientIp($request->getClientIp());
        $form = $this->createForm(new AnswerGroupType(), $entity);
        $form->bind($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            // creando la ACL
            $aclProvider = $this->get('security.acl.provider');
            $objectIdentity = ObjectIdentity::fromDomainObject($entity);
            $acl = $aclProvider->createAcl($objectIdentity);

            $securityIdentity = UserSecurityIdentity::fromAccount($usr);
            // otorga permiso de propietario
            $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
            $aclProvider->updateAcl($acl);

            return $this->redirect($this->generateUrl('answergroup_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing AnswerGroup entity.
     *
     * @Route("/{id}/edit", name="answergroup_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FiterPollBundle:AnswerGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AnswerGroup entity.');
        }

        $editForm = $this->createForm(new AnswerGroupType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing AnswerGroup entity.
     *
     * @Route("/{id}/update", name="answergroup_update")
     * @Method("POST")
     * @Template("FiterPollBundle:AnswerGroup:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FiterPollBundle:AnswerGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AnswerGroup entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new AnswerGroupType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('answergroup_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a AnswerGroup entity.
     *
     * @Route("/{id}/delete", name="answergroup_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FiterPollBundle:AnswerGroup')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find AnswerGroup entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('answergroup'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
