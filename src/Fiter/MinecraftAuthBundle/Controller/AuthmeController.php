<?php

namespace Fiter\MinecraftAuthBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Fiter\MinecraftAuthBundle\Entity\Authme;
use Fiter\MinecraftAuthBundle\Form\AuthmeType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Authme controller.
 *
 * @Route("/minecraft/users")
 */
class AuthmeController extends Controller{

    /**
     * Dowload and save skin for an Authme entity.
     * @Route("/{id}/skin/avatar/{{t}}", name="authme_skin"  )
     * @Template()
     */
    public function skinAction($id,$t ){
        $em = $this->getDoctrine()->getManager('minecraft');
        $entity = $em->getRepository('FiterMinecraftAuthBundle:Authme')->find($id);
        if (!$entity) throw $this->createNotFoundException('Unable to find Authme entity.');        
        
        $size = 53;
        $user = $entity->getUsername();
        $avatar = $t;
        $av=null;
        $im=null;
        $skin=null;

        switch ($entity->getSkin()) {
            case 0:
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'http://s3.amazonaws.com/MinecraftSkins/'.$user.'.png');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                $output = curl_exec($ch);
                $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
                $entity->setSkin(1);
                if($status!='200') {
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'http://s3.amazonaws.com/MinecraftSkins/'.ucfirst($user).'.png');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                    $output = curl_exec($ch);
                    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);
                    $entity->setSkin(1);
                }
                if($status!='200') {
                    if($avatar){
                        // Default Avatar: http://www.minecraft.net/skin/char.png
                        $output = 'R0lGODlhMAAQAPUuALV7Z6p9ZkUiDkEhDIpMPSgcC2pAMFI9ibSEbZxpTP///7uJciodDTMkEYNVO7eCcpZfQJBeQ5xjRkIdCsaWgL2OdL';
                        $output .= '6IbL2OcqJqRyweDj8qFXpOMy8fDyQYCC8gDUIqEiYaCraJbL2Lco9ePoBTNG1DKpxyXK2AbbN7Yqx2WjQlEoFTOW9FLCseDQAAAAAAAAA';
                        $output .= 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH/C1hNUCBEYXRhWE1QRD94cDIzRThDRkQwQzcyIiB4';
                        $output .= 'bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOkU2RTVBQzAwMDFwYWNrZXQgZW5kPSJyIj8+ACH5BAUAAC4ALAAAAAAwABAAQAZkQJdwSCwaj';
                        $output .= '8ik0uVpcQodUIuxrFqv2OwRoTgAFgdFQEsum8/ocit0oYgqKVVaG4EMCATBaDXv+/+AgYKDVS2GDR8aGQWESAEIAScmCwkJjUcSKA8GBh';
                        $output .= 'YYJJdGLCUDEwICDhuEQQA7';
                    }else{
                        $output ='iVBORw0KGgoAAAANSUhEUgAAAEAAAAAgCAMAAACVQ462AAAABGdBTUEAALGPC/xhBQAAAwBQTFRFAAAAHxALIxcJJBgIJBgKJhgLJhoKJxsLJhoMKBsKKBsLKBoNKBwLKRwMKh0NKx4NKx4OLR0OLB4OLx8PLB4RLyANLSAQLyIRMiMQMyQRNCUSOigUPyoVKCgoPz8/JiFbMChyAFtbAGBgAGhoAH9/Qh0KQSEMRSIOQioSUigmUTElYkMvbUMqb0UsakAwdUcvdEgvek4za2trOjGJUj2JRjqlVknMAJmZAJ6eAKioAK+vAMzMikw9gFM0hFIxhlM0gVM5g1U7h1U7h1g6ilk7iFo5j14+kF5Dll9All9BmmNEnGNFnGNGmmRKnGdIn2hJnGlMnWpPlm9bnHJcompHrHZaqn1ms3titXtnrYBttIRttolsvohst4Jyu4lyvYtyvY5yvY50xpaA////AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAPSUN6AAAAQB0Uk5T////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////AFP3ByUAAAAYdEVYdFNvZnR3YXJlAFBhaW50Lk5FVCB2My4zNqnn4iUAAAKjSURBVEhLpZSLVtNAEIYLpSlLSUITLCBaGhNBQRM01M2mSCoXNUURIkZFxQvv/wz6724Wij2HCM7J6UyS/b+dmZ208rsww6jiqo4FhannZb5yDqjaNgDVwE/8JAmCMqF6fwGwbU0CKjD/+oAq9jcM27gxAFpNQxU3Bwi9Ajy8fgmGZuvaGAcIuwFA12CGce1jJESr6/Ot1i3Tnq5qptFqzet1jRA1F2XHWQFAs3RzwTTNhQd3rOkFU7c0DijmohRg1TR9ZmpCN7/8+PX954fb+sTUjK7VLKOYi1IAaTQtUrfm8pP88/vTw8M5q06sZoOouSgHEDI5vrO/eHK28el04yxf3N8ZnyQooZiLfwA0arNb6d6bj998/+vx8710a7bW4E2Uc1EKsEhz7WiQBK9eL29urrzsB8ngaK1JLDUXpYAkGSQH6e7640fL91dWXjxZ33138PZggA+Sz0WQlAL4gmewuzC1uCenqXevMPWc9XrMX/VXh6Hicx4ByHEeAfRg/wtgSMAvz+CKEkYAnc5SpwuD4z70PM+hUf+4348ixF7EGItjxmQcCx/Dzv/SOkuXAF3PdT3GIujjGLELNYwxhF7M4oi//wsgdlYZdMXCmEUUSsSu0OOBACMoBTiu62BdRPEjYxozXFyIpK7IAE0IYa7jOBRqGlOK0BFq3Kdpup3DthFwP9QDlBCGKEECoHEBEDLAXHAQMQnI8jwFYRQw3AMOQAJoOADoAVcDAh0HZAKQZUMZdC43kdeqAPwUBEsC+M4cIEq5KEEBCl90mR8CVR3nxwCdBBS9OAe020UGnXb7KcxzPY9SXoEEIBZtgE7UDgBKyLMhgBS2YdzjMJb4XHRDAPiQhSGjNOxKQIZTgC8BiMECgarxprjjO0OXiV4MAf4A/x0nbcyiS5EAAAAASUVORK5CYII='; 
                    }
                    $output = base64_decode($output);
                    $entity->setSkin(2);
                }else{
                    file_put_contents("mcskin/img/".$user.".png", $output);
                }
                $em->persist($entity);
                $em->flush();
                $skin = $output;
                $im = imagecreatefromstring($skin);
                break;
            case 1: $im = imagecreatefrompng("mcskin/img/".$user.".png"); break;
            case 2: $im = imagecreatefrompng("mcskin/char.png"); break;
        }
        if ($im !== false) {             
            if(!$avatar) imagepng($im);    
            else{
                $av = imagecreatetruecolor($size,$size);
                imagecopyresized($av,$im,0,0,8,8,$size,$size,8,8);    // Face
                imagecopyresized($av,$im,0,0,40,8,$size,$size,8,8);   // Accessories
                imagepng($av); 
                imagedestroy($av);
            }
            imagedestroy($im);
        }
        $headers = array(
            'Content-Type'     => 'image/png',
            'Content-Disposition' => 'inline; filename="image.png"'
        );
        if (!$avatar) return new Response($av, 200, $headers);
        else return new Response($skin, 200);
    }

    /**
     * Lists all Authme entities.
     * @Route("/", name="authme")
     * @Template()
     */
    public function indexAction(){
        $em = $this->getDoctrine()->getManager('minecraft');
        $paginador = $this->get('ideup.simple_paginator');
        $paginador->setItemsPerPage(10);
        $paginador->setMaxPagerItems(10);
        $entities = 
        $paginador->paginate(
            //$em->getRepository('FiterMinecraftAuthBundle:Authme')->findOrdenadosDQL()
            $em->createQuery('SELECT o FROM FiterMinecraftAuthBundle:Authme o ORDER BY o.lastlogin DESC')
        )->getResult();

        foreach ($entities as $entity){
            $entity->setLastLogin(date('Y-m-d H:i:s',$entity->getLastLogin()/ 1000)) ;
        }
        return array(
            'entities' => $entities,
            'paginador' => $paginador
        );
    }

    /**
     * Lists all online Authme entities.
     * @Route("/online", name="authme_online")
     * @Template()
     */
    public function onlineAction(){

        $host = $this->container->getParameter('ts3_host'); $port = 25566;
        $ts = fsockopen($host, $port, $errno, $errstr, 5);
        if ($ts){
            $out  = "QUERY\n";
            fwrite($ts, $out);
            $port = trim(fgets($ts));
            $numplayers = str_replace("PLAYERCOUNT ", "", trim( fgets($ts) )); 
            $maxplayers = str_replace("MAXPLAYERS ","",trim(fgets($ts)));           
            $playerlist = explode(", ",substr(trim(fgets($ts)), 12,-1));
        }
        //ladybug_dump($playerlist);
        $em = $this->getDoctrine()->getManager('minecraft');
        //$entities = $em->getRepository('FiterMinecraftAuthBundle:Authme')->findAll();
        //ladybug_dump($em->getRepository('FiterMinecraftAuthBundle:Authme'));
        $paginador = $this->get('ideup.simple_paginator');
        $paginador->setItemsPerPage(10);
        $paginador->setMaxPagerItems(10);
        $entities = 
        $paginador->paginate(
            //$em->getRepository('FiterMinecraftAuthBundle:Authme')->findOrdenadosDQL()
            $em->createQuery('SELECT o FROM FiterMinecraftAuthBundle:Authme o WHERE o.username in  (:opc) ORDER BY o.lastlogin DESC')->setParameter('opc', $playerlist)
        )->getResult();

        foreach ($entities as $entity){
            $entity->setLastLogin(date('Y-m-d H:i:s',$entity->getLastLogin()/ 1000)) ;
        }
        return array(
            'entities' => $entities,
            'paginador' => $paginador,
            'playerlist' => $playerlist
        );
    }

    /**
     * Obtener nacionalidades
     *
     * @Route("/getNacionalidades", name="getnacionalidades")
     * @Template()
     */
    public function getNacionalidadesAction(){
        $em = $this->getDoctrine()->getManager('minecraft');
        $entities = $em->getRepository('FiterMinecraftAuthBundle:Authme')->findAll();
        foreach ($entities as $entity){
            if($entity->getCountryCode()==null){
                $geoip = $this->get('raindrop.geoip')->lookup($entity->getIp());
                if($geoip){
                    $entity->setCountryCode($geoip->getCountryCode());
                    $entity->setCountryCode3($geoip->getCountryCode3());
                    $entity->setCountryName($geoip->getCountryName());
                    try {$entity->setRegion($geoip->getRegion()); } catch(\Exception $e){ ladybug_dump('Caught exception: '.$e->getMessage());}
                    $entity->setCity(utf8_encode($geoip->getCity()));
                    $entity->setPostalCode($geoip->getPostalCode());
                    $entity->setLatitude($geoip->getLatitude());
                    $entity->setLongitude($geoip->getLongitude());
                    $entity->setAreaCode($geoip->getAreaCode());
                    $entity->setMetroCode($geoip->getMetroCode());
                    $entity->setContinentCode($geoip->getContinentCode());
                    
                    if($entity->getPremium()==0){
                        $premium = file_get_contents("http://www.minecraft.net/haspaid.jsp?user=".$entity->getUserName());
                        if($premium == "true") $premium = 1; else $premium=0;
                        $entity->setPremium(   $premium   );
                    }          
                    $em->persist($entity);
                    $em->flush();
                }
            }
        }
        return new RedirectResponse($this->generateUrl('authme'));
    }

    /**
     * Finds and displays a Authme entity.
     * @Route("/{id}/show", name="authme_show")
     * @Template()
     */
    public function showAction($id){
        $em = $this->getDoctrine()->getManager('minecraft');
        $entity = $em->getRepository('FiterMinecraftAuthBundle:Authme')->find($id);
        if (!$entity) throw $this->createNotFoundException('Unable to find Authme entity.');
        $deleteForm = $this->createDeleteForm($id);

        $save = true;
        $geoip = $this->get('raindrop.geoip')->lookup($entity->getIp());
        if($geoip){
            $entity->setCountryCode($geoip->getCountryCode());
            $entity->setCountryCode3($geoip->getCountryCode3());
            $entity->setCountryCode3($geoip->getCountryName());
            //ladybug_dump($geoip);
            //$entity->setRegion($geoip->getRegion());
            try {$entity->setRegion($geoip->getRegion()); } catch(\Exception $e){ 
                //ladybug_dump('Caught exception: '.$e->getMessage());
            }
            $entity->setCity(utf8_encode($geoip->getCity()));
            $entity->setPostalCode($geoip->getPostalCode());
            $entity->setLatitude($geoip->getLatitude());
            $entity->setLongitude($geoip->getLongitude());
            $entity->setAreaCode($geoip->getAreaCode());
            $entity->setMetroCode($geoip->getMetroCode());
            $entity->setContinentCode($geoip->getContinentCode());
            $save = true;
        }
        if($entity->getPremium()==0){
            $premium = file_get_contents("http://www.minecraft.net/haspaid.jsp?user=".$entity->getUserName());
            if($premium == "true") $premium = 1; else $premium=0;
            $entity->setPremium(   $premium   );
            $save = true;
        }
        if($save){
            $em->persist($entity);
            $em->flush();
        }
        //$fecha = date('jS F Y h:i:s A (T)', $entity->getLastLogin()/ 1000);
        //$fecha2 = date("Y-m-d\TH:i:sO", $entity->getLastLogin()/ 1000);
        $fecha = date('Y-m-d H:i:s',$entity->getLastLogin()/ 1000) ;
        $entity->setLastLogin(date('Y-m-d H:i:s',$entity->getLastLogin()/ 1000)) ;
        $accounts = $em->getRepository('FiterMinecraftAuthBundle:Authme')->findByIp($entity->getIp());
        foreach ($accounts as $key => $value) if($value->getId()==$entity->getId()) unset($accounts[$key]);
        return array(
            'entity'      => $entity,
            'accounts'      => $accounts,
            'delete_form' => $deleteForm->createView(),
        );
    }


    /**
     * Finds and displays a Authme entity.
     * @Route("/show/skin", name="authme_show_skin")
     * @Template()
     */
    public function showSkinAction(){


        $em = $this->getDoctrine()->getManager('minecraft');
        $paginador = $this->get('ideup.simple_paginator');
        $paginador->setItemsPerPage(1);
        $paginador->setMaxPagerItems(10);
        $entities = 
        $paginador->paginate(
            //$em->getRepository('FiterMinecraftAuthBundle:Authme')->findOrdenadosDQL()
            $em->createQuery('SELECT o FROM FiterMinecraftAuthBundle:Authme o WHERE o.skin=1 ORDER BY o.lastlogin DESC')
        )->getResult();

        foreach ($entities as $entity){
            $entity->setLastLogin(date('Y-m-d H:i:s',$entity->getLastLogin()/ 1000)) ;
            $fecha = date('Y-m-d H:i:s',$entity->getLastLogin()/ 1000) ;
            $entity->setLastLogin(date('Y-m-d H:i:s',$entity->getLastLogin()/ 1000)) ;
            $accounts = $em->getRepository('FiterMinecraftAuthBundle:Authme')->findByIp($entity->getIp());
            foreach ($accounts as $key => $value) if($value->getId()==$entity->getId()) unset($accounts[$key]);
        }
        return array(
            'entity'      => $entity,
            'accounts'      => $accounts,
            'paginador' => $paginador
        );
    }





    /**
     * Displays a form to create a new Authme entity.
     * @Route("/new", name="authme_new")
     * @Template()
     */
    public function newAction(){
        $entity = new Authme();
        $form   = $this->createForm(new AuthmeType(), $entity);
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMINo')) throw new AccessDeniedException('No tienes permiso para crear usuarios');
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Authme entity.
     * @Route("/create", name="authme_create")
     * @Method("POST")
     * @Template("FiterMinecraftAuthBundle:Authme:new.html.twig")
     */
    public function createAction(Request $request){       
        $entity  = new Authme();
        $form = $this->createForm(new AuthmeType(), $entity);
        $form->bind($request);
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMINo')) throw new AccessDeniedException('No tienes permiso para crear usuarios');
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager('minecraft');
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('authme_show', array('id' => $entity->getId())));
        }
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Authme entity.
     * @Route("/{id}/edit", name="authme_edit")
     * @Template()
     */
    public function editAction($id){
        $em = $this->getDoctrine()->getManager('minecraft');
        $entity = $em->getRepository('FiterMinecraftAuthBundle:Authme')->find($id);
        if (!$entity) throw $this->createNotFoundException('Unable to find Authme entity.');
        $editForm = $this->createForm(new AuthmeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMINo')) throw new AccessDeniedException('No tienes permiso para editar usuarios');

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Authme entity.
     * @Route("/{id}/update", name="authme_update")
     * @Method("POST")
     * @Template("FiterMinecraftAuthBundle:Authme:edit.html.twig")
     */
    public function updateAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager('minecraft');
        $entity = $em->getRepository('FiterMinecraftAuthBundle:Authme')->find($id);
        if (!$entity) throw $this->createNotFoundException('Unable to find Authme entity.');
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new AuthmeType(), $entity);
        $editForm->bind($request);
        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('authme_edit', array('id' => $id)));
        }
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMINo')) throw new AccessDeniedException('No tienes permiso para modificar usuarios');

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Authme entity.
     * @Route("/{id}/delete", name="authme_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id){
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMINo')) throw new AccessDeniedException('No tienes permiso para eliminar usuarios');
        $form = $this->createDeleteForm($id);
        $form->bind($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager('minecraft');
            $entity = $em->getRepository('FiterMinecraftAuthBundle:Authme')->find($id);
            if (!$entity) throw $this->createNotFoundException('Unable to find Authme entity.');
            $em->remove($entity);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('authme'));
    }
    private function createDeleteForm($id){
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
