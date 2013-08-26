<?php

namespace Fiter\Payment\BitcoinBundle\Plugin\Exception;

use JMS\Payment\CoreBundle\Plugin\Exception\FinancialException;

/**
 * This exception is thrown when the buyer is not in desired state.
 */
class InvalidPayerException extends FinancialException{
	
}