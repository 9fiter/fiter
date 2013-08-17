<?php

namespace Fiter\Payment\BitcoinBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * This is the class that loads and manages your bundle configuration
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class FiterPaymentBitcoinExtension extends Extension{
    
    public function load(array $configs, ContainerBuilder $container){
        $configuration = new Configuration();
        $processor = new Processor();
        $config = $processor->process($configuration->getConfigTree(), $configs);

        $xmlLoader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $xmlLoader->load('services.xml');

        $container->setParameter('payment.bitcoin.username', $config['username']);
        $container->setParameter('payment.bitcoin.password', $config['password']);
        $container->setParameter('payment.bitcoin.signature', $config['signature']);
        $container->setParameter('payment.bitcoin.express_checkout.return_url', $config['return_url']);
        $container->setParameter('payment.bitcoin.express_checkout.cancel_url', $config['cancel_url']);
        $container->setParameter('payment.bitcoin.debug', $config['debug']);
    }
}
