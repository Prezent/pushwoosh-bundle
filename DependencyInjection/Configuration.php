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
            ->scalarNode('api_key')
                ->isRequired()
            ->end()
            ->scalarNode('application_id')->end()
            ->scalarNode('application_group_id')->end()
            ->scalarNode('client_class')->end()
            ->scalarNode('logging')->defaultValue('')->end()
        ;

        return $treeBuilder;
    }
}
