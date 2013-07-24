<?php

namespace Fiter\PollBundle\Entity;

use Bait\PollBundle\Entity\Answer as BaseAnswer;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="poll_answer")
 * @ORM\Entity(repositoryClass="Fiter\PollBundle\Entity\AnswerRepository")
 */
class Answer extends BaseAnswer
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Fiter\PollBundle\Entity\Field")
     */
    protected $field;

    /**
     * AnswerGroup.
     *
     * @ORM\JoinColumn(name="answer_group")
     * @ORM\ManyToOne(targetEntity="Fiter\PollBundle\Entity\AnswerGroup",cascade={"persist"})
     */
    protected $answerGroup;

    // public function setAnswerGroup($answerGroup){
    //     $this->answerGroup = $answerGroup;
    // }

    public function __construct(){
        $this->value="1";
        
    }
    public function asd($a){
        $this->field=$a;
        
    }
}