<?php

namespace Prezent\PushwooshBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Bundle configuration
 *
 * @see ConfigurationInterface
 * @author Robert-Jan Bijl <robert-jan@prezent.nl>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('prezent_pushwoosh');

        $rootNode
            ->children()
            ->scalarNode('application_id')
                ->isRequired()
            ->end()
            ->scalarNode('api_key')
                ->isRequired()
            ->end()
            ->scalarNode('client_class')
            ->end()
        ;

        return $treeBuilder;
    }
}
