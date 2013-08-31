<?php

namespace Fiter\MinecraftSchematicBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Fiter\MinecraftSchematicBundle\Entity\Schematic;
use Fiter\MinecraftSchematicBundle\Entity\SchematicLike;
use Fiter\MinecraftSchematicBundle\Form\SchematicType;
use Fiter\MinecraftSchematicBundle\Form\SchematicNewType;

use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

/**
 * Schematic controller.
 *
 * @Route("/schematic")
 */
class SchematicController extends Controller
{
    /**
     * Lists all Schematic entities.
     *
     * @Route("/", name="schematic")
     * @Template()
     */
    public function indexAction(){
        
        $em = $this->getDoctrine()->getManager();
        $paginador = $this->get('ideup.simple_paginator');
        $paginador->setItemsPerPage(10);
        $paginador->setMaxPagerItems(10);
        $entities = 
        $paginador->paginate(
            //$em->getRepository('FiterDefaultBundle:Articulo')->findTodosLosArticulosActivosDQL()
            $em->getRepository('FiterMinecraftSchematicBundle:Schematic')->findAll()
        )->getResult();
        //if (!$entities) throw $this->createNotFoundException('No se ha encontrado ningun resultado');
        //ladybug_dump($entities);
        return array(
            'entities' => $entities,
            'paginador' => $paginador
        );
    }

