<?php

namespace Fiter\MinecraftDonationBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PedidoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PedidoRepository extends EntityRepository{

	public function getOrderById($id){
        return $this->find($id);
    }
	
}