<?php

namespace Fiter\DefaultBundle\Entity;

use Fiter\DefaultBundle\Util\Util;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Fiter\DefaultBundle\Entity\Usuario;
use Fiter\PollBundle\Entity\Poll;
use Doctrine\Common\Collections\ArrayCollection;


use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;



/**
 * Articulo
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Fiter\DefaultBundle\Entity\ArticuloRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\TranslationEntity(class="Fiter\DefaultBundle\Entity\Translation\ArticuloTranslation")
 */
class Articulo{
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
     * @Gedmo\Translatable
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
     * @Gedmo\Translatable
     */
    private $contenido;

    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    private $locale;

    public function setTranslatableLocale($locale) { $this->locale = $locale; }












    /**
     * @ORM\OneToMany(
     *   targetEntity="Fiter\DefaultBundle\Entity\Translation\ArticuloTranslation",
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
     * @return Articulo
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
     * @return Articulo
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
     * @ORM\ManyToMany(targetEntity="Categoria", inversedBy="articulos", cascade={"persist"})
     * @ORM\JoinTable(name="articulo_categoria",
     * joinColumns={@ORM\JoinColumn(name="articulo_id", referencedColumnName="id")},
     * inverseJoinColumns={@ORM\JoinColumn(name="categoria_id", referencedColumnName="id")}
     * )
     */
    private $categoria;
    
    /**
     * Set categoria
     * @param Fiter\DefaultBundle\Entity\Categoria $categoria
     * @return Articulo
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








    /**
     * @ORM\ManyToMany(targetEntity="SubCategoria", inversedBy="articulos", cascade={"persist"})
     * @ORM\JoinTable(name="articulo_subcategoria",
     * joinColumns={@ORM\JoinColumn(name="articulo_id", referencedColumnName="id")},
     * inverseJoinColumns={@ORM\JoinColumn(name="subcategoria_id", referencedColumnName="id")}
     * )
     */
    private $subCategoria;
    
    /**
     * Set subCategoria
     * @param Fiter\DefaultBundle\Entity\Categoria $categoria
     * @return Articulo
     */
    public function setSubCategoria(\Fiter\DefaultBundle\Entity\SubCategoria $subCategoria){
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
     * Get id
     * @return integer 
     */
    public function getId(){
        return $this->id;
    }

    /**
     * Set titulo
     * @param string $titulo
     * @return Articulo
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
     * Set slug
     * @param string $slug
     * @return Articulo
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
     * Set contenido
     * @param string $contenido
     * @return Articulo
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
     * @return Articulo
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
     * @param \DateTime $fechaActualizacion
     * @return Articulo
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
     * @return Articulo
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
     * @return Articulo
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

    
    
    private $noActualizar;
    
    public function __toString(){ return $this->getTitulo(); }
    
    public function __construct(){
        //$this->categoria="Sin categoría";
        $this->categoria = new \Doctrine\Common\Collections\ArrayCollection();
        $this->subCategoria = new \Doctrine\Common\Collections\ArrayCollection();
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
        $this->listasYoutube = new ArrayCollection();
        $this->maps = new ArrayCollection();
        $this->noActualizar=false;
        $this->mostrarContenido=true;
        $this->mostrarImagen=true;
        $this->mostrarMiniaturas=true;
        $this->mostrarSlide=true;
        $this->translations = new ArrayCollection();
        $this->activarComentarios=true;

        
    }
    
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
            return 'uploads/documents';
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()    {
        $this->slug=Util::getSlug($this->titulo);
        if($this->noActualizar==false) $this->setFechaActualizacion(new \DateTime("now"));
        //$this->descripcion = preg_replace('/<img[^>]+\>/is', '', $this->contenido); // eliminar las imagenes
        //$this->contenido = Util::eliminarImgTags($this->contenido);                 // eliminar las imagenes
        if (null !== $this->imagen) {
            if (file_exists($this->getAbsolutePath())) unlink($this->getAbsolutePath()); //borrar la imagen anterior si existe
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
    * @ORM\JoinTable(name="articulo_videoyoutube")
    */
    protected $videosYoutube;
    
    public function getVideosYoutube(){
        return $this->videosYoutube;
    }
    public function setVideosYoutube($videosYoutube){
        /*foreach ($videosYoutube as $videoYoutube) {
            $videoYoutube->addArticulo($this);
        }*/
        $this->videosYoutube = $videosYoutube;
    }
    
    /**
    * @ORM\ManyToMany(targetEntity="ListaYoutube", cascade={"persist"})
    * @ORM\JoinTable(name="articulo_listayoutube")
    */
    protected $listasYoutube;
    
    public function getListasYoutube(){
        return $this->listasYoutube;
    }
    public function setListasYoutube($listasYoutube){
        /*foreach ($listasYoutube as $listaYoutube) {
            $listaYoutube->addArticulo($this);
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
     * @return Articulo
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
     * @return Articulo
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
     * @return Articulo
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
    




    /**
     * @ORM\ManyToOne(targetEntity="Fiter\PollBundle\Entity\Poll")
     * @ORM\JoinColumn(name="poll", referencedColumnName="id")
     */
    private $poll;
    /**
     * Set poll
     * @param string $poll
     * @return Articulo
     */
    public function setPoll($poll){
        $this->poll = $poll;
        return $this;
    }
    /**
     * Get poll
     * @return string 
     */
    public function getPoll(){
        return $this->poll;
    }











    /**
     * @ORM\ManyToOne(targetEntity="Fiter\DefaultBundle\Entity\Map")
     * @ORM\JoinColumn(name="map", referencedColumnName="id")
     */
    private $map;
    /**
     * Set map
     * @param string $map
     * @return Articulo
     */
    public function setMap($map){
        $this->map = $map;
        return $this;
    }
    /**
     * Get map
     * @return string 
     */
    public function getMap(){
        return $this->map;
    }




    /**
    * @ORM\ManyToMany(targetEntity="Fiter\DefaultBundle\Entity\Map", cascade={"persist"})
    * @ORM\JoinTable(name="articulo_map")
    */
    protected $maps;
    
    public function getMaps(){
        return $this->maps;
    }
    public function setMaps($maps){
        $this->maps = $maps;
    }







    /**
     * @var boolean
     * @ORM\Column(name="activarComentarios", type="boolean")
     */
    private $activarComentarios;
    public function setActivarComentarios($activarComentarios){$this->activarComentarios=$activarComentarios;}
    public function getActivarComentarios(){return $this->activarComentarios;}

    
}
