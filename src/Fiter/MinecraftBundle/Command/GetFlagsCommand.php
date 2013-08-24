<?php

namespace Fiter\MinecraftBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GetFlagsCommand extends ContainerAwareCommand{

    protected function configure(){
        $this
            ->setName('mc:getflags')
            ->setDescription('Get flags')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output){
        //$em = $this->getDoctrine()->getManager('minecraft');
        $em = $this->getContainer()->get('doctrine')->getEntityManager('minecraft');
        $entities = $em->getRepository('FiterMinecraftBundle:Authme')->findAll();
        $geoip = $this->getContainer()->get('raindrop.geoip');
        foreach ($entities as $entity){
            if($entity->getCountryName()==null){
                //$geoip = $this->get('raindrop.geoip')->lookup($entity->getIp());
                //$geoip = $this->getContainer()->get('raindrop.geoip')->lookup($entity->getIp());
                $geoip->lookup($entity->getIp());
                if($geoip){
                    $entity->setCountryCode($geoip->getCountryCode());
                    $entity->setCountryCode3($geoip->getCountryCode3());
                    $entity->setCountryName($geoip->getCountryName());
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

        $output->writeln('OK');
    }
}