<?php

/**
 * Copyright 2014 Jonathan Bouzekri. All rights reserved.
 *
 * @copyright Copyright 2014 Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license https://github.com/jbouzekri/FileUploaderBundle/blob/master/LICENSE
 * @link https://github.com/jbouzekri/FileUploaderBundle
 */

namespace Jb\Bundle\FileUploaderBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * JbFileUploaderBundle configuration structure.
 *
 * @author Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 */
class MainConfiguration implements ConfigurationInterface
{
    /**
     * @var array
     */
    protected $factories;

    /**
     * Constructor
     *
     * @param array $factories
     */
    public function __construct(array $factories)
    {
        $this->factories = $factories;
    }

    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('jb_fileuploader');

        $this->addResolversSection($rootNode, $this->factories);

        $rootNode
            ->children()
                ->scalarNode('upload_resolver')->end()
                ->scalarNode('croped_resolver')->end()
                ->scalarNode('crop_route')->defaultValue('jb_image_crop_endpoint')->end()
                ->scalarNode('croped_fs')->end()
                ->arrayNode('endpoints')
                    ->defaultValue(array())
                    ->prototype('array')
                        ->children()
                            ->scalarNode('upload_resolver')->end()
                            ->scalarNode('croped_resolver')->end()
                            ->scalarNode('croped_fs')->end()
                            ->append($this->getValidators('upload_validators'))
                            ->append($this->getValidators('crop_validators'))
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }

    /**
     * Add resolvers section
     *
     * @param \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition $node
     * @param array $factories
     */
    protected function addResolversSection(ArrayNodeDefinition $node, array $factories)
    {
        $resolverNodeBuilder = $node
            ->fixXmlConfig('resolver')
            ->children()
                ->arrayNode('resolvers')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                    ->performNoDeepMerging()
                    ->children()
        ;

        foreach ($factories as $name => $factory) {
            $factoryNode = $resolverNodeBuilder->arrayNode($name)->canBeUnset();

            $factory->addConfiguration($factoryNode);
        }
    }

    /**
     * Add a custom validator key to configuration
     *
     * @param string $key
     *
     * @return TreeBuilder
     */
    protected function getValidators($key)
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root($key);

        $rootNode
            ->defaultValue(array())
            ->prototype('variable')
            ->end()
            ->beforeNormalization()
                ->always()
                ->then(function ($values) {
                    // Normalize null as array
                    foreach ($values as $key => $value) {
                        if ($value === null) {
                            $values[$key] = array();
                        }
                    }
                    return $values;
                })
            ->end();

        $this->addValidatorValidation($rootNode);

        return $rootNode;
    }

    /**
     * Add validation to a validator key
     *
     * @param ArrayNodeDefinition $node
     */
    protected function addValidatorValidation(ArrayNodeDefinition $node)
    {
        $node->validate()
            ->ifTrue(function ($value) {
                if (!is_array($value)) {
                    return true;
                }

                // All key must be string. Used as alias for the validator service
                if (count(array_filter(array_keys($value), 'is_string')) != count($value)) {
                    return true;
                }

                // All value must be array. Used as configuration for validator
                if (count(array_filter(array_values($value), 'is_array')) != count($value)) {
                    return true;
                }

                return false;
            })
            ->thenInvalid('Invalid validators configuration')
        ->end();
    }
}
