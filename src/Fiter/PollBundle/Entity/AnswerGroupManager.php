<?php

namespace Fiter\PollBundle\Entity;

use Bait\PollBundle\Entity\AnswerGroupManager as BaseAnswerGroupManager;
use Bait\PollBundle\Model\SignedAnswerGroupManagerInterface;
use Bait\PollBundle\Model\PollInterface;

class AnswerGroupManager extends BaseAnswerGroupManager implements SignedAnswerGroupManagerInterface{
    /**
     * {@inheritDoc}
     */
    public function hasAnswered(PollInterface $poll){
        return $this->hasAnsweredAnonymously($poll) || $this->hasUserAnswered($poll);
    }
    /**
     * {@inheritDoc}
     */
    public function hasUserAnswered(PollInterface $poll){
        return false;
    }
}