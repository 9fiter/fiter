<?php

namespace Fiter\TeamspeakBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\RedirectResponse;


use Fiter\TeamspeakBundle\Util\Util;

// use Lifo\RemoteControl\RemoteControl;
// use Lifo\RemoteControl\Type\NetworkDevice;


class DefaultController extends Controller{

    /**
     * @Route("/admin/teamspeak/", name="teamspeak" )
     * @Template()
     */
    public function indexAction(){
        return array();
    }
    /**
     * Teamspeak banclientform
     * @Route("/admin/teamspeak/banclientForm/{clid}/{nickname}/", name="teamspeak_banclientform")  
     * @Template()    
     */
    public function banclientformAction($clid,$nickname){
        return array(
        	'clid' => $clid,
        	'nickname' => $nickname,
        );
    }
    /**
     * Teamspeak clientpokeform
     * @Route("/admin/teamspeak/clientpokeform/{clid}/{nickname}/", name="teamspeak_clientpokeform")  
     * @Template()    
     */
    public function clientpokeformAction($clid,$nickname){
        return array(
        	'clid' => $clid,
        	'nickname' => $nickname,
        );
    }
    /**
     * Teamspeak clientpokeform_content
     * @Route("/admin/teamspeak/clientpokeform_content", name="teamspeak_clientpokeform_content")  
     * @Template()    
     */
    public function clientpokeform_contentAction(Request $request){
    	$clid=$request->request->get('clid');
    	$nickname=$request->request->get('nickname');
        return array(
        	'clid' => $clid,
        	'nickname' => $nickname,
        );
    }
    /**
     * Teamspeak banclientform_content
     * @Route("/admin/teamspeak/banclientform_content", name="teamspeak_banclientform_content")  
     * @Template()    
     */
    public function banclientform_contentAction(Request $request){
    	$clid=$request->request->get('clid');
    	$nickname=$request->request->get('nickname');
        return array(
        	'clid' => $clid,
        	'nickname' => $nickname,
        );
    }

























    /**
     * Teamspeak tokenadd
     * @Route("/teamspeak/connect", name="teamspeak_connect" )    
     * @Template() 
     */
    public function connectAction(){
        $user = $this->container->getParameter('ts3_user');
        $pass = $this->container->getParameter('ts3_pass');
        $host = $this->container->getParameter('ts3_host');
        $port = $this->container->getParameter('ts3_port');

        $usr= $this->get('security.context')->getToken()->getUser();
        $usuario = $usr->getUsername();
        $usuarioId= $usr->getId();

        $element=false;
        $res="";
        $fp = fsockopen($host, $port, $errno, $errstr, 5);
        if (!$fp) {
            $res = "$errstr ($errno)<br />\n";
        } else {
            $out  = "login client_login_name=$user client_login_password=$pass\n";
            $out .= "use 1\n";
            $out .= "tokenadd tokentype=0 tokenid1=22 tokenid2=0 tokendescription=automaticallyscreatedstokensfor$usuario tokencustomset=ident=forum_user\svalue=$usuario|ident=forum_id\svalue=$usuarioId\n";
            fwrite($fp, $out);
            $res = fgets($fp); //TS3
            if (strpos($res,'TS3') !== false) {
                $res = fgets($fp); //Welcome to the TeamSpeak 3 ServerQuery interface
                if (strpos($res,'Welcome to the TeamSpeak 3 ServerQuery interface') !== false) {
                    $res = fgets($fp); // login client
                    //ladybug_dump($res);
                    if (strpos($res,'error id=0 msg=ok') !== false) {
                        $res = fgets($fp); //use 1
                        //ladybug_dump($res);
                        if (strpos($res,'error id=0 msg=ok') !== false) {
                            $res = fgets($fp); //
                            //ladybug_dump($res);
                            if (strpos($res,'token=') !== false) {
                                $token = str_replace("token=","",trim($res));
                                //ladybug_dump("creado");
                                $link='ts3server://dejamejugar.com?nickname='.$usuario.'&addbookmark='.$usuario.'-dejamejugar.com&token='.$token;
                                //fclose($fp);
                                $element=true;
                                //return $this->redirect($link);
                                //ladybug_dump($link);
                            }
                        }
                    }
                }
            }
            fclose($fp);
            return array(
	            'element' => $element,
	            'link' => $link,
	            'token' => $token,
	            'e' => $res,
	        );
        }
    }






































