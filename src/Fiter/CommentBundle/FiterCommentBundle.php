<?php

namespace Fiter\CommentBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class FiterCommentBundle extends Bundle{
    
    public function getParent(){ return 'FOSCommentBundle'; }
    
}
