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
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


}
