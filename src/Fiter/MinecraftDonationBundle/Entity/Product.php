<?php

namespace Fiter\MinecraftDonationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Fiter\DefaultBundle\Util\Util;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Product
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Fiter\MinecraftDonationBundle\Entity\ProductRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Product{
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=255)
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var integer
     *
     * @ORM\Column(name="stocklimit", type="bigint")
     */
    private $stocklimit;

    /**
     * @var integer
     *
     * @ORM\Column(name="expiresin", type="bigint")
     */
    private $expiresin;

    /**
     * @var integer
     *
     * @ORM\Column(name="userlimit", type="bigint")
     */
    private $userlimit;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     * @return string 
     */
    public function getDescription($length = null){
        if (false === is_null($length) && $length > 0)
             //return substr($this->description, 0, $length);
             return Util::truncate($this->description,400);
        else return $this->description;
    }


    /**
     * Set category
     *
     * @param string $category
     * @return Product
     */
    public function setCategory($category)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return string 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;
    
        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set stocklimit
     *
     * @param integer $stocklimit
     * @return Product
     */
    public function setStocklimit($stocklimit)
    {
        $this->stocklimit = $stocklimit;
    
        return $this;
    }

    /**
     * Get stocklimit
     *
     * @return integer 
     */
    public function getStocklimit()
    {
        return $this->stocklimit;
    }

    /**
     * Set expiresin
     *
     * @param integer $expiresin
     * @return Product
     */
    public function setExpiresin($expiresin)
    {
        $this->expiresin = $expiresin;
    
        return $this;
    }

    /**
     * Get expiresin
     *
     * @return integer 
     */
    public function getExpiresin()
    {
        return $this->expiresin;
    }

    /**
     * Set userlimit
     *
     * @param integer $userlimit
     * @return Product
     */
    public function setUserlimit($userlimit)
    {
        $this->userlimit = $userlimit;
    
        return $this;
    }

    /**
     * Get userlimit
     *
     * @return integer 
     */
    public function getUserlimit()
    {
        return $this->userlimit;
    }























    /**
 * @var string
 * @ORM\Column(name="slug", type="string", length=255)
 */
private $slug;
 /**
 * Set slug
 * @param string $slug
 * @return Product
 */
public function setSlug($slug){
    $this->slug = $slug;
    return $this;
}
/**
 * Get slug
 * @return string 
 */
public function getSlug(){
    return $this->slug;
}



/**
 * @ORM\Column(name="fechaPublicacion", type="datetime")
 */
private $fechaPublicacion;
/**
 * Set fechaPublicacion
 * @param \DateTime $fechaPublicacion
 * @return Product
 */
public function setFechaPublicacion($fechaPublicacion){
    $this->fechaPublicacion = $fechaPublicacion;
    return $this;
}
/**
 * Get fechaPublicacion
 * @return \DateTime 
 */
public function getFechaPublicacion(){
    return $this->fechaPublicacion;
}




/**
 * @ORM\Column(name="fechaActualizacion", type="datetime")
 */
private $fechaActualizacion;
/**
 * Set fechaActualizacion
 * @param \DateTime $fechaActualizacion
 * @return Product
 */
public function setFechaActualizacion($fechaActualizacion){
    $this->fechaActualizacion = $fechaActualizacion;
    return $this;
}
/**
 * Get fechaActualizacion
 * @return \DateTime 
 */
public function getFechaActualizacion(){
    return $this->fechaActualizacion;
}




/**
 * @var boolean
 * @ORM\Column(name="activo", type="boolean")
 */
private $activo;
/**
 * Set activo
 * @param boolean $activo
 * @return Product
 */
public function setActivo($activo){
    $this->activo = $activo;
    return $this;
}
/**
 * Get activo
 * @return boolean 
 */
public function getActivo(){ return $this->activo; }





 /**
 * @var boolean
 * @ORM\Column(name="mostrarImagen", type="boolean")
 */
private $mostrarImagen;
public function setmostrarImagen($mostrarImagen){$this->mostrarImagen=$mostrarImagen;}
public function getmostrarImagen(){return $this->mostrarImagen;}









private $noActualizar;
    
public function __toString(){ return $this->getName(); }

public function __construct(){
    $this->name="";
    $this->category="";
    $this->stocklimit=0;
    $this->userlimit=0;
    
    $this->slug="sin-titulo";
    //$this->path="d7cce7ab70c708fe1c91df139a0333b4031357d8.jpeg";
    $this->activo=true;
    $this->fechaPublicacion=new \DateTime("now");
    $this->fechaActualizacion=new \DateTime("now");
    $this->aleatorio=!$this->aleatorio;
    $this->noActualizar=false;
    $this->mostrarImagen=true;
    $this->expiresin=30;
}

/**
 * @ORM\PrePersist()
 */
public function antesDePersistir(){
   if ($this->slug== "sin-titulo") $this->slug=Util::getSlug($this->name);
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
* @param UploadedFile $imagen
* @return Product
*/
public function setImagen(UploadedFile $imagen){
       $this->imagen = $imagen;
       return $this;
}

/**
* Get imagen
* @return UploadedFile 
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
* @param string $path
* @return Product
*/
public function setPath($path){
        $this->path = $path;
        return $this;
}

/**
* Get path
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
        return 'uploads/products';
}

/**
 * @ORM\PrePersist()
 * @ORM\PreUpdate()
 */
public function preUpload()    {
    $this->slug=Util::getSlug($this->name);
    if($this->noActualizar==false) $this->setFechaActualizacion(new \DateTime("now"));
    if (null !== $this->imagen) {
        if (file_exists($this->getAbsolutePath())) unlink($this->getAbsolutePath()); 
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
        if ($imagen = $this->getAbsolutePath()) unlink($imagen);
    }
}





}
