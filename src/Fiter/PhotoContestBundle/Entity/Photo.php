<?php

namespace Fiter\PhotoContestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;



use Fiter\DefaultBundle\Util\Util;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Photo
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Fiter\PhotoContestBundle\Entity\PhotoRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Photo{

    public function __toString(){ return $this->getTitulo(); }
    
    public function __construct(){
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
        $this->activarComentarios=true;
        $this->contest = new \Doctrine\Common\Collections\ArrayCollection();
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
    public function getId(){ return $this->id; }



    /**
     * @var string
     * @ORM\Column(name="titulo", type="string", length=255)
     */
    private $titulo;
    /**
     * Set titulo
     * @param string $titulo
     * @return Photo
     */
    public function setTitulo($titulo){
        $this->titulo = $titulo;    
        return $this;
    }
    /**
     * Get titulo
     * @return string 
     */
    public function getTitulo(){ return $this->titulo; }



    /**
     * @var string
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;
    /**
     * Set slug
     * @param string $slug
     * @return Photo
     */
    public function setSlug($slug){
        $this->slug = $slug;
        return $this;
    }
    /**
     * Get slug
     * @return string 
     */
    public function getSlug(){ return $this->slug; }



    /**
     * @var string
     * @ORM\Column(name="descripcion", type="text")
     */
    private $descripcion;
    /**
     * Set descripcion
     * @param string $descripcion
     * @return Photo
     */
    public function setDescripcion($descripcion){
        $this->descripcion = $descripcion;
        return $this;
    }


    /**
     * Get descripcion
     * @return string 
     */
    public function getDescripcion($length = null){
        if (false === is_null($length) && $length > 0)
             //return substr($this->contenido, 0, $length);
             return Util::truncate($this->descripcion,400);
        else return $this->descripcion;
    }



    /**
     * @var \DateTime
     * @ORM\Column(name="fechaPublicacion", type="datetime")
     */
    private $fechaPublicacion;
    /**
     * Set fechaPublicacion
     * @param \DateTime $fechaPublicacion
     * @return Photo
     */
    public function setFechaPublicacion($fechaPublicacion){
        $this->fechaPublicacion = $fechaPublicacion;
        return $this;
    }
    /**
     * Get fechaPublicacion
     * @return \DateTime 
     */
    public function getFechaPublicacion(){ return $this->fechaPublicacion; }



    /**
     * @var \DateTime
     * @ORM\Column(name="fechaActualizacion", type="datetime")
     */
    private $fechaActualizacion;
    /**
     * Set fechaActualizacion
     * @param \DateTime $fechaActualizacion
     * @return Photo
     */
    public function setFechaActualizacion($fechaActualizacion){
        $this->fechaActualizacion = $fechaActualizacion;
        return $this;
    }
    /**
     * Get fechaActualizacion
     * @return \DateTime 
     */
    public function getFechaActualizacion(){ return $this->fechaActualizacion; }



    /**
     * @var boolean
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;
    /**
     * Set activo
     * @param boolean $activo
     * @return Photo
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
     * @var integer
     * @ORM\Column(name="visitas", type="bigint")
     */
    private $visitas;
    /**
     * Set visitas
     * @param integer $visitas
     * @return Photo
     */
    public function setVisitas($visitas){
        $this->visitas = $visitas;
        return $this;
    }
    /**
     * Get visitas
     * @return integer 
     */
    public function getVisitas(){ return $this->visitas; }
    public function incrementaVisitas(){
        $this->noActualizar=true;
        $this->visitas = $this->visitas+1;
        return $this;
    }



    /**
     * @var integer
     * @ORM\Column(name="likes", type="bigint")
     */
    private $likes;
    /**
     * Set likes
     * @param integer $likes
     * @return Photo
     */
    public function setLikes($likes){
        $this->likes = $likes;
        return $this;
    }
    /**
     * Get likes
     * @return integer 
     */
    public function getLikes(){ return $this->likes; }
    
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
    /**
     * Set disLikes
     * @param integer $disLikes
     * @return Photo
     */
    public function setDisLikes($disLikes){
        $this->disLikes = $disLikes;
        return $this;
    }
    /**
     * Get disLikes
     * @return integer 
     */
    public function getDisLikes(){ return $this->disLikes; }
    public function incrementaDisLikes(){
        $this->noActualizar=true;
        $this->disLikes = $this->disLikes+1;
        return $this;
    }


    /**
     * @var string
     * @ORM\Column(name="usuario", type="string", length=255)
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
    public function getUsuario(){ return $this->usuario; }



    /**
     * @var boolean
     * @ORM\Column(name="aleatorio", type="boolean")
     */
    private $aleatorio;
    /**
     * Set aleatorio
     * @param boolean $aleatorio
     * @return Photo
     */
    public function setAleatorio($aleatorio){
        $this->aleatorio = $aleatorio;
        return $this;
    }
    /**
     * Get aleatorio
     * @return boolean 
     */
    public function getAleatorio(){ return $this->aleatorio; }

    /**
     * @var boolean
     * @ORM\Column(name="activarComentarios", type="boolean")
     */
    private $activarComentarios;
    /**
     * Set activarComentarios
     * @param boolean $activarComentarios
     * @return Photo
     */
    public function setActivarComentarios($activarComentarios){
        $this->activarComentarios = $activarComentarios;
        return $this;
    }
    /**
     * Get activarComentarios
     * @return boolean 
     */
    public function getActivarComentarios(){ return $this->activarComentarios; }



    private $noActualizar;


    /**
     * @Assert\File(maxSize="6000000")
     */
    private $imagen;
    /**
    * Set imagen
    * @param UploadedFile $imagen
    * @return Photo
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
    * @return Photo
    */
    public function setPath($path){
            $this->path = $path;
            return $this;
    }
   /**
    * Get path
    * @return string 
    */
    public function getPath(){ return $this->path; }
    


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
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }
    protected function getUploadDir(){ return 'uploads/photoContest'; }






    /**
     * @ORM\PrePersist()
     */
    public function antesDePersistir(){
       if ($this->slug== "sin-titulo") $this->slug=Util::getSlug($this->titulo);
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
    }
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload(){
        if (null === $this->imagen)  return;
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






    /**
     * @ORM\ManyToMany(targetEntity="Contest", inversedBy="photos", cascade={"persist"})
     * @ORM\JoinTable(name="photo_contest",
     * joinColumns={@ORM\JoinColumn(name="photo_id", referencedColumnName="id")},
     * inverseJoinColumns={@ORM\JoinColumn(name="contest_id", referencedColumnName="id")}
     * )
     */
    private $contest;
    /**
     * Set contest
     * @param Fiter\PhotoContestBundle\Entity\Contest $contest
     * @return Photo
     */
    public function setContest($contest){
        $this->contest[] = $contest;
    }
    /**
     * Get contest
     * @return Fiter\PhotoContestBundle\Entity\Contest
     */
    public function getContest(){
        return $this->contest;
    }









}
