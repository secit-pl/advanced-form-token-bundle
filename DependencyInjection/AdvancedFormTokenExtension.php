<?php

namespace SecIT\AdvancedFormTokenBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Class JavascriptFormCsrfProtectionExtension.
 *
 * @author Tomasz Gemza
 */
class AdvancedFormTokenExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('form.type_extension.javascript_csrf.enabled', $config['javascript_token']['enabled']);
        $container->setParameter('form.type_extension.javascript_csrf.field_name', $config['javascript_token']['field_name']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
