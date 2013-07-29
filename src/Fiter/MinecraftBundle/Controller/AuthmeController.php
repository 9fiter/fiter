<?php

namespace Fiter\MinecraftBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Fiter\MinecraftBundle\Entity\Authme;
use Fiter\MinecraftBundle\Form\AuthmeType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use \Symfony\Component\Yaml\Parser;

/**
 * Authme controller.
 *
 * @Route("/minecraft/users")
 */
class AuthmeController extends Controller{


    /**
     * login
     * @Route("/login", name="authme_login")
     * @Template()
     */
    public function loginAction(Request $request){
        return array();
    }

    /**
     * checkpassword
     * @Route("/checkpassword", name="authme_checkpassword")
     * @Template()
     */
    public function checkPasswordAction(Request $request){
        $post = $this->get('request')->request->all();
        $user = $post['user'];
        $pass = $post['pass'];
        $em = $this->getDoctrine()->getManager('minecraft');
        $entity = $em->getRepository('FiterMinecraftBundle:Authme')->findOneByUsername($user);
        $res = false;
        if($entity){
            $sha_info = explode("$",$entity->getPassword());
            if( $sha_info[1] === "SHA" ) {
                $salt = $sha_info[2];
                $sha256_pass = hash('sha256', $pass);
                $sha256_pass .= $sha_info[2];;
                if( strcasecmp(trim($sha_info[3]),hash('sha256', $sha256_pass) ) == 0 ) $res = true;
            }
        }
        if($res){
            $session  = $this->get("session");
            $session->set("MinecraftUser", $user);
            return new RedirectResponse($this->generateUrl('authme'));
        }else return new RedirectResponse($this->generateUrl('authme_login'));
    }

    /**
     * main
     * @Route("/main", name="authme_main")
     * @Template()
     */
    public function mainAction(){
        return array();
    }

    /**
     * show banned users
     * @Route("/banned/ips", name="authme_banned_ips")
     * @Template()
     */
    public function bannedIpsAction(){
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMIN')) throw new AccessDeniedException("No tienes permiso para ver las IP's baneadas");

        $mc_folder = $this->container->getParameter('minecraft_folder');
        $ruta = $mc_folder."banned-ips.txt";

        if(file_exists($ruta)){
            $archivo=file($ruta);//ladybug_dump($archivo);
            $bans = [];
            foreach ($archivo as $key => $value) {
                if($key>2){
                    $value= explode("|",trim($value));
                    array_push($bans, $value);
                }
            }//ladybug_dump($bans);
        }else{
            throw $this->createNotFoundException('No se ha encontrado el archivo: banned-ips.txt');
        }  
        return array(
            'bans' => $bans
        );
    }


    /**
     * show banned users
     * @Route("/banned", name="authme_banned")
     * @Template()
     */
    public function bannedAction(){
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMIN')) throw new AccessDeniedException("No tienes permiso para ver los usuarios baneados");

        $mc_folder = $this->container->getParameter('minecraft_folder');
        $ruta = $mc_folder."banned-players.txt";

        if(file_exists($ruta)){
            $archivo=file($ruta);//ladybug_dump($archivo);
            $bans = [];
            foreach ($archivo as $key => $value) {
                if($key>2){
                    $value= explode("|",trim($value));
                    array_push($bans, $value);
                }
            }//ladybug_dump($bans);
        }else throw $this->createNotFoundException('No se ha encontrado el archivo: banned-players.txt');
        
        return array(
            'bans' => $bans
        );

    }

    /**
     * show more info about users
     * @Route("/info/{username}", name="authme_info")
     * @Template()
     */
    public function infoAction($username){
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMIN')) throw new AccessDeniedException("No tienes permiso para ver los usuarios baneados");

        $mc_folder = $this->container->getParameter('minecraft_folder');
        $ruta = $mc_folder."plugins/Essentials/userdata/".$username.".yml";
        if(file_exists($ruta)){
            $archivo=file($ruta);//ladybug_dump($archivo);
            //$yml_arr =  yaml_parse_file($archivo); ladybug_dump($yml_arr);
            $info = [];
            foreach ($archivo as $key => $value) {
                array_push($info, $value);
            }//ladybug_dump($info);
        }else throw $this->createNotFoundException('No se ha encontrado el archivo: '.$username.'.yml');
        return array(
            'username' => $username,
            'info' => $info,

        );
    }

    /**
     * Pardon ip
     * @Route("/pardon/ip/{ip}", name="authme_pardon_ip")
     * @Template()
     */
    public function pardonIpAction($ip){
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMIN')) throw new AccessDeniedException("No tienes permiso para perdonar IP's");

        $websend = $this->get('fiter.websend');
        $pass = $this->container->getParameter('minecraft_websend_pass');
        $websend->connect($pass);
        $websend->doCommandAsConsole("pardon-ip ".$ip);
        return array(
            'ip' => $ip
        );
    }

