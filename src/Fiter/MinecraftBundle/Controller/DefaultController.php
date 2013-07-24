<?php

namespace Fiter\MinecraftBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller{

    /**
     * @Route("/minecraft/playerlist")
     * @Template()
     */
    public function indexAction(){
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
        //if ($res=='error id=0 msg=ok') return 1;
        //return 0;
        return array(
            'port' => $port,
            'numplayers' => $numplayers,
            'maxplayers' => $maxplayers,
            'playerlist' => $playerlist,            
        );
    }


    /**
     * Minecraft status
     *
     * @Route("/minecraft/status", name="minecraft" )     
     * @Template()
     */
    public function minecraftAction(){
        $minecraft = $this->get('fiter.minecraft');
        $server = $this->container->getParameter('minecraft_server');
        $status = $minecraft->getStatus($server);

        $ok=false;
        if ($status!=null) $ok=true;
            
        return array(
            'status' => $status,
            'ok' => $ok,
        );
    }

    /**
     * Minecraft status2
     *
     * @Route("/minecraft/status2", name="minecraft2" )     
     * @Template()
     */
    public function minecraft2Action(){
        $minecraft = $this->get('fiter.minecraft');

        $servers = array(
            //"dejamejugar.com",
            //"dejamejugar.com"
        );
        $status =  array(); 
        foreach ($servers as $server) {
            $stat = $minecraft->getStatus($server);
            if($stat!=false) $status[] = $stat;
        }
        return array(
            'statusarray' => $status
        );
    }
}
