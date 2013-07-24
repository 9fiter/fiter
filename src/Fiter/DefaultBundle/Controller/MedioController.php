<?php

namespace Fiter\DefaultBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Fiter\DefaultBundle\Entity\Usuario;
use Fiter\DefaultBundle\Entity\Medio;
use Fiter\DefaultBundle\Entity\Categoria;
use Fiter\DefaultBundle\Form\MedioType;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

use Fiter\DefaultBundle\Form\Type\VideoYoutubeType;
use Fiter\DefaultBundle\Entity\VideoYoutube;


use Fiter\DefaultBundle\Form\Type\ListaYoutubeType;
use Fiter\DefaultBundle\Entity\ListaYoutube;

/**
 * Medio controller.
 *
 * @Route("/medio")
 */
class MedioController extends Controller
{
    /**
     * Lists all Medio entities by categoria.
     *
     * @Route("/categoria/{slug}/", name="mediocategoria")
     * @Template()
     */
    public function indexCategoriaAction($slug){
        $em = $this->getDoctrine()->getManager();
        
        $categoria = new Categoria();
        $categoria = $em->getRepository('FiterDefaultBundle:Categoria')->findOneBySlug($slug);
        $categoria->incrementaVisitas();
        $em->persist($categoria);
        $em->flush();
            
        $paginador = $this->get('ideup.simple_paginator');
        $paginador->setItemsPerPage(9);
        $paginador->setMaxPagerItems(10);
        
        $entities = 
        $paginador->paginate(
            $em->getRepository('FiterDefaultBundle:Medio')->findAllMediosCategoria($slug)
        )->getResult();
        
        if (!$entities) { throw $this->createNotFoundException('No se ha encontrado ningun resultado'); }
        
        return $this->render('FiterDefaultBundle:Medio:indexCategoria.html.twig', array(
            'entities' => $entities,
            'categoriaSlug' => $slug,
            'paginador' => $paginador
        ));
    }
    
    /**
     * Lists all Medio entities by categoria.
     *
     * @Route("/usuario/{nombre}/", name="mediousuario")
     * @Template()
     */
    public function indexUsuarioAction($nombre,$layout=true){
        $em = $this->getDoctrine()->getManager();
        
        $usuario = new Usuario();
        $usuario = $em->getRepository('FiterDefaultBundle:Usuario')->findById($nombre);
            
        $paginador = $this->get('ideup.simple_paginator');
        $paginador->setItemsPerPage(9);
        $paginador->setMaxPagerItems(10);
        
        $entities = 
        $paginador->paginate(
            $em->getRepository('FiterDefaultBundle:Medio')->findAllMediosUsuario($nombre)
        )->getResult();
        
        if (!$entities) { throw $this->createNotFoundException('No se ha encontrado ningun resultado'); }
        
        
        
        
        
        if($layout)
            return $this->render('FiterDefaultBundle:Medio:indexUsuario.html.twig', array(
                'entities' => $entities,
                'nombre' => $nombre,
                'paginador' => $paginador
            ));
        else
            return $this->render('FiterDefaultBundle:Medio:indexUsuarioSinLayout.html.twig', array(
                'entities' => $entities,
                'nombre' => $nombre,
                'paginador' => $paginador
            ));
    }
    
    /**
     * Lists all Medio entities.
     *
     * @Route("/", name="medio")
     * @Template()
     */
    public function indexAction(){
        $em = $this->getDoctrine()->getManager();

        $paginador = $this->get('ideup.simple_paginator');
        $paginador->setItemsPerPage(5);
        $paginador->setMaxPagerItems(10);
        
        $entities = 
        $paginador->paginate(
            $em->getRepository('FiterDefaultBundle:Medio')->findTodosLosMediosActivosDQL()
        )->getResult();
        
        //if (!$entities) throw $this->createNotFoundException('No se ha encontrado ningun resultado');
        

        return array(
            'entities' => $entities,
            'paginador' => $paginador
        );
    }

    /**
     * Lista medios con más visitas
     *
     * @Route("/listaMasVistos", name="listaMasVistos")
     * @Template("FiterDefaultBundle:Medio:listaTop.html.twig")
     */
    public function listaMasVistosAction(){
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('FiterDefaultBundle:Medio')->findListaMasVistos();
        //if (!$entities) throw $this->createNotFoundException('No se ha encontrado ningun resultado');

        return array(
            'entities' => $entities
        );
    }
    
        /**
     * Lista medios con más visitas
     *
     * @Route("/listaMasValorados", name="listaMasValorados")
     * @Template("FiterDefaultBundle:Medio:listaTop.html.twig")
     */
    public function listaMasValoradosAction(){
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('FiterDefaultBundle:Medio')->findListaMasValorados();
        //if (!$entities) throw $this->createNotFoundException('No se ha encontrado ningun resultado');

        return array(
            'entities' => $entities
        );
    }
    
     /**
     * Lista de últimos artículos actualizados
     *
     * @Route("/listaActualizaciones", name="listaActualizaciones")
     * @Template("FiterDefaultBundle:Medio:listaTop.html.twig")
     */
    public function listaActualizacionesAction(){
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('FiterDefaultBundle:Medio')->findListaActualizaciones();
        if (!$entities) throw $this->createNotFoundException('No se ha encontrado ningun resultado');

        return array(
            'entities' => $entities
        );
    }
    
    
    
