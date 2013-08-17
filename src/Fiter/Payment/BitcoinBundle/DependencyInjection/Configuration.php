<?php

namespace Fiter\Payment\BitcoinBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * This is the class that validates and merges configuration from your app/config files
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration{

    public function getConfigTree(){
        $tb = new TreeBuilder();
        
        return $tb
            ->root('fiter_payment_bitcoin', 'array')
                ->children()
                    ->scalarNode('username')->isRequired()->cannotBeEmpty()->end()
                    ->scalarNode('password')->isRequired()->cannotBeEmpty()->end()
                    ->scalarNode('signature')->isRequired()->cannotBeEmpty()->end()
                    ->scalarNode('return_url')->defaultNull()->end()
                    ->scalarNode('cancel_url')->defaultNull()->end()
                    ->booleanNode('debug')->defaultValue('%kernel.debug%')->end()
                ->end()
            ->end()
            ->buildTree();
    }
}