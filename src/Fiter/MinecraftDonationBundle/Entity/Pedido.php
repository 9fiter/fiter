<?php

namespace Fiter\MinecraftDonationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Payment\CoreBundle\Entity\PaymentInstruction;
use Wikp\PaymentMtgoxBundle\Plugin\OrderInterface;


/**
 * Pedido
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Fiter\MinecraftDonationBundle\Entity\PedidoRepository")
 */
class Pedido {

    const STATUS_NEW = 0;
    const STATUS_FINISHED = 1;
    const STATUS_CANCELLED = 2;


    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Get id
     * @return integer 
     */
    public function getId(){ return $this->id; }

    /** @ORM\OneToOne(targetEntity="JMS\Payment\CoreBundle\Entity\PaymentInstruction") */
    private $paymentInstruction;

    /** @ORM\Column(type="string", unique = true) */
    private $orderNumber;

    /** @ORM\Column(type="decimal", scale = 2) */
    private $amount;

    /** @ORM\Column(type="string") */
    private $cart;

    /** @ORM\Column(type="string") */
    private $user;

    public function __construct(){
        //$this->amount = $amount;
        //$this->orderNumber = $orderNumber;
        $this->status = self::STATUS_NEW;
    }
    public function __toString(){ return $this->getOrderNumber(); }
    public function getOrderNumber(){ return $this->orderNumber; }
    public function setOrderNumber($orderNumber){ $this->orderNumber = $orderNumber; }
    public function getAmount(){ return $this->amount; }
    public function setAmount($amount){ $this->amount = "$amount";}
    public function getPaymentInstruction(){ return $this->paymentInstruction; }
    public function setPaymentInstruction(PaymentInstruction $instruction){ $this->paymentInstruction = $instruction; }
    public function getCart(){ return $this->cart; }
    public function setCart($cart){ $this->cart = $cart; }
    public function getUser(){ return $this->user; }
    public function setUser($user){ $this->user = $user; }
    public function cancel(){ $this->status = self::STATUS_CANCELLED;}
    public function approve(){ $this->status = self::STATUS_FINISHED; }

}
