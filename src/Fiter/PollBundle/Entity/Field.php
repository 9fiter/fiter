<?php

namespace Fiter\PollBundle\Entity;

use Bait\PollBundle\Entity\Field as BaseField;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="poll_field")
 */
class Field extends BaseField{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Field", mappedBy="parent")
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $children;

    /**
     * @ORM\ManyToOne(targetEntity="Field", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    protected $parent;

    /**
     * @ORM\ManyToOne(targetEntity="Poll")
     */
    protected $poll;

    public function getIsActive(){
        return $this->isActive;
    }
    public function setIsActive($isActive){
        $this->isActive= $isActive;
    }
    public function getPoll(){
        return $this->poll;
    }
    public function setPoll($poll){
        $this->poll=$poll;
    }
    public function removeValidationConstraint($validationConstraint){
        $position = array_search($this->validationConstraints, $validationConstraint);
        if ($position !== false) { 
            unset($this->validationConstraints[$position]);
        }return $this;
    }
    public function __toString(){
        return $this->getTitle();
    }
    public function setValidationConstraints($validationConstraints){
        $this->validationConstraints= $validationConstraints;
    }
    public function __construct(){
        $this->title="";
        $this->isActive=true;
        $this->required=true;
        $fechaFin= new \DateTime("now");
        $fechaFin->modify('+365 day');
        $this->createdAt=new \DateTime("now");
        $this->deletedAt=$fechaFin;
        $this->assetPath="/";
        $this->position=0;
        $this->validationConstraints=0;
        $this->type=0;
    }
}