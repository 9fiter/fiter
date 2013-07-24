<?php

namespace Fiter\DefaultBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Fiter\DefaultBundle\Util\Util;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @ORM\HasLifecycleCallbacks()
 */
class Usuario extends BaseUser{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct(){
        parent::__construct();
        $this->aleatorio=!$this->aleatorio;
    }
    
    /**
     * @var boolean
     * @ORM\Column(name="aleatorio", type="boolean")
     */
    private $aleatorio;
    public function setAleatorio($aleatorio){$this->aleatorio=$aleatorio;}
    public function getAleatorio(){return $this->aleatorio;}
    /**
     * @Assert\File(maxSize="6000000")
     */
    private $imagen;
    
    /**
    * Set imagen
    *
    * @param UploadedFile $imagen
    * @return Articulo
    */
    public function setImagen(UploadedFile $imagen){
           $this->imagen = $imagen;
           return $this;
    }

    /**
    * Get imagen
    *
    * @return UploadedFile 
    * 
    */
    public function getImagen(){
           return $this->imagen;
    }
    
    /**
    * @ORM\Column(type="string", length=255, nullable=true)
    */
    private $path;
    
    /**
    * Set path
    *
    * @param string $path
    * @return Articulo
    */
    public function setPath($path){
            $this->path = $path;
            return $this;
    }

   /**
    * Get path
    *
    * @return string 
    */
    public function getPath(){
            return $this->path;
    }
    
    public function getAbsolutePath(){
	return null === $this->path
		? null
		: $this->getUploadRootDir().'/'.$this->path;
    }
    public function getWebPath(){
            return null === $this->path
                    ? null
                    : $this->getUploadDir().'/'.$this->path;
    }
    protected function getUploadRootDir(){
            // the absolute directory path where uploaded
            // documents should be saved
            return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }
    protected function getUploadDir(){
            return 'uploads/userimages';
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()    {
        if (null !== $this->imagen) {
            if ( $imagen = $this->getAbsolutePath() && file_exists($this->getAbsolutePath()) ) unlink($imagen); //borrar la imagen anterior si existe
            // do whatever you want to generate a unique name
            $filename = sha1(uniqid(mt_rand(), true));
            $this->path = $filename.'.'.$this->imagen->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload(){
        if (null === $this->imagen)  return;
        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->imagen->move($this->getUploadRootDir(), $this->path);
        unset($this->imagen);
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload(){
        if($this->getPath()!=""){
            if ($imagen = $this->getAbsolutePath()) 
                unlink($imagen); //borrar la imagen anterior si existe
        }
    } 
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}