    /**
     * Teamspeak channellist
     * @Route("/admin/teamspeak/channellist", name="teamspeak_channellist" ) 
     * @Template()    
     */
    public function channellistAction(){
        $user = $this->container->getParameter('ts3_user');
        $pass = $this->container->getParameter('ts3_pass');
        $host = $this->container->getParameter('ts3_host');
        $port = $this->container->getParameter('ts3_port');


		
        $ts=Util::teamspeak($host,$port);
        $login=Util::login($ts,$user,$pass);
        $use=Util::usee($ts,"1");
        $element=Util::channellist($ts);

        return array(
            'element' => $element
        );
    }
   	/**
     * Teamspeak clientlist
     * @Route("/admin/teamspeak/clientlist", name="teamspeak_clientlist" ) 
     * @Template()    
     */
    public function clientlistAction(){
        $user = $this->container->getParameter('ts3_user');
        $pass = $this->container->getParameter('ts3_pass');
        $host = $this->container->getParameter('ts3_host');
        $port = $this->container->getParameter('ts3_port');

        $ts=Util::teamspeak($host,$port);
        $login=Util::login($ts,$user,$pass);
        $use=Util::usee($ts,"1");
        $element=Util::clientlist($ts);

        return array(
            'element' => $element
        );
    }
    /**
     * Teamspeak tokenlist
     * @Route("/admin/teamspeak/tokenlist", name="teamspeak_tokenlist" ) 
     * @Template()    
     */
    public function tokenListAction(){
        $user = $this->container->getParameter('ts3_user');
        $pass = $this->container->getParameter('ts3_pass');
        $host = $this->container->getParameter('ts3_host');
        $port = $this->container->getParameter('ts3_port');

        $ts=Util::teamspeak($host,$port);
        $login=Util::login($ts,$user,$pass);
        $use=Util::usee($ts,"1");
        $element=Util::tokenlist($ts);

        return array(
            'element' => $element
        );
    }
    /**
     * Teamspeak tokendelete
     * @Route("/admin/teamspeak/tokendelete/{token}", name="teamspeak_tokendelete" ) 
     * @Template()    
     */
    public function tokenDeleteAction($token){
        $user = $this->container->getParameter('ts3_user');
        $pass = $this->container->getParameter('ts3_pass');
        $host = $this->container->getParameter('ts3_host');
        $port = $this->container->getParameter('ts3_port');

        $ts=Util::teamspeak($host,$port);
        $login=Util::login($ts,$user,$pass);
        $use=Util::usee($ts,"1");
        $element=Util::tokendelete($ts,$token);

        if($element['e']) return $this->redirect($this->generateUrl('teamspeak_tokenlist')); 
        return $element;                   
    }
	/**
     * Teamspeak clientdblist
     * @Route("/admin/teamspeak/clientdblist", name="teamspeak_clientdblist" ) 
     * @Template()    
     */
    public function clientdblistAction(){
        $user = $this->container->getParameter('ts3_user');
        $pass = $this->container->getParameter('ts3_pass');
        $host = $this->container->getParameter('ts3_host');
        $port = $this->container->getParameter('ts3_port');

        $usr= $this->get('security.context')->getToken()->getUser();
        $usuario = $usr->getUsername();
        $usuarioId= $usr->getId();
        
        $ts=Util::teamspeak($host,$port);
        $login=Util::login($ts,$user,$pass);
        $use=Util::usee($ts,"1");
        $element=Util::clientdblist($ts);

        return array(
            'element' => $element
        );
    }
    /**
     * Teamspeak servergrouplist
     * @Route("/admin/teamspeak/servergrouplist", name="teamspeak_servergrouplist" ) 
     * @Template()    
     */
    public function serverGroupListAction(){
        $user = $this->container->getParameter('ts3_user');
        $pass = $this->container->getParameter('ts3_pass');
        $host = $this->container->getParameter('ts3_host');
        $port = $this->container->getParameter('ts3_port');

        $ts=Util::teamspeak($host,$port);
        $login=Util::login($ts,$user,$pass);
        $use=Util::usee($ts,"1");
        $element=Util::servergrouplist($ts);

        return array(
            'element' => $element
        );
    }
    /**
     * Teamspeak view
     * @Route("/admin/teamspeak/view", name="teamspeak_view" ) 
     * @Template()    
     */
    public function viewAction(){
        $user = $this->container->getParameter('ts3_user');
        $pass = $this->container->getParameter('ts3_pass');
        $host = $this->container->getParameter('ts3_host');
        $port = $this->container->getParameter('ts3_port');

        $ts=Util::teamspeak($host,$port);
        $login=Util::login($ts,$user,$pass);
        $use=Util::usee($ts,"1");
        $element=Util::channellist($ts);
        $clients=Util::clientlist($ts);

     	//mezclar canales y clientes
     	foreach ($element as $key => $value) {
     		$element[$key]['clients']= array();
     		foreach ($clients as $key2 => $value2) {
     			if($element[$key]['cid']==$clients[$key2]['cid']){
     				array_push($element[$key]['clients'], $clients[$key2]);
     			}
     		}
     	}
        return array(
            'element' => $element
        );
    }
    /**
     * Teamspeak serverinfo
     * @Route("/admin/teamspeak/serverinfo", name="teamspeak_serverinfo" ) 
     * @Template()    
     */
    public function serverInfoAction(){
        $user = $this->container->getParameter('ts3_user');
        $pass = $this->container->getParameter('ts3_pass');
        $host = $this->container->getParameter('ts3_host');
        $port = $this->container->getParameter('ts3_port');

        $usr= $this->get('security.context')->getToken()->getUser();
        $usuario = $usr->getUsername();
        $usuarioId= $usr->getId();

        $ts=Util::teamspeak($host,$port);
        $login=Util::login($ts,$user,$pass);
        $use=Util::usee($ts,"1");
        $element=Util::serverinfo($ts);

        return array(
            'element' => $element
        );
    }
    /**
     * Teamspeak banclient
     * @Route("/admin/teamspeak/banclient", name="teamspeak_banclient" ) 
     * @Template()    
     */
    public function banclientAction(Request $request){

    	$clid=$request->request->get('clid');
    	$time=$request->request->get('time');
    	$banreason=$request->request->get('banreason');
    	if ($banreason=="") $banreason="Go\saway!";    	

        $user = $this->container->getParameter('ts3_user');
        $pass = $this->container->getParameter('ts3_pass');
        $host = $this->container->getParameter('ts3_host');
        $port = $this->container->getParameter('ts3_port');

        $ts=Util::teamspeak($host,$port);
        $login=Util::login($ts,$user,$pass);
        $use=Util::usee($ts,"1");
        $element=Util::banclient($ts,$clid,$time,$banreason);

        //if ($element['e']) return $this->redirect($this->generateUrl('teamspeak_clientlist')); 
        
        return array(
            'res' => $element
        );
    }
    /**
     * Teamspeak banlist
     * @Route("/admin/teamspeak/banlist/", name="teamspeak_banlist" ) 
     * @Template()    
     */
    public function banlistAction(){
        $user = $this->container->getParameter('ts3_user');
        $pass = $this->container->getParameter('ts3_pass');
        $host = $this->container->getParameter('ts3_host');
        $port = $this->container->getParameter('ts3_port');

        $usr= $this->get('security.context')->getToken()->getUser();
        $usuario = $usr->getUsername();
        $usuarioId= $usr->getId();

        $ts=Util::teamspeak($host,$port);
        $login=Util::login($ts,$user,$pass);
        $use=Util::usee($ts,"1");
        $element=Util::banlist($ts);

        return array(
            'element' => $element
        );
    }
    /**
     * Teamspeak bandelall
     * @Route("/admin/teamspeak/bandelall/", name="teamspeak_bandelall" ) 
     * @Template()    
     */
    public function bandelallAction(){
        $user = $this->container->getParameter('ts3_user');
        $pass = $this->container->getParameter('ts3_pass');
        $host = $this->container->getParameter('ts3_host');
        $port = $this->container->getParameter('ts3_port');

        $usr= $this->get('security.context')->getToken()->getUser();
        $usuario = $usr->getUsername();
        $usuarioId= $usr->getId();

        $ts=Util::teamspeak($host,$port);
        $login=Util::login($ts,$user,$pass);
        $use=Util::usee($ts,"1");
        $element=Util::bandelall($ts);

        if($element['e']) return $this->redirect($this->generateUrl('teamspeak_banlist')); 

        return array(
            'element' => $element
        );
    }
    /**
     * Teamspeak bandel
     * @Route("/admin/teamspeak/bandel/{banid}", name="teamspeak_bandel" ) 
     * @Template()    
     */
    public function bandelAction($banid){
        $user = $this->container->getParameter('ts3_user');
        $pass = $this->container->getParameter('ts3_pass');
        $host = $this->container->getParameter('ts3_host');
        $port = $this->container->getParameter('ts3_port');

		$ts=Util::teamspeak($host,$port);
        $login=Util::login($ts,$user,$pass);
        $use=Util::usee($ts,"1");
        $element=Util::bandel($ts,$banid);

        if($element['e']) return $this->redirect($this->generateUrl('teamspeak_banlist')); 

        return array(
            'res' => $res
        );
    }
	/**
     * Teamspeak clientinfo
     * @Route("/admin/teamspeak/clientinfo/{clid}", name="teamspeak_clientinfo" ) 
     * @Template()    
     */
    public function clientinfoAction($clid){
        $user = $this->container->getParameter('ts3_user');
        $pass = $this->container->getParameter('ts3_pass');
        $host = $this->container->getParameter('ts3_host');
        $port = $this->container->getParameter('ts3_port');

        $ts=Util::teamspeak($host,$port);
        $login=Util::login($ts,$user,$pass);
        $use=Util::usee($ts,"1");
        $element=Util::clientinfo($ts,$clid);

		return array(
            'element' => $element
        );
    }
    /**
     * Teamspeak gm
     * @Route("/admin/teamspeak/gm/{msg}", name="teamspeak_gm" ) 
     * @Template()    
     */
    public function gmAction($msg){
        $user = $this->container->getParameter('ts3_user');
        $pass = $this->container->getParameter('ts3_pass');
        $host = $this->container->getParameter('ts3_host');
        $port = $this->container->getParameter('ts3_port');

        $ts=Util::teamspeak($host,$port);
        $login=Util::login($ts,$user,$pass);
        $use=Util::usee($ts,"1");
        $element=Util::gm($ts,$msg);

        return array(
            'element' => $element
        );
    }
    /**
     * Teamspeak clientgetnamefromdbid
     * @Route("/admin/teamspeak/clientgetnamefromdbid/{cldbid}", name="teamspeak_clientgetnamefromdbid" ) 
     * @Template()    
     */
    public function clientgetnamefromdbidAction($cldbid){
        $user = $this->container->getParameter('ts3_user');
        $pass = $this->container->getParameter('ts3_pass');
        $host = $this->container->getParameter('ts3_host');
        $port = $this->container->getParameter('ts3_port');

        $usuarioId= $this->get('security.context')->getToken()->getUser()->getId();

        $ts=Util::teamspeak($host,$port);
        $login=Util::login($ts,$user,$pass);
        $use=Util::usee($ts,"1");
        $element=Util::clientgetnamefromdbid($ts,$usuarioId);

        return array(
            'element' => $element
        );
    }
    /**
     * Teamspeak myclientgetnamefromdbid
     * @Route("/teamspeak/myclientgetnamefromdbid/", name="teamspeak_myclientgetnamefromdbid" ) 
     * @Template()    
     */
    public function myclientgetnamefromdbidAction(){
        $user = $this->container->getParameter('ts3_user');
        $pass = $this->container->getParameter('ts3_pass');
        $host = $this->container->getParameter('ts3_host');
        $port = $this->container->getParameter('ts3_port');

        $usuarioId= $this->get('security.context')->getToken()->getUser()->getId();

        $ts=Util::teamspeak($host,$port);
        $login=Util::login($ts,$user,$pass);
        $use=Util::usee($ts,"1");
        $element=Util::clientgetnamefromdbid($ts,$usuarioId);

        return array(
            'element' => $element
        );
    }
    /**
     * Teamspeak sendtextmessage
     * @Route("/admin/teamspeak/sendtextmessage/{targetmode}/{target}/{msg}", name="teamspeak_sendtextmessage" , requirements={"targetmode" = "client|channel|server"}) 
     * @Template()    
     */
    public function sendtextmessageAction($targetmode,$target,$msg){

    	$msg = str_replace(" ", "\s", $msg);
        $user = $this->container->getParameter('ts3_user');
        $pass = $this->container->getParameter('ts3_pass');
        $host = $this->container->getParameter('ts3_host');
        $port = $this->container->getParameter('ts3_port');

        $usr= $this->get('security.context')->getToken()->getUser();
        $usuario = $usr->getUsername();
        $usuarioId= $usr->getId();

        switch ($targetmode) {
        	case 'client':
        		$targetmode =1;
        		break;
        	case 'channel':
        		$targetmode =2;
        		break;
        	case 'server':
        		$targetmode =3;
        		break;
        	default:
        		$targetmode =3;
        		break;
        }

        $ts=Util::teamspeak($host,$port);
        $login=Util::login($ts,$user,$pass);
        $use=Util::usee($ts,"1");
        $element=Util::sendtextmessage($ts,$targetmode,$target,$msg);

        return array(
            'element' => $element
        );
    }
    /**
     * Teamspeak clientupdate
     * @Route("/admin/teamspeak/clientupdate/{client_nickname}/", name="teamspeak_clientupdate") 
     * @Template()    
     */
    public function clientupdateAction($client_nickname){

        $user = $this->container->getParameter('ts3_user');
        $pass = $this->container->getParameter('ts3_pass');
        $host = $this->container->getParameter('ts3_host');
        $port = $this->container->getParameter('ts3_port');

        $usr= $this->get('security.context')->getToken()->getUser();
        $usuario = $usr->getUsername();
        $usuarioId= $usr->getId();

        $ts=Util::teamspeak($host,$port);
        $login=Util::login($ts,$user,$pass);
        $use=Util::usee($ts,"1");
        $element=Util::clientupdate($ts,$client_nickname);

        return $element;
    }
    /**
     * Teamspeak clientkick
     * @Route("/admin/teamspeak/clientkick/{reasonid}/{reasonmsg}/{clid}/", name="teamspeak_clientkick" , requirements={"targetmode" = "channel|server"}) 
     * @Template()    
     */
    public function clientkickAction($reasonid,$reasonmsg,$clid){
    	switch ($reasonid) {
        	case 'channel':
        		$reasonid =4;
        		break;
        	case 'server':
        		$reasonid =5;
        		break;
        	default:
        		$reasonid =4;
        		break;
        }
    	$reasonmsg = str_replace(" ", "\s", $reasonmsg);

        $user = $this->container->getParameter('ts3_user');
        $pass = $this->container->getParameter('ts3_pass');
        $host = $this->container->getParameter('ts3_host');
        $port = $this->container->getParameter('ts3_port');

        $ts=Util::teamspeak($host,$port);
        $login=Util::login($ts,$user,$pass);
        $use=Util::usee($ts,"1");
        $element=Util::clientkick($ts,$reasonid,$reasonmsg,$clid);

        return $element;
    }
    /**
     * Teamspeak clientpoke
     * @Route("/admin/teamspeak/clientpoke", name="teamspeak_clientpoke") 
     * @Template()    
     */
    public function clientpokeAction(Request $request){
    	$clid=$request->request->get('clid');
    	$msg=$request->request->get('msg');

    	$msg = str_replace(" ", "\s", $msg);

        $user = $this->container->getParameter('ts3_user');
        $pass = $this->container->getParameter('ts3_pass');
        $host = $this->container->getParameter('ts3_host');
        $port = $this->container->getParameter('ts3_port');

		$ts=Util::teamspeak($host,$port);
        $login=Util::login($ts,$user,$pass);
        $use=Util::usee($ts,"1");
        $element=Util::clientpoke($ts,$clid,$msg);

		return $element;
    }
    /**
     * Teamspeak channeldelete
     * @Route("/admin/teamspeak/channeldelete/{cid}/{force}/", name="teamspeak_channeldelete") 
     * @Template()    
     */
    public function channeldeleteAction(Request $request,$cid,$force){

        $user = $this->container->getParameter('ts3_user');
        $pass = $this->container->getParameter('ts3_pass');
        $host = $this->container->getParameter('ts3_host');
        $port = $this->container->getParameter('ts3_port');

        $ts=Util::teamspeak($host,$port);
        $login=Util::login($ts,$user,$pass);
        $use=Util::usee($ts,"1");
        $element=Util::channeldelete($ts,$cid,$force);

        if ($element['r']){
        	//$referer = $request->headers->get('referer');
        	//return new RedirectResponse($referer);
        	//return $this->redirect($this->generateUrl('teamspeak_channellist')); 
        }
        return $element;
    }
	/**
     * Teamspeak createchannel
     * @Route("/admin/teamspeak/channelcreate", name="teamspeak_channelcreate" )     
     * @Template()
     */
    public function channelcreateAction(Request $request){

		$channel_name= $request->query->get('channel_name');
		$channel_topic= $request->query->get('channel_topic');

    	$channel_name = str_replace(" ", "\s", $channel_name);
    	$channel_topic = str_replace(" ", "\s", $channel_topic);

        $user = $this->container->getParameter('ts3_user');
        $pass = $this->container->getParameter('ts3_pass');
        $host = $this->container->getParameter('ts3_host');
        $port = $this->container->getParameter('ts3_port');


        $usr= $this->get('security.context')->getToken()->getUser();
        $usuario = $usr->getUsername();
        $usuarioId= $usr->getId();

        $ts=Util::teamspeak($host,$port);
        $login=Util::login($ts,$user,$pass);
        $use=Util::usee($ts,"1");
        $element=Util::channelcreate($ts,$channel_name,$channel_topic);

        return $element;
    }
    /**
     * Teamspeak channelgrouplist
     * @Route("/admin/teamspeak/channelgrouplist", name="teamspeak_channelgrouplist" ) 
     * @Template()    
     */
    public function channelgrouplistAction(){
        $user = $this->container->getParameter('ts3_user');
        $pass = $this->container->getParameter('ts3_pass');
        $host = $this->container->getParameter('ts3_host');
        $port = $this->container->getParameter('ts3_port');

        $ts=Util::teamspeak($host,$port);
        $login=Util::login($ts,$user,$pass);
        $use=Util::usee($ts,"1");
        $element=Util::channelgrouplist($ts);
        
        return array(
            'element' => $element
        );
    }
	/**
     * Teamspeak channelgrouppermlist
     * @Route("/admin/teamspeak/channelgrouppermlist/{cgid}/", name="teamspeak_channelgrouppermlist" ) 
     * @Template()    
     */
    public function channelgrouppermlistAction($cgid){
        $user = $this->container->getParameter('ts3_user');
        $pass = $this->container->getParameter('ts3_pass');
        $host = $this->container->getParameter('ts3_host');
        $port = $this->container->getParameter('ts3_port');

		$ts=Util::teamspeak($host,$port);
        $login=Util::login($ts,$user,$pass);
        $use=Util::usee($ts,"1");
        $element=Util::channelgrouppermlist($ts,$cgid);

        return array(
            'element' => $element
        );
    }
	/**
     * Teamspeak channelpermlist
     * @Route("/admin/teamspeak/channelpermlist/{cid}/", name="teamspeak_channelpermlist" ) 
     * @Template()    
     */
    public function channelpermlistAction($cid){
        $user = $this->container->getParameter('ts3_user');
        $pass = $this->container->getParameter('ts3_pass');
        $host = $this->container->getParameter('ts3_host');
        $port = $this->container->getParameter('ts3_port');

        $usr= $this->get('security.context')->getToken()->getUser();
        $usuario = $usr->getUsername();
        $usuarioId= $usr->getId();

        $ts=Util::teamspeak($host,$port);
        $login=Util::login($ts,$user,$pass);
        $use=Util::usee($ts,"1");
        $element=Util::channelpermlist($ts,$cid);

        return array(
            'element' => $element
        );
        
    }
    /**
     * Teamspeak clientdbinfo
     * @Route("/admin/teamspeak/clientdbinfo/{cldbid}/", name="teamspeak_clientdbinfo" ) 
     * @Template()    
     */
    public function clientdbinfoAction($cldbid){
        $user = $this->container->getParameter('ts3_user');
        $pass = $this->container->getParameter('ts3_pass');
        $host = $this->container->getParameter('ts3_host');
        $port = $this->container->getParameter('ts3_port');

        $usr= $this->get('security.context')->getToken()->getUser();
        $usuario = $usr->getUsername();
        $usuarioId= $usr->getId();

        $ts=Util::teamspeak($host,$port);
        $login=Util::login($ts,$user,$pass);
        $use=Util::usee($ts,"1");
        $element=Util::clientdbinfo($ts,$cldbid);

        return array(
            'element' => $element
        );
    }


























    

    
	
	
   





    


}