    /**
     * Lista de últimos artículos actualizados
     *
     * @Route("/listaRelacionados/{slug}", name="listaRelacionados")
     * @Template("FiterDefaultBundle:Medio:listaTop.html.twig")
     */
    public function listaRelacionadosAction($slug){
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('FiterDefaultBundle:Medio')->findListaRelacionados($slug);
        if (!$entities) throw $this->createNotFoundException('No se ha encontrado ningun resultado');

        return array(
            'entities' => $entities
        );
    }
    
    
    
    
    /**
     * Finds and displays a Medio entity.
     *
     * @Route("/{id}/{slug}/ver", name="medio_show")
     * @Template()
     */
    public function showAction($id,$slug){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FiterDefaultBundle:Medio')->find($id);
        $entity->incrementaVisitas();
        $em->persist($entity);
        $em->flush();
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Medio entity.');
        }
        $deleteForm = $this->createDeleteForm($id);
        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }
    
    
    
    
    /**
     * Adds a like to an Medio entity.
     *
     * @Route("/{id}/like", name="medio_like")
     * @Template()
     */
    public function likeAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FiterDefaultBundle:Medio')->find($id);
        $entity->incrementaLikes();
        $em->persist($entity);
        $em->flush();
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Medio entity.');
        }
        
        //return $this->redirect($this->generateUrl('medio_show', array('id' => $entity->getId())));
        $referer = $request->headers->get('referer');      
        return new RedirectResponse($referer);
    }
    
    /**
     * Adds a disLike to an Medio entity.
     *
     * @Route("/{id}/dislike", name="medio_dislike")
     * @Template()
     */
    public function disLikeAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FiterDefaultBundle:Medio')->find($id);
        $entity->incrementaDisLikes();
        $em->persist($entity);
        $em->flush();
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Medio entity.');
        }
        
        //return $this->redirect($this->generateUrl('medio_show', array('id' => $entity->getId())));
        $referer = $request->headers->get('referer');      
        return new RedirectResponse($referer);
    }
    
    
    
    
    
    
    
    

    /**
     * Displays a form to create a new Medio entity.
     *
     * @Route("/nuevo", name="medio_new")
     * @Template()
     */
    public function newAction(){
        $entity = new Medio();
        
        $tag1 = new VideoYoutube();
        $tag1->setEnlace('');
        $entity->getVideosYoutube()->add($tag1);
        
        /*
        $tag2 = new VideoYoutube();
        $tag2->setEnlace('');
        $entity->getVideosYoutube()->add($tag2);
         */
        $tag3 = new ListaYoutube();
        $tag3->setEnlace('');
        $entity->getListasYoutube()->add($tag3);
        
        
        $form   = $this->createForm(new MedioType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Medio entity.
     *
     * @Route("/crear", name="medio_create")
     * @Method("POST")
     * @Template("FiterDefaultBundle:Medio:new.html.twig")
     */
    public function createAction(Request $request){
        $entity  = new Medio();
        $usr;
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            $em = $this->getDoctrine()->getEntityManager();
            $usr = $em->getRepository('FiterDefaultBundle:Usuario')->findOneByUsername("Anónimo");
            $entity->setUsuario($usr);
        }else{
            $usr= $this->get('security.context')->getToken()->getUser();
            $entity->setUsuario($usr);        
        }
        $form = $this->createForm(new MedioType(), $entity);
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
            //$securityContext = $this->get('security.context');
            //$user = $securityContext->getToken()->getUser();
            $securityIdentity = UserSecurityIdentity::fromAccount($usr);

            // otorga permiso de propietario
            $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
            $aclProvider->updateAcl($acl);

            return $this->redirect($this->generateUrl('medio_show', array('id' => $entity->getId(),'slug' => $entity->getSlug())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Medio entity.
     *
     * @Route("/{id}/{slug}/editar", name="medio_edit")
     * @Template()
     */
    public function editAction($id,$slug)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FiterDefaultBundle:Medio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Medio entity.');
        }
        
        $securityContext = $this->get('security.context');
        if (false === $securityContext->isGranted('EDIT', $entity)){  // verifica el acceso para edición
            if(!$securityContext->isGranted('ROLE_ADMIN'))
                throw new AccessDeniedException('No tienes permiso para editar este artículo');
        }

        $editForm = $this->createForm(new MedioType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Medio entity.
     *
     * @Route("/{id}/{slug}/actualizar", name="medio_update")
     * @Method("POST")
     * @Template("FiterDefaultBundle:Medio:edit.html.twig")
     */
    public function updateAction(Request $request, $id, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FiterDefaultBundle:Medio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Medio entity.');
        }
        
        $originalTags = array();
        foreach ($entity->getVideosYoutube() as $videoYoutube) {
            $originalTags[] = $videoYoutube;
        }
        
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new MedioType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            
            
            foreach ($entity->getVideosYoutube() as $videoYoutube) {
                foreach ($originalTags as $key => $toDel) {
                    if ($toDel->getId() === $videoYoutube->getId()) {
                        unset($originalTags[$key]);
                    }
                }
            }
            // remove the relationship between the tag and the Task
            foreach ($originalTags as $videoYoutube) {
                // remove the Task from the Tag
                $videoYoutube->getMedios()->removeElement($entity);
                // if it were a ManyToOne relationship, remove the relationship like this
                // $tag->setTask(null);
                $em->persist($videoYoutube);
                // if you wanted to delete the Tag entirely, you can also do that
                // $em->remove($tag);
            }
            
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('medio_show', array('id' => $id,'slug' => $slug )));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Medio entity.
     *
     * @Route("/{id}/eliminar", name="medio_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FiterDefaultBundle:Medio')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Medio entity.');
            }
            
            $originalTags = $entity->getVideosYoutube();
            
            foreach ($originalTags as $videoYoutube) {
                $videoYoutube->getMedios()->removeElement($entity);
                $em->persist($videoYoutube);
                $em->remove($videoYoutube);
            }
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('medio'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
