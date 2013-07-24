<?php

namespace Fiter\DefaultBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;


/**
 * VideoYoutube
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Fiter\DefaultBundle\Entity\VideoYoutubeRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class VideoYoutube{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\ManyToMany(targetEntity="Articulo", mappedBy="videosYoutube", cascade={"persist"})
     */
    private $articulos;
    
    public function __construct() {
        $this->articulos = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * @var string
     *
     * @ORM\Column(name="enlace", type="string", length=255, nullable=false)
     * @Assert\Regex("/^(http|https)://\w{0,3}.?youtube+\.\w{2,3}/watch\?.{0,250}v=[\w-]{11}/")
     */
    private $enlace;
    
    /**
     * Set enlace
     *
     * @param string $enlace
     * @return VideoYoutube
     */
    public function setEnlace($enlace){
        $this->enlace = $enlace;
        return $this;
    }

    /**
     * Get enlace
     *
     * @return string 
     */
    public function getEnlace(){
        return $this->enlace;
    }
    
    public function getArticulos(){
        return $this->articulos;
    }
    public function setArticulos($articulos){
        $this->articulo = $articulos;
        return $this;
    }
    public function addArticulo(Articulo $articulo){
        if (!$this->articulos->contains($articulo)) {
            
            $this->articulos->add($articulo);
        }
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId(){
        return $this->id;
    }
    public function __toString(){
        return $this->getEnlace()."";
    }
}