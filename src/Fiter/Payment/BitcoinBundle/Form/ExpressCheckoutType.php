<?php

namespace Fiter\Payment\BitcoinBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Type for Bitcoin Express Checkout.
 */
class ExpressCheckoutType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options){

    }
    public function getName(){
        return 'bitcoin_express_checkout';
    }
}