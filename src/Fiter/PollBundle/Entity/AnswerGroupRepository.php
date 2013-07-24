<?php

namespace Fiter\PollBundle\Entity;

use Doctrine\ORM\EntityRepository;

class AnswerGroupRepository extends EntityRepository{
    
    public function findAllAnswerGroupByUserDQL($user){
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
            SELECT o FROM FiterPollBundle:AnswerGroup o
            WHERE o.author = :user
        ');
        $consulta->setParameter('user', $user);
        return $consulta;
    }
    public function findAllAnswerGroupByUser($user){
        return $this->findAllAnswerGroupByUserDQL($user)->getResult();
    }
    public function findAllAnswerGroupByPollDQL($poll){
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
            SELECT o FROM FiterPollBundle:AnswerGroup o
            WHERE o.poll = :poll
        ');
        $consulta->setParameter('poll', $poll);
        return $consulta;
    }
    public function findAllAnswerGroupByPoll($poll){
        return $this->findAllAnswerGroupByPollDQL($poll)->getResult();
    }    
}
