<?php

namespace Fiter\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Fiter\DefaultBundle\Entity\Usuario;
use Fiter\DefaultBundle\Entity\Articulo;
use Fiter\DefaultBundle\Entity\Categoria;
use Fiter\AdminBundle\Form\ArticuloType;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

use Fiter\DefaultBundle\Entity\VideoYoutube;
use Fiter\DefaultBundle\Entity\ListaYoutube;

/**
 * Articulo controller.
 *
 * @Route("/articulo")
 */
class ArticuloController extends Controller
{
    
    /**
     * Lists all Articulo entities.
     *
     * @Route("/", name="_admin_articulo")
     * @Template()
     */
    public function indexAction(){
        $em = $this->getDoctrine()->getManager();

        $paginador = $this->get('ideup.simple_paginator');
        $paginador->setItemsPerPage(50);
        $paginador->setMaxPagerItems(10);
        
        $entities = 
        $paginador->paginate(
            $em->getRepository('FiterDefaultBundle:Articulo')->findTodosLosArticulosDQL()
        )->getResult();
        
        if (!$entities) throw $this->createNotFoundException('No se ha encontrado ningun resultado');
        

        return array(
            'entities' => $entities,
            'paginador' => $paginador
        );
    }
    /**
     * Lists all Articulo entities by categoria.
     *
     * @Route("/categoria/{slug}/", name="_admin_articulocategoria")
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
        $paginador->setItemsPerPage(50);
        $paginador->setMaxPagerItems(10);
        
        $entities = 
        $paginador->paginate(
            $em->getRepository('FiterDefaultBundle:Articulo')->findAllArticulosCategoria($slug)
        )->getResult();
        
        if (!$entities) { throw $this->createNotFoundException('No se ha encontrado ningun resultado'); }
        
        return $this->render('FiterAdminBundle:Articulo:indexCategoria.html.twig', array(
            'entities' => $entities,
            'categoriaSlug' => $slug,
            'paginador' => $paginador
        ));
    }
    
    /**
     * Lists all Articulo entities by categoria.
     *
     * @Route("/usuario/{nombre}/", name="_admin_articulousuario")
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
            $em->getRepository('FiterDefaultBundle:Articulo')->findAllArticulosUsuario($nombre)
        )->getResult();
        //if (!$entities) { throw $this->createNotFoundException('No se ha encontrado ningun resultado'); }        
        if($layout)
            return $this->render('FiterAdminBundle:Articulo:indexUsuario.html.twig', array(
                'entities' => $entities,
                'nombre' => $nombre,
                'paginador' => $paginador
            ));
        else
            return $this->render('FiterAdminBundle:Articulo:indexUsuarioSinLayout.html.twig', array(
                'entities' => $entities,
                'nombre' => $nombre,
                'paginador' => $paginador
            ));
    }

    /**
     * Finds and displays a Articulo entity.
     *
     * @Route("/{id}/{slug}/ver", name="_admin_articulo_show")
     * @Template()
     */
    public function showAction($id,$slug){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FiterDefaultBundle:Articulo')->find($id);
        $entity->incrementaVisitas();
        $em->persist($entity);
        $em->flush();
        
        //ladybug_dump($entity);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Articulo entity.');
        }
        $deleteForm = $this->createDeleteForm($id);
        return array(
            'entity'      => $entity,
            'titulo'      => $entity->getTitulo(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Articulo entity.
     *
     * @Route("/nuevo", name="_admin_articulo_new")
     * @Template()
     */
    public function newAction(){
        $entity = new Articulo();
        
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
        
        
        $form   = $this->createForm(new ArticuloType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Articulo entity.
     *
     * @Route("/crear", name="_admin_articulo_create")
     * @Method("POST")
     * @Template("FiterDefaultBundle:Articulo:new.html.twig")
     */
    public function createAction(Request $request){
        $entity  = new Articulo();
        $usr;
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            $em = $this->getDoctrine()->getEntityManager();
            $usr = $em->getRepository('FiterDefaultBundle:Usuario')->findOneByUsername("Anónimo");
            $entity->setUsuario($usr);
        }else{
            $usr= $this->get('security.context')->getToken()->getUser();
            $entity->setUsuario($usr);        
        }
        $form = $this->createForm(new ArticuloType(), $entity);
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

            return $this->redirect($this->generateUrl('articulo_show', array('id' => $entity->getId(),'slug' => $entity->getSlug())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Articulo entity.
     *
     * @Route("/{id}/{slug}/editar", name="_admin_articulo_edit")
     * @Template()
     */
    public function editAction($id,$slug)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FiterDefaultBundle:Articulo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Articulo entity.');
        }
        
        $securityContext = $this->get('security.context');
        if (false === $securityContext->isGranted('EDIT', $entity)){  // verifica el acceso para edición
            if(!$securityContext->isGranted('ROLE_ADMIN'))
                throw new AccessDeniedException('No tienes permiso para editar este artículo');
        }

        $editForm = $this->createForm(new ArticuloType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Articulo entity.
     *
     * @Route("/{id}/{slug}/actualizar", name="_admin_articulo_update")
     * @Method("POST")
     * @Template("FiterDefaultBundle:Articulo:edit.html.twig")
     */
    public function updateAction(Request $request, $id, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FiterDefaultBundle:Articulo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Articulo entity.');
        }
        
        $originalTags = array();
        foreach ($entity->getVideosYoutube() as $videoYoutube) {
            $originalTags[] = $videoYoutube;
        }
        
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ArticuloType(), $entity);
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
                $videoYoutube->getArticulos()->removeElement($entity);
                // if it were a ManyToOne relationship, remove the relationship like this
                // $tag->setTask(null);
                $em->persist($videoYoutube);
                // if you wanted to delete the Tag entirely, you can also do that
                // $em->remove($tag);
            }
            
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_articulo_show', array('id' => $id,'slug' => $slug )));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Articulo entity.
     *
     * @Route("/{id}/eliminar", name="_admin_articulo_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FiterDefaultBundle:Articulo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Articulo entity.');
            }
            
            $originalTags = $entity->getVideosYoutube();
            
            foreach ($originalTags as $videoYoutube) {
                $videoYoutube->getArticulos()->removeElement($entity);
                $em->persist($videoYoutube);
                $em->remove($videoYoutube);
            }
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('articulo'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }





     /**
     * Lista articulos con más visitas
     *
     * @Route("/listaMasVistos", name="_admin_listaMasVistos")
     * @Template("FiterDefaultBundle:Articulo:listaTop.html.twig")
     */
    public function listaMasVistosAction(){
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('FiterDefaultBundle:Articulo')->findListaMasVistos();
        if (!$entities) throw $this->createNotFoundException('No se ha encontrado ningun resultado');

        return array(
            'entities' => $entities
        );
    }
    
    /**
     * Lista articulos con más visitas
     *
     * @Route("/listaMasValorados", name="_admin_listaMasValorados")
     * @Template("FiterDefaultBundle:Articulo:listaTop.html.twig")
     */
    public function listaMasValoradosAction(){
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('FiterDefaultBundle:Articulo')->findListaMasValorados();
        if (!$entities) throw $this->createNotFoundException('No se ha encontrado ningun resultado');

        return array(
            'entities' => $entities
        );
    }
    
     /**
     * Lista de últimos artículos actualizados
     *
     * @Route("/listaActualizaciones", name="_admin_listaActualizaciones")
     * @Template("FiterDefaultBundle:Articulo:listaTop.html.twig")
     */
    public function listaActualizacionesAction(){
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('FiterDefaultBundle:Articulo')->findListaActualizaciones();
        if (!$entities) throw $this->createNotFoundException('No se ha encontrado ningun resultado');

        return array(
            'entities' => $entities
        );
    }
    
    /**
     * Lista de últimos artículos actualizados
     *
     * @Route("/listaRelacionados/{slug}", name="_admin_listaRelacionados")
     * @Template("FiterDefaultBundle:Articulo:listaTop.html.twig")
     */
    public function listaRelacionadosAction($slug){
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('FiterDefaultBundle:Articulo')->findListaRelacionados($slug);
        if (!$entities) throw $this->createNotFoundException('No se ha encontrado ningun resultado');

        return array(
            'entities' => $entities
        );
    }

    /**
     * Adds a like to an Articulo entity.
     *
     * @Route("/{id}/like", name="_admin_articulo_like")
     * @Template()
     */
    public function likeAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FiterDefaultBundle:Articulo')->find($id);
        $entity->incrementaLikes();
        $em->persist($entity);
        $em->flush();
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Articulo entity.');
        }
        
        //return $this->redirect($this->generateUrl('articulo_show', array('id' => $entity->getId())));
        $referer = $request->headers->get('referer');      
        return new RedirectResponse($referer);
    }
    
    /**
     * Adds a dislike to an Articulo entity.
     *
     * @Route("/{id}/dislike", name="_admin_articulo_dislike")
     * @Template()
     */
    public function disLikeAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FiterDefaultBundle:Articulo')->find($id);
        $entity->incrementaDisLikes();
        $em->persist($entity);
        $em->flush();
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Articulo entity.');
        }
        
        //return $this->redirect($this->generateUrl('articulo_show', array('id' => $entity->getId())));
        $referer = $request->headers->get('referer');      
        return new RedirectResponse($referer);
    }
}