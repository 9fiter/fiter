<?php
namespace Fiter\DefaultBundle\Util;

class Shell {
    private $host;
    private $user;
    private $pass;
    private $cmd;
    private $data;

    public function __construct($host,$user,$pass) {
        $this->host = $host;
        $this->user = $user;
        $this->pass=$pass;
    }


    public function cmd($cmd) {
        $this->cmd=$cmd;

        $data = '';
        if($ssh = ssh2_connect($this->host, 22)) {
            if(ssh2_auth_password($ssh, $this->user, $this->pass)) {
                $stream = ssh2_exec($ssh, $this->cmd); 
                stream_set_blocking($stream, true);
                while($buffer = fread($stream, 4096)) {
                    $data .= $buffer;
                }
                fclose($stream);
            }
        }
        $this->data=$data;
        return $data;
    }
    
}

?>
