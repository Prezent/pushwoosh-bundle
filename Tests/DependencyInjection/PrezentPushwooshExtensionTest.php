<?php

namespace RaulFraile\Bundle\LadybugBundle\Tests\DependencyInjection;

use Prezent\PushwooshBundle\DependencyInjection\PrezentPushwooshExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class PrezentPushwooshExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PrezentPushwooshExtension
     */
    private $extension;

    /**
     * @var ContainerBuilder
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $this->extension = new PrezentPushwooshExtension();
        $this->container = new ContainerBuilder();
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        $this->extension = null;
        $this->container = null;
    }

    public function testConfigValuesAreSetCorrectly()
    {
        $applicationId = 'XXX-XXX';
        $apiKey = 'xxxxxxxxxxxxxx';
        $this->extension->load(
            [
                [
                    'application_id' => $applicationId,
                    'api_key' => $apiKey,
                ]
            ],
            $this->container
        );

        $this->assertEquals($applicationId, $this->container->getParameter('prezent_pushwoosh.application_id'));
        $this->assertFalse($apiKey, $this->container->getParameter('prezent_pushwoosh.api_key'));
    }
}