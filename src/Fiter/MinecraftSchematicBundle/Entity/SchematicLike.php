<?php

namespace Fiter\MinecraftSchematicBundle\Entity;

use Fiter\DefaultBundle\Util\Util;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Fiter\DefaultBundle\Entity\Usuario;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * SchematicLike
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Fiter\MinecraftSchematicBundle\Entity\SchematicLikeRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class SchematicLike{
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;



    /**
     * @ORM\ManyToOne(targetEntity="Fiter\DefaultBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="usuario", referencedColumnName="id")
     */
    private $usuario;
    /**
     * Set usuario
     * @param string $usuario
     * @return Schematic
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
     * @ORM\ManyToOne(targetEntity="Schematic")
     * @ORM\JoinColumn(name="schematic", referencedColumnName="id")
     */
    private $schematic;
    /**
     * Set schematic
     * @param string $schematic
     * @return Schematic
     */
    public function setSchematic($schematic){
        $this->schematic = $schematic;
        return $this;
    }
    /**
     * Get schematic
     * @return string 
     */
    public function getSchematic(){
        return $this->schematic;
    }



    /**
     * @var boolean
     * @ORM\Column(name="notLike", type="boolean")
     */
    private $notLike;
    public function setNotLike($notLike){$this->notLike=$notLike;}
    public function getNotLike(){return $this->notLike;}



    /**
     * @var string
     * @ORM\Column(name="clientIp", type="string")
     */
    protected $clientIp;
    /**
     * @param string $clientIp
     */
    public function setClientIp($clientIp){ $this->clientIp = $clientIp; }
    /**
     * @return string
     */
    public function getClientIp(){ return $this->clientIp; }



    /**
     * @var \DateTime
     */
    protected $createdAt;
    /**
     * Sets time this answer was created at.
     *
     * @param \DateTime $createdAt Time of creation
     * @return AnswerInterface
     */
    public function setCreatedAt(\DateTime $createdAt){
        $this->createdAt = $createdAt;
        return $this;
    }
    /**
     * Gets time this answer was created at.
     * @return \DateTime
     */
    public function getCreatedAt(){
        return $this->createdAt;
    }
}
