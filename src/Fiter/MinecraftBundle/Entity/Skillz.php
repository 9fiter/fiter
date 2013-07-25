<?php

namespace Fiter\MinecraftBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Skillz
 *
 * @ORM\Table(name="Skillz")
 * @ORM\Entity
 */
class Skillz
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
     * @ORM\Column(name="player", type="string", length=255, nullable=true)
     */
    private $player;

    /**
     * @var string
     *
     * @ORM\Column(name="skill", type="string", length=255, nullable=true)
     */
    private $skill;

    /**
     * @var integer
     *
     * @ORM\Column(name="xp", type="integer", nullable=true)
     */
    private $xp;

    /**
     * @var integer
     *
     * @ORM\Column(name="level", type="integer", nullable=true)
     */
    private $level;



    /**
     * Set player
     *
     * @param string $player
     * @return Skillz
     */
    public function setPlayer($player)
    {
        $this->player = $player;
    
        return $this;
    }

    /**
     * Get player
     *
     * @return string 
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * Set skill
     *
     * @param string $skill
     * @return Skillz
     */
    public function setSkill($skill)
    {
        $this->skill = $skill;
    
        return $this;
    }

    /**
     * Get skill
     *
     * @return string 
     */
    public function getSkill()
    {
        return $this->skill;
    }

    /**
     * Set xp
     *
     * @param integer $xp
     * @return Skillz
     */
    public function setXp($xp)
    {
        $this->xp = $xp;
    
        return $this;
    }

    /**
     * Get xp
     *
     * @return integer 
     */
    public function getXp()
    {
        return $this->xp;
    }

    /**
     * Set level
     *
     * @param integer $level
     * @return Skillz
     */
    public function setLevel($level)
    {
        $this->level = $level;
    
        return $this;
    }

    /**
     * Get level
     *
     * @return integer 
     */
    public function getLevel()
    {
        return $this->level;
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