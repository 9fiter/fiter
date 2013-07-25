<?php

namespace Fiter\MinecraftAuthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Authme
 *
 * @ORM\Table(name="authme")
 * @ORM\Entity
 */
class Authme
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=40, nullable=false)
     */
    private $ip;

    /**
     * @var integer
     *
     * @ORM\Column(name="lastlogin", type="bigint", nullable=true)
     */
    private $lastlogin;

    /**
     * @var integer
     *
     * @ORM\Column(name="x", type="smallint", nullable=true)
     */
    private $x;

    /**
     * @var integer
     *
     * @ORM\Column(name="y", type="smallint", nullable=true)
     */
    private $y;

    /**
     * @var integer
     *
     * @ORM\Column(name="z", type="smallint", nullable=true)
     */
    private $z;

    /**
     * @var string
     *
     * @ORM\Column(name="world", type="string", length=255, nullable=true)
     */
    private $world;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="countryCode", type="string", length=255, nullable=true)
     */
    private $countrycode;

    /**
     * @var string
     *
     * @ORM\Column(name="countryCode3", type="string", length=255, nullable=true)
     */
    private $countrycode3;

    /**
     * @var string
     *
     * @ORM\Column(name="countryName", type="string", length=255, nullable=true)
     */
    private $countryname;

    /**
     * @var string
     *
     * @ORM\Column(name="region", type="string", length=255, nullable=true)
     */
    private $region;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="postalCode", type="string", length=255, nullable=true)
     */
    private $postalcode;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="string", length=255, nullable=true)
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="string", length=255, nullable=true)
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="areaCode", type="string", length=255, nullable=true)
     */
    private $areacode;

    /**
     * @var string
     *
     * @ORM\Column(name="metroCode", type="string", length=255, nullable=true)
     */
    private $metrocode;

    /**
     * @var string
     *
     * @ORM\Column(name="continentCode", type="string", length=255, nullable=true)
     */
    private $continentcode;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var integer
     *
     * @ORM\Column(name="skin", type="integer", nullable=false)
     */
    private $skin;

    /**
     * @var boolean
     *
     * @ORM\Column(name="premium", type="boolean", nullable=false)
     */
    private $premium;



    /**
     * Set username
     *
     * @param string $username
     * @return Authme
     */
    public function setUsername($username)
    {
        $this->username = $username;
    
        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Authme
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set ip
     *
     * @param string $ip
     * @return Authme
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    
        return $this;
    }

    /**
     * Get ip
     *
     * @return string 
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set lastlogin
     *
     * @param integer $lastlogin
     * @return Authme
     */
    public function setLastlogin($lastlogin)
    {
        $this->lastlogin = $lastlogin;
    
        return $this;
    }

    /**
     * Get lastlogin
     *
     * @return integer 
     */
    public function getLastlogin()
    {
        return $this->lastlogin;
    }

    /**
     * Set x
     *
     * @param integer $x
     * @return Authme
     */
    public function setX($x)
    {
        $this->x = $x;
    
        return $this;
    }

    /**
     * Get x
     *
     * @return integer 
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * Set y
     *
     * @param integer $y
     * @return Authme
     */
    public function setY($y)
    {
        $this->y = $y;
    
        return $this;
    }

    /**
     * Get y
     *
     * @return integer 
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * Set z
     *
     * @param integer $z
     * @return Authme
     */
    public function setZ($z)
    {
        $this->z = $z;
    
        return $this;
    }

    /**
     * Get z
     *
     * @return integer 
     */
    public function getZ()
    {
        return $this->z;
    }

    /**
     * Set world
     *
     * @param string $world
     * @return Authme
     */
    public function setWorld($world)
    {
        $this->world = $world;
    
        return $this;
    }

    /**
     * Get world
     *
     * @return string 
     */
    public function getWorld()
    {
        return $this->world;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Authme
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set countrycode
     *
     * @param string $countrycode
     * @return Authme
     */
    public function setCountrycode($countrycode)
    {
        $this->countrycode = $countrycode;
    
        return $this;
    }

    /**
     * Get countrycode
     *
     * @return string 
     */
    public function getCountrycode()
    {
        return $this->countrycode;
    }

    /**
     * Set countrycode3
     *
     * @param string $countrycode3
     * @return Authme
     */
    public function setCountrycode3($countrycode3)
    {
        $this->countrycode3 = $countrycode3;
    
        return $this;
    }

    /**
     * Get countrycode3
     *
     * @return string 
     */
    public function getCountrycode3()
    {
        return $this->countrycode3;
    }

    /**
     * Set countryname
     *
     * @param string $countryname
     * @return Authme
     */
    public function setCountryname($countryname)
    {
        $this->countryname = $countryname;
    
        return $this;
    }

    /**
     * Get countryname
     *
     * @return string 
     */
    public function getCountryname()
    {
        return $this->countryname;
    }

    /**
     * Set region
     *
     * @param string $region
     * @return Authme
     */
    public function setRegion($region)
    {
        $this->region = $region;
    
        return $this;
    }

    /**
     * Get region
     *
     * @return string 
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Authme
     */
    public function setCity($city)
    {
        $this->city = $city;
    
        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set postalcode
     *
     * @param string $postalcode
     * @return Authme
     */
    public function setPostalcode($postalcode)
    {
        $this->postalcode = $postalcode;
    
        return $this;
    }

    /**
     * Get postalcode
     *
     * @return string 
     */
    public function getPostalcode()
    {
        return $this->postalcode;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     * @return Authme
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    
        return $this;
    }

    /**
     * Get latitude
     *
     * @return string 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     * @return Authme
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    
        return $this;
    }

    /**
     * Get longitude
     *
     * @return string 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set areacode
     *
     * @param string $areacode
     * @return Authme
     */
    public function setAreacode($areacode)
    {
        $this->areacode = $areacode;
    
        return $this;
    }

    /**
     * Get areacode
     *
     * @return string 
     */
    public function getAreacode()
    {
        return $this->areacode;
    }

    /**
     * Set metrocode
     *
     * @param string $metrocode
     * @return Authme
     */
    public function setMetrocode($metrocode)
    {
        $this->metrocode = $metrocode;
    
        return $this;
    }

    /**
     * Get metrocode
     *
     * @return string 
     */
    public function getMetrocode()
    {
        return $this->metrocode;
    }

    /**
     * Set continentcode
     *
     * @param string $continentcode
     * @return Authme
     */
    public function setContinentcode($continentcode)
    {
        $this->continentcode = $continentcode;
    
        return $this;
    }

    /**
     * Get continentcode
     *
     * @return string 
     */
    public function getContinentcode()
    {
        return $this->continentcode;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Authme
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set skin
     *
     * @param integer $skin
     * @return Authme
     */
    public function setSkin($skin)
    {
        $this->skin = $skin;
    
        return $this;
    }

    /**
     * Get skin
     *
     * @return integer 
     */
    public function getSkin()
    {
        return $this->skin;
    }

    /**
     * Set premium
     *
     * @param boolean $premium
     * @return Authme
     */
    public function setPremium($premium)
    {
        $this->premium = $premium;
    
        return $this;
    }

    /**
     * Get premium
     *
     * @return boolean 
     */
    public function getPremium()
    {
        return $this->premium;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}