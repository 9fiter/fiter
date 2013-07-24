<?php

namespace Fiter\DefaultBundle\Entity;

use Fiter\DefaultBundle\Util\Util;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Fiter\DefaultBundle\Entity\Usuario;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Medio
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Fiter\DefaultBundle\Entity\MedioRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Medio{
    
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="titulo", type="string", length=255)
     */
    private $titulo;

    /**
     * @var string
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var string
     * @ORM\Column(name="contenido", type="text")
     */
    private $contenido;
    
    /**
     * @var boolean
     * @ORM\Column(name="mostrarContenido", type="boolean")
     */
    private $mostrarContenido;
    public function setmostrarContenido($mostrarContenido){$this->mostrarContenido=$mostrarContenido;}
    public function getmostrarContenido(){return $this->mostrarContenido;}

    /**
     * @ORM\Column(name="fechaPublicacion", type="datetime")
     */
    private $fechaPublicacion;

    /**
     * @ORM\Column(name="fechaActualizacion", type="datetime")
     */
    private $fechaActualizacion;

    /**
     * @var boolean
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

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
     * @return Medio
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
     * @return Medio
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
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumn(name="usuario", referencedColumnName="id")
     */
    private $usuario;

    /**
     * @ORM\ManyToMany(targetEntity="Categoria", inversedBy="medios", cascade={"persist"})
     * @ORM\JoinTable(name="medio_categoria",
     * joinColumns={@ORM\JoinColumn(name="medio_id", referencedColumnName="id")},
     * inverseJoinColumns={@ORM\JoinColumn(name="categoria_id", referencedColumnName="id")}
     * )
     */
    private $categoria;

    /**
     * Get id
     * @return integer 
     */
    public function getId() { return $this->id; }

    /**
     * Set titulo
     * @param string $titulo
     * @return Medio
     */
    public function setTitulo($titulo) {
        $this->titulo = $titulo;
        return $this;
    }

    /**
     * Get titulo
     * @return string 
     */
    public function getTitulo() {
        return $this->titulo;
    }

    /**
     * Set slug
     * @param string $slug
     * @return Medio
     */
    public function setSlug($slug){
        $this->slug = $slug;
        return $this;
    }

    /**
     * Get slug
     * @return string 
     */
    public function getSlug() {
        return $this->slug;
    }

    /**
     * Set contenido
     * @param string $contenido
     * @return Medio
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
     * Set fechaPublicacion
     * @param \DateTime $fechaPublicacion
     * @return Medio
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
     * Set fechaActualizacion
     *
     * @param \DateTime $fechaActualizacion
     * @return Medio
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
     * Set activo
     * @param boolean $activo
     * @return Medio
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
     * Set visitas
     * @param integer $visitas
     * @return Medio
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
     * Set usuario
     * @param string $usuario
     * @return Medio
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
     * Set categoria
     * @param Fiter\DefaultBundle\Entity\Categoria $categoria
     * @return Medio
     */
    public function setCategoria(\Fiter\DefaultBundle\Entity\Categoria $categoria){
        $this->categoria[] = $categoria;
    }

    /**
     * Get categoria
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCategoria(){
        return $this->categoria;
    }
    
    private $noActualizar;
    
    public function __toString(){ return $this->getTitulo(); }
    
    public function __construct(){
        //$this->categoria="Sin categoría";
        $this->categoria = new \Doctrine\Common\Collections\ArrayCollection();
        $this->titulo="";
        $this->slug="sin-titulo";
        //$this->path="d7cce7ab70c708fe1c91df139a0333b4031357d8.jpeg";
        $this->activo=true;
        $this->likes=0;
        $this->disLikes=0;
        $this->visitas=0;
        $this->usuario="Anónimo";
        $this->fechaPublicacion=new \DateTime("now");
        $this->fechaActualizacion=new \DateTime("now");
        $this->aleatorio=!$this->aleatorio;
        $this->videosYoutube = new ArrayCollection();
        $this->listasYoutube = new ArrayCollection();
        $this->rss="";
        $this->noActualizar=false;
        $this->mostrarContenido=true;
    }
    
    /**
     * @ORM\PrePersist()
     */
    public function antesDePersistir(){
       $this->slug=Util::getSlug($this->titulo);
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
    * @return Medio
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
    * @return Medio
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
            return 'uploads/medios';
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()    {
        $this->slug=Util::getSlug($this->titulo);
        if($this->noActualizar==false) $this->setFechaActualizacion(new \DateTime("now"));
        //$this->descripcion = preg_replace('/<img[^>]+\>/is', '', $this->contenido); // eliminar las imagenes
        $this->contenido = Util::eliminarImgTags($this->contenido);                 // eliminar las imagenes
        if (null !== $this->imagen) {
            if ($imagen = $this->getAbsolutePath()) unlink($imagen); //borrar la imagen anterior si existe
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
            if ($imagen = $this->getAbsolutePath()) unlink($imagen);
        }
    }    
    
    /**
    * @ORM\ManyToMany(targetEntity="VideoYoutube", cascade={"persist"})
    * @ORM\JoinTable(name="medio_videoyoutube")
    */
    protected $videosYoutube;
    
    public function getVideosYoutube(){
        return $this->videosYoutube;
    }
    public function setVideosYoutube($videosYoutube){
        /*foreach ($videosYoutube as $videoYoutube) {
            $videoYoutube->addMedio($this);
        }*/
        $this->videosYoutube = $videosYoutube;
    }
    
    /**
    * @ORM\ManyToMany(targetEntity="ListaYoutube", cascade={"persist"})
    * @ORM\JoinTable(name="medio_listayoutube")
    */
    protected $listasYoutube;
    
    public function getListasYoutube(){
        return $this->listasYoutube;
    }
    public function setListasYoutube($listasYoutube){
        /*foreach ($listasYoutube as $listaYoutube) {
            $listaYoutube->addMedio($this);
        }*/
        $this->listasYoutube = $listasYoutube;
    }
    
    /**
     * @var string
     * @ORM\Column(name="canalYoutube", type="string", length=255, nullable=true)
     */
    private $canalYoutube;
    
    /**
     * Set canalYoutube
     * @param string $canalYoutube
     * @return Medio
     */
    public function setCanalYoutube($canalYoutube){
        $this->canalYoutube = $canalYoutube;
        return $this;
    }

    /**
     * Get canalYoutube
     * @return string 
     */
    public function getCanalYoutube(){
        return $this->canalYoutube;
    }
    
    /**
     * @var string
     * @ORM\Column(name="rss", type="string", length=255, nullable=true)
     */
    private $rss;
    
    /**
     * Set rss
     * @param string $rss
     * @return Medio
     */
    public function setRss($rss){
        $this->rss = $rss;
        return $this;
    }
    
    /**
     * Get rss
     * @return string 
     */
    public function getRss(){
        return $this->rss;
    }
    
    /**
     * @var string
     * @ORM\Column(name="twitter", type="string", length=255, nullable=true)
     */
    private $twitter;
    
    /**
     * Set twitter
     * @param string $twitter
     * @return Medio
     */
    public function setTwitter($twitter){
        $this->twitter = $twitter;
        return $this;
    }
    
    /**
     * Get twitter
     * @return string 
     */
    public function getTwitter(){
        return $this->twitter;
    }
    
}
