<?php

namespace Fiter\PhotoContestBundle\Entity;

use Fiter\DefaultBundle\Util\Util;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * PhotoLike
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Fiter\PhotoContestBundle\Entity\PhotoLikeRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class PhotoLike{
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;



    /**
     * @var string
     * @ORM\Column(name="usuario", type="string")
     */
    private $usuario;
    /**
     * Set usuario
     * @param string $usuario
     * @return Photo
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
     * @ORM\ManyToOne(targetEntity="Photo")
     * @ORM\JoinColumn(name="photo", referencedColumnName="id")
     */
    private $photo;
    /**
     * Set photo
     * @param string $photo
     * @return Photo
     */
    public function setPhoto($photo){
        $this->photo = $photo;
        return $this;
    }
    /**
     * Get photo
     * @return string 
     */
    public function getPhoto(){
        return $this->photo;
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
