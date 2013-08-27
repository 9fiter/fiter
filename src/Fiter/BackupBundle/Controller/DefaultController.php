<?php

namespace Fiter\BackupBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Fiter\DefaultBundle\Util\Shell;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DefaultController extends Controller{

    /**
     * @Route("/delete/all", name="backup_delete_all")
     * @Template()
     */
    public function deleteallAction(Request $request){
        
        $bkp_folder = $this->container->getParameter('backup_folder');
        $delete = shell_exec("rm -R $bkp_folder/2* && rm -R $bkp_folder/temp/2*");

        $referer = $request->headers->get('referer');       
        $request->getSession()->setFlash('notice', "Copias de seguridad eliminadas");
        return new RedirectResponse($referer);

        
    }


    /**
     * @Route("/", name="backup")
     * @Template()
     */
    public function indexAction(){

    	$mc_folder = $this->container->getParameter('minecraft_folder');
    	$bkp_folder = $this->container->getParameter('backup_folder');
        $backups = shell_exec("ls -la --block-size=M $bkp_folder | nawk '".'{printf("%-60s\t%s\n" , $9,$5) }'."' | grep bz2 | grep -v log");
        $backupstemp = shell_exec("ls -la --block-size=M $bkp_folder/temp | nawk '".'{printf("%-60s\t%s\n" , $9,$5) }'."' | grep bz2 | grep -v log");
        $log = shell_exec('tail  -n 1000 '.$mc_folder.'server.log |  grep "\(SEVERE\|WARNING\)"');

        return array(
        	'backups' => $backups,
            'backupstemp' => $backupstemp,
        	'log' => $log,
        );
    }
    /**
     * @Route("/fullmc", name="backup_fullmc")
     * @Template()
     */
    public function fullmcAction(Request $request){
        
        $kernel = $this->get('kernel');
        $scripts_path = $kernel->locateResource('@FiterBackupBundle/scripts');
        $bkp_folder = $this->container->getParameter('backup_folder');
        $mc_folder = $this->container->getParameter('minecraft_folder');

        $shell = $this->get('shell');
        //$cmd = "sh $scripts_path/makebkpfullmc.sh $bkp_folder $scripts_path $mc_folder > /dev/null &";

        $cmd = "bash $scripts_path/makebkpfullmc.sh $bkp_folder $scripts_path $mc_folder > /home/backup/tar.output.txt 2> /home/backup/tar.errors.txt < /dev/null &";


        $shell->cmd($cmd);

        $referer = $request->headers->get('referer');       
        $request->getSession()->setFlash('notice', "Copia de seguridad completa inciada");
        return new RedirectResponse($referer);
    }
    /**
     * @Route("/full", name="backup_full")
     * @Template()
     */
    public function fullAction(Request $request){
        
        $kernel = $this->get('kernel');
        $scripts_path = $kernel->locateResource('@FiterBackupBundle/scripts');
        $bkp_folder = $this->container->getParameter('backup_folder');
        $fiter_path = str_replace("/app", "", $kernel->getRootDir());

        //$mc_db_name = $this->container->getParameter('minecraft_database_name');
        //$mc_db_user = $this->container->getParameter('minecraft_database_user');
        //$mc_db_pass = $this->container->getParameter('minecraft_database_password');

        //$fiter_db_name = $this->container->getParameter('database_name');
        //$fiter_db_user = $this->container->getParameter('database_user');
        //$fiter_db_pass = $this->container->getParameter('database_password');

        //$phpbb3_db_name = $this->container->getParameter('phpbb3_database_name');
        //$phpbb3_db_user = $this->container->getParameter('phpbb3_database_user');
        //$phpbb3_db_pass = $this->container->getParameter('phpbb3_database_password');

        $shell = $this->get('shell');
        $cmd = "bash $scripts_path/full.sh >/dev/null &";
        //ladybug_dump($cmd);
        //ladybug_dump($shell);
        $res=$shell->cmd($cmd);
        //ladybug_dump($res);

        $referer = $request->headers->get('referer');       
        $request->getSession()->setFlash('notice', "Copia de seguridad completa inciada");
        return new RedirectResponse($referer);
    }

    /**
     * @Route("/diff", name="backup_diff")
     * @Template()
     */
    public function diffAction(Request $request){
        
        $kernel = $this->get('kernel');
        $scripts_path = $kernel->locateResource('@FiterBackupBundle/scripts');
        $bkp_folder = $this->container->getParameter('backup_folder');
        $fiter_path = str_replace("/app", "", $kernel->getRootDir());

        $shell = $this->get('shell');
        $cmd = "sh $scripts_path/makebkpdiff.sh $bkp_folder $scripts_path $fiter_path > /dev/null &";
        $shell->cmd($cmd);

        $referer = $request->headers->get('referer');       
        $request->getSession()->setFlash('notice', "Copia de seguridad inciada");
        return new RedirectResponse($referer);
    }


    /**
     * @Route("/minecraft/server/start", name="minecraft_server_start")
     * @Template()
     */
    public function minecraftServerStartAction(){

    	$outputs = array();
    	$status = exec("/etc/init.d/craftopia status");
    	$outputs[] = $status;
    	$status = substr($status[0],0 ,1);
		
    	if ($status=='0'){
    		$shell = $this->get('shell');
			$outputs[] = $shell->cmd('/etc/init.d/craftopia start');
			$outputs[] = exec("/etc/init.d/craftopia status");
		}

        return array(
        	'outputs' => $outputs,        	
        );
    }
    /**
     * @Route("/minecraft/server/stop", name="minecraft_server_stop")
     * @Template()
     */
    public function minecraftServerStopAction(){
    	$outputs = array();
    	$status = exec("/etc/init.d/craftopia status");
    	$outputs[] = $status;
    	$status = substr($status[0],0 ,1);
    	if ($status=='1'){
			$shell = $this->get('shell');
			$outputs[] = $shell->cmd('/etc/init.d/craftopia stop');
			$outputs[] = exec("/etc/init.d/craftopia status");
		}
        return array(
        	'outputs' => $outputs,
        );
    }
    /**
     * @Route("/minecraft/server/stop/force", name="minecraft_server_stop_force")
     * @Template()
     */
    public function minecraftServerStopForceAction(){

    	$outputs = array();
    	$status = exec("/etc/init.d/craftopia status");
    	$outputs[] = $status;
    	$status = substr($status[0],0 ,1);
		
    	if ($status=='1'){
    		$shell = $this->get('shell');
    		//ps aux | awk '/craftopia/ { print $2" " $15}' | grep craftopia
			$data = $shell->cmd("ps aux | awk '/craftopia/ { print $2 \" \"$15}' | grep craftopia");
			$outputs[] = $data;
			
			$pos = strpos($data, ' ');
			$pid = substr($data,0 ,$pos);

			$data2 = $shell->cmd("kill -9 $pid && ps -p $pid | grep $pid");

			if ($data2=="") $outputs[] = "Minecraft parado correctamente";
			else{
				$outputs[] = $data2;
				$outputs[] = "Minecraft no se pudo parar \n $data2";
			} 
		}
        return array(
        	'outputs' => $outputs,        	
        );
    }
}
