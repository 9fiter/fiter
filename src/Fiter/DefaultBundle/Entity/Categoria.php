<?php

namespace Fiter\DefaultBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Fiter\DefaultBundle\Entity\Usuario;
use Fiter\DefaultBundle\Util\Util;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

/**
 * Categoria
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Fiter\DefaultBundle\Entity\CategoriaRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\TranslationEntity(class="Fiter\DefaultBundle\Entity\Translation\CategoriaTranslation")
 */
class Categoria{

    public function __toString(){ return $this->getNombre(); }
    
    public function __construct(){
        $this->subCategoria = new \Doctrine\Common\Collections\ArrayCollection();
        $this->nombre="";
        $this->slug="sin-titulo";
        $this->fechaPublicacion=new \DateTime("now");
        $this->fechaActualizacion=new \DateTime("now");
        $this->orden = 0;
        $this->activo=true;
        $this->likes=0;
        $this->disLikes=0;
        $this->visitas=0;
        $this->usuario="Anónimo";
        $this->aleatorio=!$this->aleatorio;
        $this->noActualizar=false;
        $this->translations = new ArrayCollection();
    }

    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId(){
        return $this->id;
    } 


    /**
     * @ORM\ManyToMany(targetEntity="Articulo", mappedBy="categoria", cascade={"persist"})
     */
    private $articulos;
    /**
     * Add articulos
     * @param Fiter\DefaultBundle\Entity\Articulo $articulos
     */
    public function addArticulos(\Fiter\DefaultBundle\Entity\Articulo $articulos){
        $this->articulos[] = $articulos;
    }
    /**
     * Get articulos
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getArticulos(){
        return $this->articulos;
    }
    


    /** 
    * @ORM\OneToMany(targetEntity="Fiter\DefaultBundle\Entity\SubCategoria", mappedBy="categoria", cascade={"persist", "remove"} )
    * @ORM\OrderBy({"orden" = "DESC", "id" = "DESC"})
    */
    protected $subCategoria;
    /**
    * Add subCategoria
    * @param Fiter\DefaultBundle\Entity\SubCategoria $subCategoria
    */
    public function addsubCategoria(\Fiter\DefaultBundle\Entity\SubCategoria $subCategoria){
        $this->subCategoria[] = $subCategoria;
    }
    /**
    * Get subCategoria
    * @return Doctrine\Common\Collections\Collection 
    */
    public function getSubCategoria(){
        return $this->subCategoria;
    }
    /**
     * Set subCategoria
     * @param string $subCategoria
     * @return Categoria
     */
    public function setSubCategoria($subCategoria){
        $this->subCategoria = $subCategoria;
        return $this;
    }


    /**
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumn(name="usuario", referencedColumnName="id")
     */
    private $usuario;
    /**
     * Set usuario
     * @param string $usuario
     * @return Categoria
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
     * @var string
     * @ORM\Column(name="nombre", type="string", length=255)
     * @Gedmo\Translatable
     */
    private $nombre;
    /**
     * Set nombre
     * @param string $nombre
     * @return Categoria
     */
    public function setNombre($nombre){
        $this->nombre = $nombre;
        $this->slug = Util::getSlug($nombre);
        return $this;
    }
    /**
     * Get nombre
     * @return string 
     */
    public function getNombre(){ return $this->nombre; }

    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    private $locale;

    public function setTranslatableLocale($locale) { $this->locale = $locale; }
        

    /**
     * @ORM\OneToMany(
     *   targetEntity="Fiter\DefaultBundle\Entity\Translation\CategoriaTranslation",
     *   mappedBy="object",
     *   cascade={"persist", "remove"}
     * )
     */
    private $translations;
    public function getTranslations(){ return $this->translations; }
    //public function addTranslation(Fiter\DefaultBundle\Entity\Translation\ArticuloTranslation $t){
    public function addTranslation($t){
        if (!$this->translations->contains($t)) {
            $this->translations[] = $t;
            $t->setObject($this);
        }
    }
    public function removeTranslation($t){
        
    }






    /**
     * @var string
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;
    /**
     * Set slug
     * @param string $slug
     * @return Categoria
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
     * @var \DateTime
     * @ORM\Column(name="fechaPublicacion", type="datetime")
     */
    private $fechaPublicacion;
    /**
     * Set fechaPublicacion
     * @param \DateTime $fechaPublicacion
     * @return Categoria
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
     * @var \DateTime
     * @ORM\Column(name="fechaActualizacion", type="datetime")
     */
    private $fechaActualizacion;
    /**
     * Set fechaActualizacion
     * @param \DateTime $fechaActualizacion
     * @return Categoria
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
     * @return Categoria
     */
    public function setActivo($activo){
        $this->activo = $activo;
        return $this;
    }
    /**
     * Get activo
     * @return boolean 
     */
    public function getActivo(){
        return $this->activo;
    }




    /**
     * @var integer
     * @ORM\Column(name="visitas", type="bigint")
     */
    private $visitas;
    /**
     * Set visitas
     * @param integer $visitas
     * @return Categoria
     */
    public function setVisitas($visitas){
        $this->visitas = $visitas;
        return $this;
    }
    /**
     * Get visitas
     * @return integer 
     */
    public function getVisitas(){
        return $this->visitas;
    }
    public function incrementaVisitas(){
        $this->noActualizar=true;
        $this->visitas = $this->visitas+1;
        return $this;
    }


    private $noActualizar;


    /**
     * @var integer
     * @ORM\Column(name="likes", type="bigint")
     */
    private $likes;
    /**
     * Set likes
     * @param integer $likes
     * @return Categoria
     */
    public function setLikes($likes){
        $this->likes = $likes;
        return $this;
    }
    /**
     * Get likes
     * @return integer 
     */
    public function getLikes() {
        return $this->likes;
    }
    public function incrementaLikes(){
        $this->noActualizar=true;
        $this->likes = $this->likes+1;
        return $this;
    }




    /**
     * @var integer
     * @ORM\Column(name="disLikes", type="bigint")
     */
    private $disLikes;
    public function incrementaDisLikes(){
        $this->noActualizar=true;
        $this->disLikes = $this->disLikes+1;
        return $this;
    }    
    /**
     * Set disLikes
     * @param integer $disLikes
     * @return Categoria
     */
    public function setDisLikes($disLikes){
        $this->disLikes = $disLikes;
        return $this;
    }
    /**
     * Get disLikes
     * @return integer 
     */
    public function getDisLikes() {
        return $this->disLikes;
    }



    /**
     * @var integer
     * @ORM\Column(name="orden", type="integer")
     */
    private $orden;
    /**
     * Set orden
     * @param integer $orden
     * @return Categoria
     */
    public function setOrden($orden){
        $this->orden = $orden;
        return $this;
    }
    /**
     * Get orden
     * @return integer 
     */
    public function getOrden(){
        return $this->orden;
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
    * @return Articulo
    */
    public function setImagen(UploadedFile $imagen){
           $this->imagen = $imagen;
           return $this;
    }
    /**
    * Get imagen
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
            return 'uploads/categoriaimages';
    }







    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()    {
        if($this->noActualizar==false) $this->setFechaActualizacion(new \DateTime("now"));
        if (null !== $this->imagen) {
            if ($imagen = $this->getAbsolutePath() && file_exists($this->getAbsolutePath()) ) unlink($imagen); //borrar la imagen anterior si existe
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
            if ($imagen = $this->getAbsolutePath()) unlink($imagen); //borrar la imagen anterior si existe
        }
    } 
}
