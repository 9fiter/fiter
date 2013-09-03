<?php

namespace Fiter\DefaultBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Fiter\DefaultBundle\Entity\Usuario;
use Fiter\DefaultBundle\Entity\Articulo;
use Fiter\DefaultBundle\Entity\ArticuloLike;
use Fiter\DefaultBundle\Entity\Categoria;
use Fiter\DefaultBundle\Entity\SubCategoria;
use Fiter\DefaultBundle\Form\ArticuloType;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

use Fiter\DefaultBundle\Form\Type\VideoYoutubeType;
use Fiter\DefaultBundle\Entity\VideoYoutube;


use Fiter\DefaultBundle\Form\Type\ListaYoutubeType;
use Fiter\DefaultBundle\Entity\ListaYoutube;

use Ivory\LuceneSearchBundle\Model\Document;
use Ivory\LuceneSearchBundle\Model\Field;

use Fiter\DefaultBundle\Form\Type\MapType;
use Fiter\DefaultBundle\Entity\Map;


/**
 * Articulo controller.
 *
 * @Route("/articulo")
 */
class ArticuloController extends Controller{

    /**
     * Lists all Articulo entities by categoria.
     *
     * @Route("/categoria/{slugCategoria}/{slug}.{_format}", name="_articulosubcategoria", requirements={"_format" = "html|rss"} ,defaults={"_format" = "html" } ) 
     * @Template()
     */
    public function indexSubCategoriaAction($slugCategoria,$slug){
        $em = $this->getDoctrine()->getManager();
        $subcategoria = new SubCategoria();
        $subcategoria = $em->getRepository('FiterDefaultBundle:SubCategoria')->findOneBySlug($slug);

        //ladybug_dump($subcategoria);
        $subcategoria->incrementaVisitas();
        $em->persist($subcategoria);
        $em->flush();
        $paginador = $this->get('ideup.simple_paginator');
        $paginador->setItemsPerPage(10);
        $paginador->setMaxPagerItems(10);
        $entities = 
        $paginador->paginate(
            $em->getRepository('FiterDefaultBundle:Articulo')->findAllArticulosActivosSubCategoria($slug)
        )->getResult();
        //if (!$entities) { throw $this->createNotFoundException('No se ha encontrado ningun resultado'); }
        $formato = $this->get('request')->getRequestFormat();
        return $this->render('FiterDefaultBundle:Articulo:indexSubCategoria.'.$formato.'.twig', array(
            'entities' => $entities,
            'categoriaSlug' => $slugCategoria,
            'subCategoriaSlug' => $slug,
            'paginador' => $paginador
        ));
    }


    /**
     * Lists all Articulo entities by categoria.
     *
     * @Route("/categoria/{slug}.{_format}", name="_articulocategoria", requirements={"_format" = "html|rss"} ,defaults={"_format" = "html" } ) 
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
        $paginador->setItemsPerPage(10);
        $paginador->setMaxPagerItems(10);
        $entities = 
        $paginador->paginate(
            $em->getRepository('FiterDefaultBundle:Articulo')->findAllArticulosActivosCategoria($slug)
        )->getResult();
        //if (!$entities) { throw $this->createNotFoundException('No se ha encontrado ningun resultado'); }
        $formato = $this->get('request')->getRequestFormat();
        return $this->render('FiterDefaultBundle:Articulo:indexCategoria.'.$formato.'.twig', array(
            'entities' => $entities,
            'categoriaSlug' => $slug,
            'paginador' => $paginador
        ));
    }
    
    /**
     * Lists all Articulo entities by categoria.
     *
     * @Route("/usuario/{nombre}.{_format}", name="_articulousuario", requirements={"_format" = "html|rss"} ,defaults={"_format" = "html" } ) 
     * @Template()
     */
    public function indexUsuarioAction($nombre,$layout=true){
        $em = $this->getDoctrine()->getManager();
        
        $usuario = new Usuario();
        $usuario = $em->getRepository('FiterDefaultBundle:Usuario')->findById($nombre);
            
        $paginador = $this->get('ideup.simple_paginator');
        $paginador->setItemsPerPage(10);
        $paginador->setMaxPagerItems(10);
        
        $entities = 
        $paginador->paginate(
            $em->getRepository('FiterDefaultBundle:Articulo')->findAllArticulosUsuario($nombre)
        )->getResult();
        
        //if (!$entities) { throw $this->createNotFoundException('No se ha encontrado ningun resultado'); }
        $formato = $this->get('request')->getRequestFormat();
        if($layout)
            return $this->render('FiterDefaultBundle:Articulo:indexUsuario.'.$formato.'.twig', array(
                'entities' => $entities,
                'nombre' => $nombre,
                'paginador' => $paginador
            ));
        else
            return $this->render('FiterDefaultBundle:Articulo:indexUsuarioSinLayout.'.$formato.'.twig', array(
                'entities' => $entities,
                'nombre' => $nombre,
                'paginador' => $paginador
            ));
    }

