<?php
namespace Fiter\TeamspeakBundle\Util;

class Util {
    
    static public function teamspeak($host,$port){
        $res="";
        $ts = fsockopen($host, $port, $errno, $errstr, 5);
        if (!$ts) return 0;
        else {
            $res = fgets($ts); //TS3
            $res = trim(fgets($ts));
        }
        return $ts;
    }
    static public function login($ts,$user,$pass){
        $out  = "login client_login_name=$user client_login_password=$pass\n";
        fwrite($ts, $out);
        $res = trim(fgets($ts));
        if ($res=='Welcome to the TeamSpeak 3 ServerQuery interface, type "help" for a list of commands and "help <command>" for information on a specific command.') 
            return 1;
        return 0;
    }
    static public function usee($ts,$sid){
        $out  = "use sid=$sid\n";
        fwrite($ts, $out);
        $res = trim(fgets($ts));
        //ladybug_dump($res);
        if ($res=='error id=0 msg=ok') return 1;
        return 0;
    }
    static public function tokendelete($ts,$token){
        $e=0;
        $element=array();
        $out = "tokendelete token=$token\n";
        fwrite($ts, $out);
        $res = trim(fgets($ts));
        if($res=='error id=0 msg=ok') $e=1;
        return array(
            'res' => $res,
            'e' => $e,
        );
    }
    static public function channellist($ts){
        $element=array();
        $out = "channellist\n";
        fwrite($ts, $out);
        $res = trim(fgets($ts));
        if (strpos($res,'cid=') !== false) {
            $element = explode("|", trim($res));
            foreach ($element as $key => $value) {
                $element[$key] = explode(" ", $value);
                $salida= array();
                foreach ($element[$key] as $key2 => $value2) {
                    $pos = strpos($element[$key][$key2], "=");
                    $p = substr($element[$key][$key2], 0, $pos);
                    $val = substr($element[$key][$key2], $pos+1);
                    $salida[$p] = $val;
                }$element[$key] = $salida;
            }
            $res = trim(fgets($ts));
            return $element;
        }return 0;
    }
    static public function tokenlist($ts){
        $element=array();
        $out = "tokenlist\n";
        fwrite($ts, $out);
        $res = trim(fgets($ts));
        if (strpos($res,'token=') !== false) {
            $element = explode("|", trim($res));
            foreach ($element as $key => $value)
                $element[$key] = explode(" ", $value);
            return $element;
        }return 0;
    }
    static public function clientlist($ts){
        $element=array();
        $out = "clientlist\n";
        fwrite($ts, $out);
        $res = trim(fgets($ts));
        if (strpos($res,'clid=') !== false) {
            $element = explode("|", $res);
            foreach ($element as $key => $value) {
                $element[$key] = explode(" ", $value);
                $salida= array();
                $salida['cid']= "";
                foreach ($element[$key] as $key2 => $value2) {
                    $pos = strpos($element[$key][$key2], "=");
                    $p = substr($element[$key][$key2], 0, $pos);
                    $val = substr($element[$key][$key2], $pos+1);
                    $salida[$p] = $val;
                }
                $element[$key] = $salida;
            }return $element;
        }return 0;
    }
    static public function clientdblist($ts){
        $element=array();
        $out = "clientdblist\n";
        fwrite($ts, $out);
        $res = trim(fgets($ts));
        if (strpos($res,'cldbid=') !== false) {
            $element = explode("|", trim($res));
            foreach ($element as $key => $value) {
                $element[$key] = explode(" ", $value);
                $salida= array();
                foreach ($element[$key] as $key2 => $value2) {
                    $pos = strpos($element[$key][$key2], "=");
                    $p = substr($element[$key][$key2], 0, $pos);
                    $val = substr($element[$key][$key2], $pos+1);
                    $salida[$p] = $val;
                }
                $element[$key] = $salida;
            }return $element;
        }return 0;
    }
    static public function servergrouplist($ts){
        $element=array();
        $out = "servergrouplist\n";
        fwrite($ts, $out);
        $res = trim(fgets($ts));
        if (strpos($res,'sgid=') !== false) {
            $element = explode("|", trim($res));
            foreach ($element as $key => $value)
                $element[$key] = explode(" ", $value);
            return $element;
        }return 0;
    }
    static public function serverinfo($ts){
        $element=array();
        $out = "serverinfo\n";
        fwrite($ts, $out);
        $res = trim(fgets($ts));
        if (strpos($res,'virtualserver_unique_identifier=') !== false) {
            $element = explode(" ", trim($res));
            return $element;
        }return 0;
    }
    static public function banclient($ts,$clid,$time,$banreason){
        $element=array();
        $out = "banclient clid=$clid time=$time banreason=$banreason\n";
        fwrite($ts, $out);
        $res = trim(fgets($ts));
        if (strpos($res,'banid=') !== false) {
            $element = explode(" ", trim($res));
            $res = trim(fgets($ts));
            if (strpos($res,'banid=') !== false) {
                $res = trim(fgets($ts));
                if ($res="error id=0 msg=ok") return $element;
            }
        }return 0;
    }
    static public function banlist($ts){
        $element=array();
        $out = "banlist\n";
        fwrite($ts, $out);
        $res = trim(fgets($ts));
        if ($res=='error id=1281 msg=database\sempty\sresult\sset') return 0;
        else{
            $element = explode("|", trim($res));
            foreach ($element as $key => $value) {
                $element[$key] = explode(" ", $value);
            }return $element;
        }
    }
    static public function bandelall($ts){
        $e=0;
        $out = "bandelall\n";
        fwrite($ts, $out);
        $res = trim(fgets($ts)); //
        if ($res=="error id=0 msg=ok") $e=1;
        return array(
            'element' => $res,
            'e'=>$e,
        );
    }
    static public function bandel($ts,$banid){
        $e=0;
        $res="";
        $out = "bandel banid=$banid\n";
        fwrite($ts, $out);
        $res = trim(fgets($ts));
        if ($res=='error id=0 msg=ok') $e=1;
        return array(
            'res' => $res,
            'e'=> $e
        );
    }
    static public function clientinfo($ts,$clid){
        $res="";
        $element = array();
        $out = "clientinfo clid=$clid\n";
        fwrite($ts, $out);
        $res = trim(fgets($ts)); //
        if (strpos($res,'cid=') !== false) {
            $element = explode(" ", $res);
            $salida= array();
            foreach ($element as $key2 => $value2) {
                $pos = strpos($element[$key2], "=");
                $p = substr($element[$key2], 0, $pos);
                $val = substr($element[$key2], $pos+1);
                $salida[$p] = $val;
            }
            $element = $salida;
            ladybug_dump($element);
        }return $element;
    }
    static public function gm($ts,$msg){
        $element = array();
        $res="";
        $out = "gm msg=$msg\n";
        fwrite($ts, $out);
        $res = trim(fgets($ts));
        ladybug_dump($res);
        return $element;
    }
    static public function clientgetnamefromdbid($ts,$cldbid){
        $salida= array();
        $res="";
        $element = array(); 
        $out = "clientgetnamefromdbid cldbid=$cldbid\n";
        fwrite($ts, $out);
        $res = fgets($ts);
        if (strpos($res,'cluid=') !== false) {
            $element = explode(" ", $res);
            foreach ($element as $key => $value) {
                $pos = strpos($element[$key], "=");
                $p = substr($element[$key], 0, $pos);
                $val = substr($element[$key], $pos+1);
                $salida[$p] = $val;
            }
        }return $salida;
    }
    static public function sendtextmessage($ts,$targetmode,$target,$msg){
        $element = array();
        $res="";
        $out = "sendtextmessage targetmode=$targetmode target=$target msg=$msg\n";
        fwrite($ts, $out);
        $res = fgets($ts); //TS3
        if (strpos($res,'notifytextmessage ') !== false) {
            $element=true;
        }return $element;
    }
    static public function clientupdate($ts,$client_nickname){
        $element=false;
        $out = "clientupdate client_nickname=$client_nickname\n";
        fwrite($ts, $out);
        $res = trim(fgets($ts));
        if ($res=="error id=0 msg=ok") $element=true;
        return array(
            'element' => $element,
            'e'=> $res,
        );
    }
    static public function clientkick($ts,$reasonid,$reasonmsg,$clid){
        $element=false;
        $res="";
        $out = "clientkick reasonid=$reasonid reasonmsg=$reasonmsg clid=$clid\n";
        fwrite($ts, $out);
        $res = trim(fgets($ts));
        if ($res=="error id=0 msg=ok") $element=true;
        return array(
            'element' => $element,
            'e'=> $res,
        );
    }
    static public function clientpoke($ts,$clid,$msg){
        $element=false;
        $out = "clientpoke msg=$msg clid=$clid\n";
        fwrite($ts, $out);
        $res = trim(fgets($ts));
        if ($res=="error id=0 msg=ok") $element=true;
        return array(
            'element' => $element,
            'e'=> $res,
        );
    }
    static public function channeldelete($ts,$cid,$force){
        $r=0;
        $element=false;
        $out = "channeldelete cid=$cid force=$force\n";
        fwrite($ts, $out);
        $res = trim(fgets($ts));
        if ($res=="error id=0 msg=ok") {
            $element=true;
            $r=1;
        }             
        return array(
            'element' => $element,
            'e'=> $res,
            'r'=> $r,
        );
    }
    static public function channelcreate($ts,$channel_name,$channel_topic){
        $element=false;
        $out = "channelcreate channel_name=$channel_name channel_topic=$channel_topic channel_flag_permanent=1\n";
        fwrite($ts, $out);
        $res = fgets($ts); //
        if (strpos($res,'cid=') !== false) {
            $element = true;
            //$referer = $request->headers->get('referer');
            //return new RedirectResponse($referer);
            //return $this->redirect($this->generateUrl('teamspeak_channellist'));
        }
        return array(
            'element' => $element,
            'e' => $res,
        );
    }
    static public function channelgrouplist($ts){
        $out = "channelgrouplist\n";
        $element = array();
        fwrite($ts, $out);
        $res = fgets($ts); //
        $element = explode("|", trim($res));
        foreach ($element as $key => $value) {
            $element[$key] = explode(" ", $value);
            $salida= array();
            foreach ($element[$key] as $key2 => $value2) {
                $pos = strpos($element[$key][$key2], "=");
                $p = substr($element[$key][$key2], 0, $pos);
                $val = substr($element[$key][$key2], $pos+1);
                $salida[$p] = $val;
            }
            $element[$key] = $salida;
        }return $element;
    }
    static public function channelgrouppermlist($ts,$cgid){
        $res="";
        $element = array();
        $out = "channelgrouppermlist  cgid=$cgid\n";
        fwrite($ts, $out);
        $res = trim(fgets($ts));

        if($res!="error id=2568 msg=insufficient\sclient\spermissions failed_permid=21"){
            $element = explode("|", trim($res));
            foreach ($element as $key => $value) {
                $element[$key] = explode(" ", $value);
                $salida= array();

                //permisos insuficientes crash
                $salida['permid']="";
                $salida['permvalue']="";
                $salida['permnegated']="";
                $salida['permskip']="";
                
                foreach ($element[$key] as $key2 => $value2) {
                    $pos = strpos($element[$key][$key2], "=");
                    $p = substr($element[$key][$key2], 0, $pos);
                    $val = substr($element[$key][$key2], $pos+1);
                    $salida[$p] = $val;
                }
                $element[$key] = $salida;
            }
        }return $element;
    }
    static public function channelpermlist($ts,$cid){
        $element = array();
        $out = "channelpermlist  cid=$cid\n";
        fwrite($ts, $out);
        $res = fgets($ts);
        $element = explode("|", trim($res));
        foreach ($element as $key => $value) {
            $element[$key] = explode(" ", $value);
            $salida= array();
            $salida['cid']="";
            foreach ($element[$key] as $key2 => $value2) {
                $pos = strpos($element[$key][$key2], "=");
                $p = substr($element[$key][$key2], 0, $pos);
                $val = substr($element[$key][$key2], $pos+1);
                $salida[$p] = $val;
            }
            $element[$key] = $salida;
        }return $element;
    }
    static public function clientdbinfo($ts,$cldbid){
        $out = "clientdbinfo  cldbid=$cldbid\n";
        $element = array();
        fwrite($ts, $out);
        $res = fgets($ts);
        $element = explode("|", trim($res));
        foreach ($element as $key => $value) {
            $element[$key] = explode(" ", $value);
            $salida= array();
            foreach ($element[$key] as $key2 => $value2) {
                $pos = strpos($element[$key][$key2], "=");
                $p = substr($element[$key][$key2], 0, $pos);
                $val = substr($element[$key][$key2], $pos+1);
                $salida[$p] = $val;
            }
            $element[$key] = $salida;
        }return $element;
    }
    
}

