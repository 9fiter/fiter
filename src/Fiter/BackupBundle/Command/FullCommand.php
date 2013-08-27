<?php

namespace Fiter\BackupBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Fiter\DefaultBundle\Util\Shell;

class FullCommand extends ContainerAwareCommand{

    protected function configure(){
        $this
            ->setName('bkp:full')
            ->setDescription('Backup of fiter folders')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output){
        $kernel = $this->getContainer()->get('kernel');
        $scripts_path = $kernel->locateResource('@FiterBackupBundle/scripts');
        $bkp_folder = $this->getContainer()->getParameter('backup_folder');
        $fiter_path = str_replace("/app", "", $kernel->getRootDir());
        $shell = $this->getContainer()->get('shell');       
        $cmd = "bash $scripts_path/full.sh $bkp_folder $scripts_path $fiter_path &";
        $shell->cmd($cmd);
        $output->writeln("Copia iniciada");
    }
}