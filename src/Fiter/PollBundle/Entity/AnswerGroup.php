<?php

namespace Fiter\PollBundle\Entity;

use Bait\PollBundle\Entity\AnswerGroup as BaseAnswerGroup;
use Bait\PollBundle\Model\SignedAnswerGroupInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="poll_answer_group")
 * @ORM\Entity(repositoryClass="Fiter\PollBundle\Entity\AnswerGroupRepository")
 */
class AnswerGroup extends BaseAnswerGroup 
//implements SignedAnswerGroupInterface
{
    /**
     * Author of answer.
     *
     * @ORM\ManyToOne(targetEntity="Fiter\DefaultBundle\Entity\Usuario")
     */
    protected $author;
    public function setAuthor(UserInterface $author){
        $this->author = $author;
    }
    public function getAuthor(){
        return $this->author;
    }
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * Poll.
     *
     * @ORM\ManyToOne(targetEntity="Fiter\PollBundle\Entity\Poll")
     */
    protected $poll;
    public function __toString(){
        return $this->id." - ".$this->clientIp;
    }
}