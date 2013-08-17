<?php

namespace Fiter\Payment\BitcoinBundle\Client\Authentication;

use JMS\Payment\CoreBundle\BrowserKit\Request;

interface AuthenticationStrategyInterface{
    function getApiEndpoint($isDebug);
    function authenticate(Request $request);
}