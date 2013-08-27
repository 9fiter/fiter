<?php
// src/Fiter/CronManagerBundle/FiterCronManagerBundle.php
namespace Fiter\CronManagerBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class FiterCronManagerBundle extends Bundle{
    public function getParent(){
        return 'BCCCronManagerBundle';
    }
}