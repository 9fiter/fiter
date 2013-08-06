<?php

namespace Fiter\PhotoContestBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PhotoRepository
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ContestRepository extends EntityRepository{



	 public function findAllContestByFechaInicioDQL(){
        $em = $this->getEntityManager('minecraft');
        $consulta = $em->createQuery('
            SELECT o FROM FiterPhotoContestBundle:Contest o
            WHERE o.activo=true
            ORDER BY o.fechaInicio DESC
            ');
        return $consulta;
    }
    public function findAllContestByFechaInicio(){
        return $this->findAllContestByFechaInicioDQL()->getResult();
    }   



}