    /**
     * Lists all Articulo entities.
     * @Route("/", name="_articulo" )
     * @Route("/alt/articulos.{_format}", name="_alt_articulo", requirements={"_format" = "rss|xml"} ,defaults={"_format" = "rss" } )
     * @Template()
     */
    public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $paginador = $this->get('ideup.simple_paginator');
        $paginador->setItemsPerPage(10);
        $paginador->setMaxPagerItems(10);
        $entities = 
        $paginador->paginate(
            $em->getRepository('FiterDefaultBundle:Articulo')->findTodosLosArticulosActivosDQL()
            //$em->getRepository('FiterDefaultBundle:Articulo')->findAllByLocale($this->getRequest()->getLocale())
        )->getResult();
        //if (!$entities) throw $this->createNotFoundException('No se ha encontrado ningun resultado');
        //ladybug_dump($entities);
        return array(
            'entities' => $entities,
            'paginador' => $paginador
        );
    }

    /**
     * Lists all Articulo entities.
     * @Template()
     */
    public function inactivosAction(){
        $em = $this->getDoctrine()->getManager();
        $paginador = $this->get('ideup.simple_paginator');
        $paginador->setItemsPerPage(10);
        $paginador->setMaxPagerItems(10);
        $entities = 
        $paginador->paginate(
            $em->getRepository('FiterDefaultBundle:Articulo')->findTodosLosArticulosInactivosDQL()
            //$em->getRepository('FiterDefaultBundle:Articulo')->findAllByLocale($this->getRequest()->getLocale())
        )->getResult();
        //if (!$entities) throw $this->createNotFoundException('No se ha encontrado ningun resultado');
        //ladybug_dump($entities);
        return array(
            'entities' => $entities,
            'paginador' => $paginador
        );
    }



    /**
     * Lista articulos con más visitas
     *
     * @Route("/listaMasVistos", name="listaMasVistos")
     * @Template("FiterDefaultBundle:Articulo:listaTop.html.twig")
     */
    public function listaMasVistosAction(){
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('FiterDefaultBundle:Articulo')->findListaMasVistos();
        //if (!$entities) throw $this->createNotFoundException('No se ha encontrado ningun resultado');

        return array(
            'entities' => $entities
        );
    }
    /**
     * Lista articulos con más visitas
     *
     * @Route("/listaMasValorados", name="listaMasValorados")
     * @Template("FiterDefaultBundle:Articulo:listaTop.html.twig")
     */
    public function listaMasValoradosAction(){
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('FiterDefaultBundle:Articulo')->findListaMasValorados();
        //if (!$entities) throw $this->createNotFoundException('No se ha encontrado ningun resultado');

        return array(
            'entities' => $entities
        );
    }
     /**
     * Lista de últimos artículos actualizados
     *
     * @Route("/listaActualizaciones", name="listaActualizaciones")
     * @Template("FiterDefaultBundle:Articulo:listaTop.html.twig")
     */
    public function listaActualizacionesAction(){
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('FiterDefaultBundle:Articulo')->findListaActualizaciones();
        //if (!$entities) throw $this->createNotFoundException('No se ha encontrado ningun resultado');

        return array(
            'entities' => $entities
        );
    }
    /**
     * Lista de últimos artículos actualizados
     *
     * @Route("/listaRelacionados/{slug}", name="listaRelacionados")
     * @Template("FiterDefaultBundle:Articulo:listaTop.html.twig")
     */
    public function listaRelacionadosAction($slug){
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('FiterDefaultBundle:Articulo')->findListaRelacionados($slug);
        //if (!$entities) throw $this->createNotFoundException('No se ha encontrado ningun resultado');
        return array('entities' => $entities);
    }
    /**
     * Adds a like to an Articulo entity.
     *
     * @Route("/{id}/like", name="articulo_like")
     * @Template()
     */
    public function likeAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FiterDefaultBundle:Articulo')->find($id);
        if (!$entity) throw $this->createNotFoundException('Unable to find Articulo entity.');

        $al  = new ArticuloLike();
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
        $al->setArticulo($entity); 
        $al->setNotLike(false); 
        $al->setClientIp($request->getClientIp());

        $r = $em->getRepository('FiterDefaultBundle:ArticuloLike')->checkCanLike($usr->getId(),$id);
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
     * @Route("/{id}/dislike", name="articulo_dislike")
     * @Template()
     */
    public function disLikeAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FiterDefaultBundle:Articulo')->find($id);
        if (!$entity) throw $this->createNotFoundException('Unable to find Articulo entity.');

        $al  = new ArticuloLike();
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
        $al->setArticulo($entity); 
        $al->setNotLike(true); 
        $al->setClientIp($request->getClientIp());

        $r = $em->getRepository('FiterDefaultBundle:ArticuloLike')->checkCanLike($usr->getId(),$id);
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

    /**
     * Displays a form to create a new Articulo entity.
     *
     * @Route("/nuevo", name="_articulo_new")
     * @Template()
     */
    public function newAction(Request $request){
        if (false === $this->get('security.context')->isGranted('ROLE_REDACTOR') and 
            false === $this->get('security.context')->isGranted('ROLE_EDITOR')) {
                $referer = $request->headers->get('referer');       
                $request->getSession()->setFlash('error', "Solo redactores y editores pueden añadir artículos.");
                return new RedirectResponse($referer);
        }
        $entity = new Articulo();
        $tag1 = new VideoYoutube();
        $tag1->setEnlace('');
        $entity->getVideosYoutube()->add($tag1);

        $tag2 = new Map();
        $tag2->setLat('');
        $tag2->setLang('');
        $entity->getMaps()->add($tag2);

        $tag3 = new ListaYoutube();
        $tag3->setEnlace('');
        $entity->getListasYoutube()->add($tag3);

        $locale = $this->get('request')->getLocale();

        //$form   = $this->createForm(new ArticuloType(), $entity, array('label' => $locale));
        $form = $this->createForm($this->get('form.type.articulo'), $entity, array('label' => $locale));

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Articulo entity.
     *
     * @Route("/crear", name="articulo_create")
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
        //$form = $this->createForm(new ArticuloType(), $entity);
        $form = $this->createForm($this->get('form.type.articulo'), $entity);
        $form->bind($request);
        //ladybug_dump($form);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            // creando la ACL
            $aclProvider = $this->get('security.acl.provider');
            $objectIdentity = ObjectIdentity::fromDomainObject($entity);
            $acl = $aclProvider->createAcl($objectIdentity);
            //Añadir al indice
            $index = $this->get('ivory_lucene_search')->getIndex('identifier1');
            $document = new Document();
            $document->addField(Field::keyword('titulo', $entity->getTitulo() ));
            $document->addField(Field::text('contenido', $entity->getContenido() ));
            $document->addField(Field::UnIndexed ('num_id', $entity->getId() ));
            $document->addField(Field::text('slug', $entity->getSlug() ));
            $document->addField(Field::text ('categoria', $entity->getCategoria()->get(0)->getNombre() ));
            $document->addField(Field::text ('path', $entity->getPath() ));
            if($entity->getPath()=="") $document->addField(Field::text ('path2', $entity->getCategoria()->get(0)->getPath() ));
            $document->addField(Field::text('usuario', $entity->getUsuario() ));
            $document->addField(Field::binary ('fechaPublicacion', $entity->getFechaPublicacion()->getTimestamp() ));
            $index->addDocument($document);
            $index->commit();
            $index->optimize();
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
     * crear indice
     *
     * @Route("/crearindice", name="crearIndice" )
     * @Template()
     */
    public function crearIndiceAction(){
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('FiterDefaultBundle:Articulo')->findTodosLosArticulos();
        //if (!$entities) throw $this->createNotFoundException('No se ha encontrado ningun resultado');
        //Reconstruir el indice
        $luceneSearch = $this->get('ivory_lucene_search');
        $luceneSearch->eraseIndex('identifier1');
        $index = $luceneSearch->getIndex('identifier1');
        foreach ($entities as $entity) {
            $document = new Document();
            $document->addField(Field::keyword('titulo', $entity->getTitulo() ));
            $document->addField(Field::text('contenido', $entity->getContenido(true) ));
            $document->addField(Field::UnIndexed ('num_id', $entity->getId() ));
            $document->addField(Field::text('slug', $entity->getSlug() ));
            $document->addField(Field::text ('categoria', $entity->getCategoria()->get(0)->getNombre() ));
            $document->addField(Field::text ('path', $entity->getPath() ));
            if($entity->getPath()=="") $document->addField(Field::text ('path2', $entity->getCategoria()->get(0)->getPath() ));
            $document->addField(Field::text('usuario', $entity->getUsuario() ));
            $document->addField(Field::binary ('fechaPublicacion', $entity->getFechaPublicacion()->getTimestamp() ));
            $index->addDocument($document);    
        }
        $index->commit();
        $index->optimize();
        return array('');
    }

    /**
     * Lists all Articulo entities by categoria.
     *
     * @Route("/buscar", name="_articulobuscar" ) 
     * @Template()
     */
    public function buscarAction(Request $request){  
        $texto = $request->query->get('q');
        $paginador = $this->get('ideup.simple_paginator');
        $paginador->setItemsPerPage(10);
        $paginador->setMaxPagerItems(10);
        $entities = $this->get('ivory_lucene_search')->getIndex('identifier1')->find($texto); 
        //if (!$entities) { throw $this->createNotFoundException('No se ha encontrado ningun resultado'); }
        return $this->render('FiterDefaultBundle:Articulo:buscar.html.twig', array(
            'entities' => $entities,
            'paginador' => $paginador,
            'busqueda' => $texto
        ));
    }

    /**
     * Displays a form to edit an existing Articulo entity.
     *
     * @Route("/{id}/{slug}/editar", name="articulo_edit")
     * @Template()
     */
    public function editAction($id,$slug){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FiterDefaultBundle:Articulo')->find($id);
        if (!$entity) throw $this->createNotFoundException('Unable to find Articulo entity.');
        //ladybug_dump($entity);
        //ladybug_dump($entity->getVideosYoutube());
        //ladybug_dump();
        //set($key, $value)
        //get($key)
        // $tag1 = new VideoYoutube();
        // $tag1->setEnlace('');
        // $entity->getVideosYoutube()->add($tag1);
        // $tag1 = new VideoYoutube();
        // $tag1->setEnlace('');
        // $entity->getVideosYoutube()->add($tag1);
        // $tag2 = new ListaYoutube();
        // $tag2->setEnlace(' ');
        // $entity->getListasYoutube()->add($tag2);
        $securityContext = $this->get('security.context');
        if (false === $securityContext->isGranted('EDIT', $entity)){  // verifica el acceso para edición
            if(!$securityContext->isGranted('ROLE_ADMIN') and !$securityContext->isGranted('ROLE_EDITOR'))
                throw new AccessDeniedException('No tienes permiso para editar este artículo');
        }



        // $tag1 = new VideoYoutube();
        // $tag1->setEnlace('');
        // $entity->getVideosYoutube()->add($tag1);

        // $tag2 = new Map();
        // $tag2->setLat('');
        // $tag2->setLang('');
        // $entity->getMaps()->add($tag2);

        // $tag3 = new ListaYoutube();
        // $tag3->setEnlace('');
        // $entity->getListasYoutube()->add($tag3);


        //$em->persist($entity);
        //$em->flush();

        //$editForm = $this->createForm(new ArticuloType(), $entity);
        $editForm = $this->createForm($this->get('form.type.articulo'), $entity);
        $deleteForm = $this->createDeleteForm($id);









        //$request = $this->getRequest();
        //$editId = $this->getRequest()->get('editId');
        //if (!preg_match('/^\d+$/', $editId)){
            //$editId = sprintf('%09d', mt_rand(0, 1999999999));
            if ($entity->getId()){
                $this->get('punk_ave.file_uploader')->syncFiles(
                    array(
                      'from_folder' => 'attachments/' . $entity->getId(), 
                      'to_folder' => 'tmp/attachments/' . $entity->getId(),
                      'create_to_folder' => true
                    )
                );
            }
        //}
        $existingFiles = $this->get('punk_ave.file_uploader')->getFiles(array('folder' => 'tmp/attachments/' . $entity->getId()));








        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            //'editId' => $editId,
            'existingFiles' => $existingFiles,
        );
    }


    /**
     * Finds and displays a Articulo entity.
     *
     * @Route("/{id}/{slug}/ver", name="_articulo_show")
     * @Route("/pl/{id}", name="_articulo_show_permanent")
     * @Template()
     */
    public function showAction($id,$slug="permanent"){

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FiterDefaultBundle:Articulo')->find($id);
        
        $entity->incrementaVisitas();
        $em->persist($entity);
        $em->flush();
        if (!$entity) throw $this->createNotFoundException('Unable to find Articulo entity.');
        $deleteForm = $this->createDeleteForm($id);
        $polls = array($entity->getPoll());


        $fileUploader = $this->get('punk_ave.file_uploader');
        $fileUploader->syncFiles(
            array('from_folder' => '/tmp/attachments/' . $entity->getId(),
            'to_folder' => '/attachments/' . $entity->getId(),
            'remove_from_folder' => true,
            'create_to_folder' => true)
        );


        $files = $fileUploader->getFiles(array('folder' => 'attachments/' . $entity->getId()));
        //ladybug_dump($files);
        //$repository = $em->getRepository('Gedmo\Translatable\Entity\Translation');
        //$translations = $repository->findTranslations($entity);
        //ladybug_dump($entity);
        //ladybug_dump($translations);
        //$entity = $em->getRepository('FiterDefaultBundle:Articulo')->findOneByIdAndLocale($id, $this->getRequest()->getLocale());
        //ladybug_dump($entity);


        $thread_id = "type_$id";
        $thread = $this->container->get('fos_comment.manager.thread')->findThreadById($thread_id);
        if (null === $thread) {
            $thread = $this->container->get('fos_comment.manager.thread')->createThread();
            $thread->setId($thread_id);
            //$thread->setPermalink($request->getUri());
            $thread->setPermalink("/art/pl/$id");

            // Add the thread
            $this->container->get('fos_comment.manager.thread')->saveThread($thread);
        }
        $comments = $this->container->get('fos_comment.manager.comment')->findCommentTreeByThread($thread);
        //ladybug_dump($thread);
        //ladybug_dump($comments);


        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'entities'      => $polls,
            'files'=> $files,
            'comments' => $comments,
            'thread' => $thread,
        );
    }

    /**
     *
     * @Route("/upload", name="upload")
     * @Template()
     */
    public function uploadAction(){
        $editId = $this->getRequest()->get('editId');
        if (!preg_match('/^\d+$/', $editId)){
            throw new Exception("Bad edit id");
        }
        $this->get('punk_ave.file_uploader')->handleFileUpload(array('folder' => 'tmp/attachments/' . $editId));
    }


    /**
     * Edits an existing Articulo entity.
     * @Route("/{id}/{slug}/actualizar", name="articulo_update")
     * @Method("POST")
     * @Template("FiterDefaultBundle:Articulo:edit.html.twig")
     */
    public function updateAction(Request $request, $id, $slug){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FiterDefaultBundle:Articulo')->find($id);
        if (!$entity) throw $this->createNotFoundException('Unable to find Articulo entity.');
        $originalTags = array();

        //ladybug_dump($entity->getVideosYoutube());
        foreach ($entity->getVideosYoutube() as $videoYoutube) {
            $originalTags[] = $videoYoutube;
        }
        $deleteForm = $this->createDeleteForm($id);
        //$editForm = $this->createForm(new ArticuloType(), $entity);
        $editForm = $this->createForm($this->get('form.type.articulo'), $entity);
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
                //$videoYoutube->setTask(null);
                $em->persist($videoYoutube);
                // if you wanted to delete the Tag entirely, you can also do that
                //$em->remove($videoYoutube);
            }
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('articulo_show', array('id' => $id,'slug' => $slug )));
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
     * @Route("/{id}/eliminar", name="articulo_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id){
        $form = $this->createDeleteForm($id);
        $form->bind($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FiterDefaultBundle:Articulo')->find($id);
            if (!$entity) throw $this->createNotFoundException('Unable to find Articulo entity.');
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

    private function createDeleteForm($id){
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

























    /**
     * Lists all Articulo entities by categoria.
     *
     * @Route("/like/usuario/{nombre}.{_format}", name="_articulolikeusuario", requirements={"_format" = "html|rss"} ,defaults={"_format" = "html" } ) 
     * @Template()
     */
    public function indexLikeUsuarioAction($nombre,$layout=true){
        $em = $this->getDoctrine()->getManager();
        
        $usuario = new Usuario();
        $usuario = $em->getRepository('FiterDefaultBundle:Usuario')->findById($nombre);
            
        $paginador = $this->get('ideup.simple_paginator');
        $paginador->setItemsPerPage(10);
        $paginador->setMaxPagerItems(10);
        
        $entities = 
        $paginador->paginate(
            $em->getRepository('FiterDefaultBundle:ArticuloLike')->findAllArticuloLikesUsuario($nombre)
        )->getResult();
        
        //if (!$entities) { throw $this->createNotFoundException('No se ha encontrado ningun resultado'); }
        $formato = $this->get('request')->getRequestFormat();
        if($layout)
           return $this->render('FiterDefaultBundle:Articulo:indexLikeUsuario.'.$formato.'.twig', array(
               'entities' => $entities,
               'nombre' => $nombre,
               'paginador' => $paginador
           ));
        else

            ladybug_dump($entities);
            return $this->render('FiterDefaultBundle:Articulo:indexLikeUsuarioSinLayout.'.$formato.'.twig', array(
                'entities' => $entities,
                'nombre' => $nombre,
                'paginador' => $paginador
            ));
    }
}