    /**
     * Pardon user
     * @Route("/pardon/{username}", name="authme_pardon")
     * @Template()
     */
    public function pardonAction($username){
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMIN')) throw new AccessDeniedException('No tienes permiso para perdonar usuarios');

        $websend = $this->get('fiter.websend');
        $pass = $this->container->getParameter('minecraft_websend_pass');
        $websend->connect($pass);
        $websend->doCommandAsConsole("pardon ".$username);
        return array(
            'username' => $username
        );
    }

    /**
     * Ban ip
     * @Route("/banIp/{ip}", name="authme_banIp")
     * @Template()
     */
    public function banIpAction($ip){
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMIN')) throw new AccessDeniedException("No tienes permiso para bannear IP's.");

        $websend = $this->get('fiter.websend');
        $pass = $this->container->getParameter('minecraft_websend_pass');
        $websend->connect($pass);
        $websend->doCommandAsConsole("w esemoi hola esemoi");
        //$websend->doCommandAsPlayer('!dejamejugar.com','udrul');
        //$websend->doCommandAsConsole('say dejamejugar.com');
        //$websend->doCommandAsConsole('ban esemoi testing bans');
        //$websend->doCommandAsConsole('pardon esemoi');
        //ladybug_dump($websend);
        return array(
            'ip' => $ip
        );
    }

    /**
     * Ban user
     * @Route("/ban/{username}", name="authme_ban")
     * @Template("FiterMinecraftBundle:Authme:ban.html.twig")
     */
    public function banAction($username){
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMIN')) throw new AccessDeniedException("No tienes permiso para bannear usuarios.");

        $websend = $this->get('fiter.websend');
        $pass = $this->container->getParameter('minecraft_websend_pass');
        $websend->connect($pass);
        $websend->doCommandAsConsole('ban esemoi');
        return array(
            'username' => $username
        );
    }

    /**
     * Search Authme entities.
     * @Route("/search", name="authme_search")
     * @Template("FiterMinecraftBundle:Authme:index.html.twig")
     */
    public function searchAction(Request $request){
        $em = $this->getDoctrine()->getManager('minecraft');
        $username = $request->query->get('q');
        $paginador = $this->get('ideup.simple_paginator');
        $paginador->setItemsPerPage(10);
        $paginador->setMaxPagerItems(10);
        $entities = 
        $paginador->paginate(
            //$em->getRepository('FiterMinecraftBundle:Authme')->findByUsername($username)
            $em->createQuery('SELECT o FROM FiterMinecraftBundle:Authme o WHERE o.username LIKE  :opc')->setParameter('opc', "%".$username."%")
        )->getResult();

        foreach ($entities as $entity){
            $entity->setLastLogin(date('Y-m-d H:i:s',$entity->getLastLogin()/ 1000)) ;
        }
        return array(
            'entities' => $entities,
            'paginador' => $paginador,
        );
    }


    /**
     * Search Authme entities by IP
     * @Route("/search/ip", name="authme_search_ip")
     * @Template("FiterMinecraftBundle:Authme:index.html.twig")
     */
    public function searchIpAction(Request $request){
        $em = $this->getDoctrine()->getManager('minecraft');
        $ip = $request->query->get('q');
        $paginador = $this->get('ideup.simple_paginator');
        $paginador->setItemsPerPage(10);
        $paginador->setMaxPagerItems(10);
        $entities = 
        $paginador->paginate(
            $em->getRepository('FiterMinecraftBundle:Authme')->findByIp($ip)
        )->getResult();

        foreach ($entities as $entity){
            $entity->setLastLogin(date('Y-m-d H:i:s',$entity->getLastLogin()/ 1000)) ;
        }
        return array(
            'entities' => $entities,
            'paginador' => $paginador,
        );
    }


