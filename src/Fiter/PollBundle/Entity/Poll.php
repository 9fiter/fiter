<?php

namespace Fiter\PollBundle\Entity;

use Bait\PollBundle\Entity\Poll as BasePoll;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="poll")
 * @ORM\Entity(repositoryClass="Fiter\PollBundle\Entity\PollRepository")
 */
class Poll extends BasePoll{

    /**
     * @var boolean
     * @ORM\Column(name="principal", type="boolean")
     */
    private $principal;

    public function getPrincipal(){
        return $this->principal;
    }
    public function setPrincipal($principal){
        $this->principal = $principal;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Fiter\DefaultBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="usuario", referencedColumnName="id")
     */
    private $usuario;

    /**
     * Set usuario
     * @param string $usuario
     * @return Articulo
     */
    public function setUsuario($usuario){
        $this->usuario = $usuario;
        return $this;
    }

    /**
     * Get usuario
     * @return string 
     */
    public function getUsuario(){
        return $this->usuario;
    }


    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\OneToMany(targetEntity="Field", mappedBy="poll", cascade={"persist"})
     */
    protected $fields;
    /**
     * Add fields
     *
     * @param Field $fields
     */
    public function addField(Field $fields){
        $this->fields[] = $fields;
    }
    public function removeField(Field $fields){
        //
    }
    /**
     * Get fields
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getFields(){
        return $this->fields;
    }
    public function setFields($fields){
        $this->fields = $fields;
    }
    public function getIsActive(){
        return $this->isActive;
    }
    public function setIsActive($isActive){
        $this->isActive = $isActive;
    }
    public function __toString(){ return $this->getTitle(); }
    public function __construct(){
        $this->title="";
        $this->isActive=true;
        $this->principal=false;
        $this->answersVisible=true;
        $fechaFin= new \DateTime("now");
        $fechaFin->modify('+365 day');
        $this->createdAt=new \DateTime("now");
        $this->deletedAt=$fechaFin;
        $this->startAt=new \DateTime("now");
        $this->endAt=$fechaFin;
        $this->type=0;
        $this->usuario="Anónimo";  
    }
}