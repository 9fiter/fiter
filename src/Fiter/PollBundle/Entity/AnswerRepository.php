<?php

namespace Fiter\PollBundle\Entity;

use Doctrine\ORM\EntityRepository;

class AnswerRepository extends EntityRepository{
    public function countAnswerByFieldIdDQL($fieldId){
        $em = $this->getEntityManager();
        $query = $em->createQuery('
            SELECT COUNT(o.id) FROM FiterPollBundle:Answer o
            JOIN o.field c
            WHERE c.id = :id
        ');
        $query->setParameter('id', $fieldId);
        //$total = $query->select('COUNT(f)')->getQuery()->getSingleScalarResult();               
        return $query->getResult();
    }
    public function checkCanAnswer($authorId,$poll){
        $em = $this->getEntityManager();
        $query = $em->createQuery('
            SELECT COUNT(o.id) FROM FiterPollBundle:AnswerGroup o
            LEFT JOIN o.author a
            WHERE a.id = :id
            AND o.poll = :poll
        ');
        $query->setParameter('id', $authorId);
        $query->setParameter('poll', $poll);
        //ladybug_dump($query->getSQL());
        return $query->getResult();
    }
    public function findAllAnswerAnswerGroupDQL(){
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
            SELECT o FROM FiterPollBundle:Answer o
            JOIN o.answerGroup c
        ');
        return $consulta;
    }
    public function findAllAnswerAnswerGroup(){
        return $this->findAllAnswerAnswerGroupDQL()->getResult();
    }
    
}
