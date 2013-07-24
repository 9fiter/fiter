<?php

namespace Fiter\PollBundle\Entity;

use Doctrine\ORM\EntityRepository;

class PollRepository extends EntityRepository{
    public function findAllPollsActiveNotFinalizedFieldsDQL(){
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
            SELECT o FROM FiterPollBundle:Poll o
            JOIN o.fields c
            WHERE o.isActive = true and 
            o.endAt > :endAt
        ');
        $consulta->setParameter('endAt', new \DateTime("now"));
        return $consulta;
    }
    public function findAllPollsActiveNotFinalizedFields(){
        return $this->findAllPollsActiveNotFinalizedFieldsDQL()->getResult();
    }

    public function findAllPollsByUserDQL($usuario){
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
            SELECT o FROM FiterPollBundle:Poll o
            JOIN o.fields c
            WHERE o.usuario = :usuario
        ');
        $consulta->setParameter('usuario', $usuario);
        return $consulta;
    }
    public function findAllPollsByUser($usuario){
        return $this->findAllPollsByUserDQL($usuario)->getResult();
    }


    

    
    
    
    
}
