<?php

namespace Fiter\MinecraftSchematicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Fiter\DefaultBundle\Util\Util;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Fiter\DefaultBundle\Entity\Usuario;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Schematic
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="Fiter\MinecraftSchematicBundle\Entity\SchematicRepository")
 */
class Schematic{

    public function __toString(){ return $this->getTitulo(); }

    private $noActualizar;  

    public function __construct(){
        //$this->categoria="Sin categoría";
        //$this->categoria = new \Doctrine\Common\Collections\ArrayCollection();
        //$this->subCategoria = new \Doctrine\Common\Collections\ArrayCollection();
        $this->titulo="";
        $this->slug="sin-titulo";
        //$this->path="d7cce7ab70c708fe1c91df139a0333b4031357d8.jpeg";
        $this->activo=true;
        $this->likes=0;
        $this->disLikes=0;
        $this->visitas=0;
        //$this->usuario="Anónimo";
        $this->fechaPublicacion=new \DateTime("now");
        $this->fechaActualizacion=new \DateTime("now");
        $this->aleatorio=!$this->aleatorio;
        $this->videosYoutube = new ArrayCollection();
        //$this->listasYoutube = new ArrayCollection();
        //$this->maps = new ArrayCollection();
        $this->noActualizar=false;
        $this->mostrarContenido=true;
        $this->mostrarImagen=true;
        $this->mostrarMiniaturas=true;
        $this->mostrarSlide=true;
        $this->translations = new ArrayCollection();
        $this->activarComentarios=true;

        
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
     * @return integer 
     */
    public function getId(){
        return $this->id;
    }











    /**
     * @var string
     * @ORM\Column(name="titulo", type="string", length=255)
     */
    private $titulo;
    /**
     * Set titulo
     * @param string $titulo
     * @return Schematic
     */
    public function setTitulo($titulo){
        $this->titulo = $titulo;
    
        return $this;
    }
    /**
     * Get titulo
     * @return string 
     */
    public function getTitulo(){
        return $this->titulo;
    }







    /**
     * @var string
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;
    /**
     * Set slug
     * @param string $slug
     * @return Schematic
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
     * @var string
     * @ORM\Column(name="contenido", type="text")
     */
    private $contenido;
    /**
     * Set contenido
     * @param string $contenido
     * @return Schematic
     */
    public function setContenido($contenido){
        $this->contenido = $contenido;
        return $this;
    }
    /**
     * Get contenido
     * @return string 
     */
    public function getContenido($length = null){
        if (false === is_null($length) && $length > 0)
             //return substr($this->contenido, 0, $length);
             return Util::truncate($this->contenido,400);
        else return $this->contenido;
    }









    /**
     * @ORM\Column(name="fechaPublicacion", type="datetime")
     */
    private $fechaPublicacion;
    /**
     * Set fechaPublicacion
     * @param \DateTime $fechaPublicacion
     * @return Schematic
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
     * @return Schematic
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
     * @return Schematic
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
    public function incrementaVisitas(){
        $this->noActualizar=true;
        $this->visitas = $this->visitas+1;
        return $this;
    }
    /**
     * Set visitas
     * @param integer $visitas
     * @return Schematic
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
     * @var boolean
     * @ORM\Column(name="mostrarContenido", type="boolean")
     */
    private $mostrarContenido;
    public function setmostrarContenido($mostrarContenido){$this->mostrarContenido=$mostrarContenido;}
    public function getmostrarContenido(){return $this->mostrarContenido;}




    /**
     * @ORM\PrePersist()
     */
    public function antesDePersistir(){
       if ($this->slug== "sin-titulo") $this->slug=Util::getSlug($this->titulo);
    }

    /**
     * @var boolean
     * @ORM\Column(name="mostrarImagen", type="boolean")
     */
    private $mostrarImagen;
    public function setmostrarImagen($mostrarImagen){$this->mostrarImagen=$mostrarImagen;}
    public function getmostrarImagen(){return $this->mostrarImagen;}

    /**
     * @var boolean
     * @ORM\Column(name="mostrarMiniaturas", type="boolean")
     */
    private $mostrarMiniaturas;
    public function setmostrarMiniaturas($mostrarMiniaturas){$this->mostrarMiniaturas=$mostrarMiniaturas;}
    public function getmostrarMiniaturas(){return $this->mostrarMiniaturas;}

    /**
     * @var boolean
     * @ORM\Column(name="mostrarSlide", type="boolean")
     */
    private $mostrarSlide;
    public function setmostrarSlide($mostrarSlide){$this->mostrarSlide=$mostrarSlide;}
    public function getmostrarSlide(){return $this->mostrarSlide;}

    /**
     * @var boolean
     * @ORM\Column(name="activarComentarios", type="boolean")
     */
    private $activarComentarios;
    public function setActivarComentarios($activarComentarios){$this->activarComentarios=$activarComentarios;}
    public function getActivarComentarios(){return $this->activarComentarios;}




    /**
     * @var integer
     * @ORM\Column(name="likes", type="bigint")
     */
    private $likes;
    public function incrementaLikes(){
        $this->noActualizar=true;
        $this->likes = $this->likes+1;
        return $this;
    }
    /**
     * Set likes
     * @param integer $likes
     * @return Schematic
     */
    public function setLikes($likes){
        $this->likes = $likes;
        return $this;
    }
    /**
     * Get likes
     * @return integer 
     */
    public function getLikes(){
        return $this->likes;
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
     * @return Schematic
     */
    public function setDisLikes($disLikes){
        $this->disLikes = $disLikes;
        return $this;
    }
    /**
     * Get disLikes
     * @return integer 
     */
    public function getDisLikes(){
        return $this->disLikes;
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
    * @return Schematic
    */
    public function setImagen(UploadedFile $imagen){
       $this->imagen = $imagen;
       return $this;
    }
    /**
    * Get imagen
    * @return UploadedFile 
    */
    public function getImagen(){ return $this->imagen; }
    /**
    * @ORM\Column(type="string", length=255, nullable=true)
    */
    private $path;
    /**
    * Set path
    * @param string $path
    * @return Schematic
    */
    public function setPath($path){
        $this->path = $path;
        return $this;
    }
   /**
    * Get path
    * @return string 
    */
    public function getPath(){ return $this->path;}
    protected function getUploadDir(){ return 'uploads/documents/schematic';}
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

    public function getAbsolutePath(){
    return null === $this->path
        ? null
        : $this->getUploadRootDir().'/'.$this->path;
    }
    














    /**
     * @Assert\File(maxSize="6000000")
     */
    private $schematic;
    /**
    * Set imagen
    * @param UploadedFile $schematic
    * @return Schematic
    */
    public function setSchematic(UploadedFile $schematic){
       $this->schematic = $schematic;
       return $this;
    }
    /**
    * Get schematic
    * @return UploadedFile 
    */
    public function getSchematic(){ return $this->schematic; }
    /**
    * @ORM\Column(type="string", length=255, nullable=true)
    */
    private $pathSchematic;
    /**
    * Set pathSchematic
    * @param string $pathSchematic
    * @return Schematic
    */
    public function setPathSchematic($pathSchematic){
        $this->pathSchematic = $pathSchematic;
        return $this;
    }
   /**
    * Get path
    * @return string 
    */
    public function getPathSchematic(){ return $this->pathSchematic;}
    protected function getUploadDirSchematic(){ return 'uploads/schematics';}
    public function getWebPathSchematic(){
            return null === $this->pathSchematic
                    ? null
                    : $this->getUploadDirSchematic().'/'.$this->pathSchematic;
    }
    protected function getUploadRootDirSchematic(){
            // the absolute directory path where uploaded
            // documents should be saved
            return __DIR__.'/../../../../web/'.$this->getUploadDirSchematic();
    }
    public function getAbsolutePathSchematic(){
    return null === $this->pathSchematic
        ? null
        : $this->getUploadRootDirSchematic().'/'.$this->pathSchematic;
    }











    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()    {
        $this->slug=Util::getSlug($this->titulo);
        if($this->noActualizar==false) $this->setFechaActualizacion(new \DateTime("now"));

        if (null !== $this->imagen) {
            if (file_exists($this->getAbsolutePath())) unlink($this->getAbsolutePath()); //borrar la imagen anterior si existe
            $filename = sha1(uniqid(mt_rand(), true));
            $this->path = $filename.'.'.$this->imagen->guessExtension();
        }

        if (null !== $this->schematic) {
            if (file_exists($this->getAbsolutePathSchematic())) unlink($this->getAbsolutePathSchematic()); //borrar el schematic anterior si existe
            $filename = sha1(uniqid(mt_rand(), true));
            //$this->pathSchematic = $filename.'.'.$this->schematic->guessExtension();
            //ladybug_dump($this->schematic);
            $this->pathSchematic = $filename.'_'.$this->schematic->getClientOriginalName();
        }
    }
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload(){
        if (null !== $this->imagen) {
            $this->imagen->move($this->getUploadRootDir(), $this->path);
            unset($this->imagen);
        }
        if (null !== $this->schematic) {
            $this->schematic->move($this->getUploadRootDirSchematic(), $this->pathSchematic);
            unset($this->schematic);
        }
    }
    /**
     * @ORM\PostRemove()
     */
    public function removeUpload(){
        if($this->getPath()!=""){
            if ($imagen = $this->getAbsolutePath()) unlink($imagen);
        }

        if($this->getPathSchematic()!=""){
            if ($schematic = $this->getAbsolutePathSchematic()) unlink($schematic);
        }
    }    
    
  


    

}