    /**
     * Dowload and save skin for an Authme entity.
     * @Route("/{id}/skin/avatar/{t}.png", name="authme_skin"  )
     * @Template()
     */
    public function skinAction($id,$t ){
        $em = $this->getDoctrine()->getManager('minecraft');
        $entity = $em->getRepository('FiterMinecraftBundle:Authme')->find($id);
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
            //$em->getRepository('FiterMinecraftBundle:Authme')->findOrdenadosDQL()
            $em->createQuery('SELECT o FROM FiterMinecraftBundle:Authme o ORDER BY o.lastlogin DESC')
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

        $host = $this->container->getParameter('minecraft_server'); $port = 25566;
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
        //$entities = $em->getRepository('FiterMinecraftBundle:Authme')->findAll();
        //ladybug_dump($em->getRepository('FiterMinecraftBundle:Authme'));
        $paginador = $this->get('ideup.simple_paginator');
        $paginador->setItemsPerPage(10);
        $paginador->setMaxPagerItems(10);
        $entities = 
        $paginador->paginate(
            //$em->getRepository('FiterMinecraftBundle:Authme')->findOrdenadosDQL()
            $em->createQuery('SELECT o FROM FiterMinecraftBundle:Authme o WHERE o.username in  (:opc) ORDER BY o.lastlogin DESC')->setParameter('opc', $playerlist)
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
     * @Route("/getNacionalidades", name="authme_getnacionalidades")
     * @Template()
     */
    public function getNacionalidadesAction(){
        $em = $this->getDoctrine()->getManager('minecraft');
        $entities = $em->getRepository('FiterMinecraftBundle:Authme')->findAll();
        foreach ($entities as $entity){
            if($entity->getCountryName()==null){
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
        $entity = $em->getRepository('FiterMinecraftBundle:Authme')->find($id);
        if (!$entity) throw $this->createNotFoundException('Unable to find Authme entity.');
        $deleteForm = $this->createDeleteForm($id);

        $save = true;
        $geoip = $this->get('raindrop.geoip')->lookup($entity->getIp());
        if($geoip){
            $entity->setCountryCode($geoip->getCountryCode());
            $entity->setCountryCode3($geoip->getCountryCode3());
            $entity->setCountryName($geoip->getCountryName());
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
        $accounts = $em->getRepository('FiterMinecraftBundle:Authme')->findByIp($entity->getIp());
        foreach ($accounts as $key => $value) if($value->getId()==$entity->getId()) unset($accounts[$key]);
        return array(
            'entity'      => $entity,
            'accounts'      => $accounts,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Finds and displays a Authme entity by username.
     * @Route("/show/name/{username}", name="authme_show_by_username")
     * @Template("FiterMinecraftBundle:Authme:show.html.twig")
     */
    public function showByUsernameAction($username){
        $em = $this->getDoctrine()->getManager('minecraft');
        $entity = $em->getRepository('FiterMinecraftBundle:Authme')->findOneByUsername($username);
        if (!$entity) throw $this->createNotFoundException('Unable to find Authme entity.');
        $deleteForm = $this->createDeleteForm($entity->getId());

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
        $accounts = $em->getRepository('FiterMinecraftBundle:Authme')->findByIp($entity->getIp());
        foreach ($accounts as $key => $value) if($value->getId()==$entity->getId()) unset($accounts[$key]);
        return array(
            'entity'      => $entity,
            'accounts'      => $accounts,
            'delete_form' => $deleteForm->createView(),
        );
    }




    /**
     * Finds and displays a Authme entity by username.
     * @Route("/show/ip/{ip}", name="authme_show_by_ip")
     * @Template("FiterMinecraftBundle:Authme:show.html.twig")
     */
    public function showByIpAction($ip){
        $em = $this->getDoctrine()->getManager('minecraft');
        $entity = $em->getRepository('FiterMinecraftBundle:Authme')->findOneByIp($ip);
        if (!$entity) throw $this->createNotFoundException('Unable to find Authme entity.');
        $deleteForm = $this->createDeleteForm($entity->getId());

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
        $accounts = $em->getRepository('FiterMinecraftBundle:Authme')->findByIp($entity->getIp());
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
            //$em->getRepository('FiterMinecraftBundle:Authme')->findAll()
            $em->createQuery('SELECT o FROM FiterMinecraftBundle:Authme o WHERE o.skin=1 ORDER BY o.lastlogin DESC')
        )->getResult();

        foreach ($entities as $entity){
            $entity->setLastLogin(date('Y-m-d H:i:s',$entity->getLastLogin()/ 1000)) ;
            $fecha = date('Y-m-d H:i:s',$entity->getLastLogin()/ 1000) ;
            $entity->setLastLogin(date('Y-m-d H:i:s',$entity->getLastLogin()/ 1000)) ;
            $accounts = $em->getRepository('FiterMinecraftBundle:Authme')->findByIp($entity->getIp());
            foreach ($accounts as $key => $value) if($value->getId()==$entity->getId()) unset($accounts[$key]);
        }
        //ladybug_dump($entities);
        return array(
            'entity'      => $entities[0],
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
     * @Template("FiterMinecraftBundle:Authme:new.html.twig")
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
        $entity = $em->getRepository('FiterMinecraftBundle:Authme')->find($id);
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
     * @Template("FiterMinecraftBundle:Authme:edit.html.twig")
     */
    public function updateAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager('minecraft');
        $entity = $em->getRepository('FiterMinecraftBundle:Authme')->find($id);
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
            $entity = $em->getRepository('FiterMinecraftBundle:Authme')->find($id);
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