    /**
     * Finds and displays a Schematic entity.
     *
     * @Route("/{id}/show", name="schematic_show")
     * @Route("/plsch/{id}", name="schematic_show_permanent")
     * @Template()
     */
    public function showAction($id){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FiterMinecraftSchematicBundle:Schematic')->find($id);
        if (!$entity) throw $this->createNotFoundException('Unable to find Schematic entity.');
        $entity->incrementaVisitas();
        $em->persist($entity);
        $em->flush();

        $deleteForm = $this->createDeleteForm($id);

        //ladybug_dump($entity->getPathSchematic());


        $fileUploader = $this->get('punk_ave.file_uploader');
        $fileUploader->syncFiles(
            array('from_folder' => '/tmp/schematicImgs/' . $entity->getId(),
            'to_folder' => '/schematicImgs/' . $entity->getId(),
            'remove_from_folder' => true,
            'create_to_folder' => true)
        );


        $files = $fileUploader->getFiles(array('folder' => 'schematicImgs/' . $entity->getId()));
        //ladybug_dump($files);

        $thread_id = "schematic_$id";
        $thread = $this->container->get('fos_comment.manager.thread')->findThreadById($thread_id);
        if (null === $thread) {
            $thread = $this->container->get('fos_comment.manager.thread')->createThread();
            $thread->setId($thread_id);
            //$thread->setPermalink($request->getUri());
            $thread->setPermalink("/art/plsch/$id");

            // Add the thread
            $this->container->get('fos_comment.manager.thread')->saveThread($thread);
        }
        $comments = $this->container->get('fos_comment.manager.comment')->findCommentTreeByThread($thread);
        //ladybug_dump($thread);
        //ladybug_dump($comments);


        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'files'=> $files,
            'comments' => $comments,
            'thread' => $thread,
        );
    }

    /**
     * Displays a form to create a new Schematic entity.
     *
     * @Route("/new", name="schematic_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Schematic();
        $form   = $this->createForm(new SchematicNewType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Schematic entity.
     *
     * @Route("/create", name="schematic_create")
     * @Method("POST")
     * @Template("FiterMinecraftSchematicBundle:Schematic:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Schematic();



        $usr;
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            $em = $this->getDoctrine()->getEntityManager();
            $usr = $em->getRepository('FiterDefaultBundle:Usuario')->findOneByUsername("Anónimo");
            $entity->setUsuario($usr);
        }else{
            $usr= $this->get('security.context')->getToken()->getUser();
            $entity->setUsuario($usr);        
        }

        $form = $this->createForm(new SchematicType(), $entity);
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

            return $this->redirect($this->generateUrl('schematic_edit', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Schematic entity.
     * @Route("/{id}/edit", name="schematic_edit")
     * @Template()
     */
    public function editAction($id){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FiterMinecraftSchematicBundle:Schematic')->find($id);
        if (!$entity) throw $this->createNotFoundException('Unable to find Schematic entity.');

        $securityContext = $this->get('security.context');
        if (false === $securityContext->isGranted('EDIT', $entity)){  // verifica el acceso para edición
            if(!$securityContext->isGranted('ROLE_ADMIN'))
                throw new AccessDeniedException('No tienes permiso para editar este schematic');
        }


        $editForm = $this->createForm(new SchematicType(), $entity);
        $deleteForm = $this->createDeleteForm($id);
        if ($entity->getId()){
            $this->get('punk_ave.file_uploader')->syncFiles(
                array(
                  'from_folder' => 'schematicImgs/' . $entity->getId(), 
                  'to_folder' => 'tmp/schematicImgs/' . $entity->getId(),
                  'create_to_folder' => true
                )
            );
        }
        $existingFiles = $this->get('punk_ave.file_uploader')->getFiles(array('folder' => 'tmp/schematicImgs/' . $entity->getId()));
        //ladybug_dump($existingFiles);
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'existingFiles' => $existingFiles,
        );
    }
    /**
     * Edits an existing Schematic entity.
     * @Route("/{id}/update", name="schematic_update")
     * @Method("POST")
     * @Template("FiterMinecraftSchematicBundle:Schematic:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FiterMinecraftSchematicBundle:Schematic')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Schematic entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new SchematicType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('schematic_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Schematic entity.
     *
     * @Route("/{id}/delete", name="schematic_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FiterMinecraftSchematicBundle:Schematic')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Schematic entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('schematic'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }




    /**
     *
     * @Route("/upload", name="schematic_upload")
     * @Template()
     */
    public function uploadAction(){
        $editId = $this->getRequest()->get('editId');
        if (!preg_match('/^\d+$/', $editId)){
            throw new Exception("Bad edit id");
        }
        $this->get('punk_ave.file_uploader')->handleFileUpload(array('folder' => 'tmp/schematicImgs/' . $editId));
    }


















    /**
     * Adds a like to an Articulo entity.
     *
     * @Route("/{id}/like", name="schematic_like")
     * @Template()
     */
    public function likeAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FiterMinecraftSchematicBundle:Schematic')->find($id);
        if (!$entity) throw $this->createNotFoundException('Unable to find Articulo entity.');

        $al  = new SchematicLike();
        $usr;
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
            //$em = $this->getDoctrine()->getEntityManager();
            $usr = $em->getRepository('FiterDefaultBundle:Usuario')->findOneByUsername("Anónimo");
            $al->setUsuario($usr);

        }else{
            $usr= $this->get('security.context')->getToken()->getUser();
            $al->setUsuario($usr);        
        }
        $al->setSchematic($entity); 
        $al->setNotLike(false); 
        $al->setClientIp($request->getClientIp());

        $r = $em->getRepository('FiterMinecraftSchematicBundle:SchematicLike')->checkCanLike($usr->getId(),$id);
        $canLike = !($r[0][1]>0);
        // ladybug_dump($id);
        // ladybug_dump($usr->getId());
        // ladybug_dump($r);
        // ladybug_dump($canLike);
        if($canLike){
            $entity->incrementaLikes();
            $em->persist($entity);
            $em->persist($al);
            $em->flush();
        }
        
        //return $this->redirect($this->generateUrl('articulo_show', array('id' => $entity->getId())));
        $referer = $request->headers->get('referer');      
        return new RedirectResponse($referer);
    }
    
    /**
     * Adds a dislike to an Articulo entity.
     *
     * @Route("/{id}/dislike", name="schematic_dislike")
     * @Template()
     */
    public function disLikeAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FiterMinecraftSchematicBundle:Schematic')->find($id);
        if (!$entity) throw $this->createNotFoundException('Unable to find Articulo entity.');

        $al  = new SchematicLike();
        $usr;
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
            //$em = $this->getDoctrine()->getEntityManager();
            $usr = $em->getRepository('FiterDefaultBundle:Usuario')->findOneByUsername("Anónimo");
            $al->setUsuario($usr);

        }else{
            $usr= $this->get('security.context')->getToken()->getUser();
            $al->setUsuario($usr);        
        }
        $al->setSchematic($entity); 
        $al->setNotLike(true); 
        $al->setClientIp($request->getClientIp());

        $r = $em->getRepository('FiterMinecraftSchematicBundle:SchematicLike')->checkCanLike($usr->getId(),$id);
        $canLike = !($r[0][1]>0);
        // ladybug_dump($id);
        // ladybug_dump($usr->getId());
        // ladybug_dump($r);
        // ladybug_dump($canLike);
        if($canLike){

            $entity->incrementaDisLikes();
            $em->persist($entity);
            $em->persist($al);
            $em->flush();
        }      
        
        //return $this->redirect($this->generateUrl('articulo_show', array('id' => $entity->getId())));
        $referer = $request->headers->get('referer');      
        return new RedirectResponse($referer);
    }




}
