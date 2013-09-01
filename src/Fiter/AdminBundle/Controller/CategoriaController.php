<?php

namespace Fiter\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Fiter\DefaultBundle\Entity\Categoria;
use Fiter\DefaultBundle\Entity\Articulo;
use Fiter\AdminBundle\Form\CategoriaType;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

/**
 * Categoria controller.
 * @Route("/categoria")
 */
class CategoriaController extends Controller{
       
    /**
     * Lists all Categoria entities.
     * @Route("/", name="_admin_categoria")
     * @Template()
     */
    public function indexAction(){
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FiterDefaultBundle:Categoria')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Categoria entity.
     * @Route("/{id}/{slug}/ver", name="_admin_categoria_show")
     * @Template()
     */
    public function showAction($id,$slug){
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FiterDefaultBundle:Categoria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Categoria entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Categoria entity.
     * @Route("/nuevo", name="_admin_categoria_new")
     * @Template()
     */
    public function newAction(){
        $entity = new Categoria();
        $form   = $this->createForm(new CategoriaType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Categoria entity.
     * @Route("/crear", name="admin_categoria_create")
     * @Method("POST")
     * @Template("FiterDefaultBundle:Categoria:new.html.twig")
     */
    public function createAction(Request $request){
        $entity  = new Categoria();
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            $em = $this->getDoctrine()->getEntityManager();
            $usr = $em->getRepository('FiterDefaultBundle:Usuario')->findOneByUsername("Anónimo");
            $entity->setUsuario($usr);
        }else{
            $usr= $this->get('security.context')->getToken()->getUser();
            $entity->setUsuario($usr);        
        }
        $form = $this->createForm(new CategoriaType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            
            // creando la ACL
            $aclProvider = $this->get('security.acl.provider');
            $objectIdentity = ObjectIdentity::fromDomainObject($entity);
            $acl = $aclProvider->createAcl($objectIdentity);

            // recupera la identidad de seguridad del usuario
            // registrado actualmente
            $securityContext = $this->get('security.context');
            //$user = $securityContext->getToken()->getUser();
            $securityIdentity = UserSecurityIdentity::fromAccount($usr);

            // otorga permiso de propietario
            $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
            $aclProvider->updateAcl($acl);

            return $this->redirect($this->generateUrl('categoria_show', array('id' => $entity->getId(), 'slug' => $entity->getSlug() )));
        }
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Categoria entity.
     * @Route("/{id}/{slug}/editar", name="admin_categoria_edit")
     * @Template()
     */
    public function editAction($id,$slug){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FiterDefaultBundle:Categoria')->find($id);
        if (!$entity) throw $this->createNotFoundException('Unable to find Categoria entity.');
        $securityContext = $this->get('security.context');
        if (false === $securityContext->isGranted('EDIT', $entity)){  // verifica el acceso para edición
            if(!$securityContext->isGranted('ROLE_ADMIN'))
                throw new AccessDeniedException('No tienes permiso para editar esta categoría');
        }
        $editForm = $this->createForm(new CategoriaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Categoria entity.
     * @Route("/{id}/{slug}/actualizar", name="admin_categoria_update")
     * @Method("POST")
     * @Template("FiterDefaultBundle:Categoria:edit.html.twig")
     */
    public function updateAction(Request $request, $id, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FiterDefaultBundle:Categoria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Categoria entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new CategoriaType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('categoria_edit', array('id' => $id, 'slug' => $slug)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Categoria entity.
     * @Route("/{id}/eliminar", name="admin_categoria_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id){
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FiterDefaultBundle:Categoria')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Categoria entity.');
            }

            $em->remove($entity);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('categoria'));
    }

    private function createDeleteForm($id){
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    /**
     * Adds a like to an Categoria entity.
     * @Route("/{id}/like", name="admin_categoria_like")
     * @Template()
     */
    public function likeAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FiterDefaultBundle:Categoria')->find($id);
        $entity->incrementaLikes();
        $em->persist($entity);
        $em->flush();
        
        if (!$entity) throw $this->createNotFoundException('Unable to find Articulo entity.');
        
        $referer = $request->headers->get('referer');      
        return new RedirectResponse($referer);
    }
    
    /**
     * Adds a dislike to an Categoria entity.
     *
     * @Route("/{id}/dislike", name="admin_categoria_dislike")
     * @Template()
     */
    public function disLikeAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FiterDefaultBundle:Categoria')->find($id);
        $entity->incrementaDisLikes();
        $em->persist($entity);
        $em->flush();
        
        if (!$entity) throw $this->createNotFoundException('Unable to find Articulo entity.');
        
        $referer = $request->headers->get('referer');      
        return new RedirectResponse($referer);
    }

    /**
     * Lists all Categoria and subcategoria entities.
     * @Route("/menu/{slug}", name="admin_menucategoria")
     * @Template()
     */
    public function menuAction($slug){
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('FiterDefaultBundle:Categoria')->findMenuCategoriasNoVacias();
        return array(
            'entities' => $entities,
            'slug' => $slug,
        );
    }
}
