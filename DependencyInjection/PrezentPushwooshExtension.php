<?php

namespace Prezent\PushwooshBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Load the bundle configuration
 *
 * @see Extension
 * @author Robert-Jan Bijl <robert-jan@prezent.nl>
 */
class PrezentPushwooshExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $container->setParameter('prezent_pushwoosh.application_id', $config['application_id']);
        $container->setParameter('prezent_pushwoosh.api_key', $config['api_key']);
    }
}
