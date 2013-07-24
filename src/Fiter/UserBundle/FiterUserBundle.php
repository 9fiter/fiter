<?php

namespace Fiter\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class FiterUserBundle extends Bundle{
    
    public function getParent(){ return 'FOSUserBundle'; }
    
}
