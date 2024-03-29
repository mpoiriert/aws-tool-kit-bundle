<?php

namespace Draw\Bundle\AwsToolKitBundle\DependencyInjection;

use Draw\Bundle\AwsToolKitBundle\Imds\ImdsClientInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class DrawAwsToolKitExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $config = $this->processConfiguration($this->getConfiguration($configs, $container), $configs);

        if (!$config['imds_version']) {
            return;
        }

        $container->setAlias(
            ImdsClientInterface::class,
            'Draw\Bundle\AwsToolKitBundle\Imds\ImdsClientV'.$config['imds_version']
        );
    }
}
