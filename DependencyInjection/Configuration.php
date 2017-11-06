<?php

namespace SecIT\AdvancedFormTokenBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration.
 *
 * @author Tomasz Gemza
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('advanced_form_token');

        $rootNode
            ->children()
                ->arrayNode('javascript_token')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('enabled')
                            ->defaultFalse()
                        ->end()
                        ->scalarNode('field_name')
                            ->cannotBeEmpty()
                            ->defaultValue('_jstoken')
                        ->end()
                        ->scalarNode('javascript_obfuscator')
                            ->defaultNull()
                        ->end()
                    ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
