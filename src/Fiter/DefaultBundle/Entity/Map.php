<?php

namespace Fiter\DefaultBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;


/**
 * Map
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Fiter\DefaultBundle\Entity\MapRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Map{
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="Articulo", mappedBy="maps", cascade={"persist"})
     */
    private $articulos;
    
    public function __construct() {
        $this->articulos = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * @var string
     * @ORM\Column(name="lat", type="text")
     */
    private $lat;
    /**
     * Set lat
     * @param string $lat
     * @return Map
     */
    public function setLat($lat){
        $this->lat = $lat;
        return $this;
    }
    /**
     * Get lat
     * @return string 
     */
    public function getLat($length = null){
        if (false === is_null($length) && $length > 0)
             //return substr($this->lat, 0, $length);
             return Util::truncate($this->lat,400);
        else return $this->lat;
    }








    /**
     * @var string
     * @ORM\Column(name="lang", type="text")
     */
    private $lang;
    /**
     * Set lang
     * @param string $lang
     * @return Map
     */
    public function setLang($lang){
        $this->lang = $lang;
        return $this;
    }
    /**
     * Get lang
     * @return string 
     */
    public function getLang($length = null){
        if (false === is_null($length) && $length > 0)
             //return substr($this->lang, 0, $length);
             return Util::truncate($this->lang,400);
        else return $this->lang;
    }




    public function __toString(){
        return $this->getEnlace()."";
    }


    
    
    
}