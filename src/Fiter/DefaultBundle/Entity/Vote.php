<?php

namespace Fiter\DefaultBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\CommentBundle\Entity\Vote as BaseVote;

/**
 * @ORM\Entity
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 */
class Vote extends BaseVote{
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\generatedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Comment of this vote
     *
     * @var Comment
     * @ORM\ManyToOne(targetEntity="Fiter\DefaultBundle\Entity\Comment")
     */
    protected $comment;
    
    /**
     * Author of the comment
     *
     * @ORM\ManyToOne(targetEntity="Fiter\DefaultBundle\Entity\Usuario")
     * @var User
     */
    protected $author;
    public function setAuthor($author){ $this->author = $author; }
    public function getAuthor(){ return $this->author; }
    public function getAuthorName(){
        if (null === $this->getAuthor()) return 'Anónimo';
        return $this->getAuthor()->getUsername();
    }
}