<?php

namespace Fiter\MinecraftAuthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Jobs
 *
 * @ORM\Entity
 * @ORM\Table(name="jobs_jobs")
 */
class Jobs{

    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
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
     * @ORM\Column(name="username", type="string", length=20, nullable=false)
     */
    private $username;
    /**
     * Set username
     * @param string $username
     * @return Authme
     */
    public function setUsername($username){
        $this->username = $username;
        return $this;
    }
    /**
     * Get username
     * @return string 
     */
    public function getUsername(){
        return $this->username;
    }


    /**
     * @var integer
     *
     * @ORM\Column(name="experience", type="integer", nullable=true)
     */
    private $experience;
    /**
     * Set experience
     * @param stringinteger $experience
     * @return Authme
     */
    public function setExperience($experience){
        $this->experience = $experience;
        return $this;
    }
    /**
     * Get experience
     * @return integer 
     */
    public function getExperience(){
        return $this->experience;
    }


    /**
     * @var integer
     * @ORM\Column(name="level", type="integer", nullable=true)
     */
    private $level;
    /**
     * Set level
     * @param stringinteger $level
     * @return Authme
     */
    public function setLevel($level){
        $this->level = $level;
        return $this;
    }
    /**
     * Get level
     * @return integer 
     */
    public function getLevel(){
        return $this->level;
    }



    /**
     * @var string
     * @ORM\Column(name="job", type="string", length=20, nullable=false)
     */
    private $job;
    /**
     * Set job
     * @param string $job
     * @return Authme
     */
    public function setJob($job){
        $this->job = $job;
        return $this;
    }
    /**
     * Get job
     * @return string 
     */
    public function getJob(){
        return $this->job;
    } 


}