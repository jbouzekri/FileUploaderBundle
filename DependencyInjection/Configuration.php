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

/**
 * JbFileUploaderBundle configuration structure.
 *
 * @author Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('jb_fileuploader');

        $rootNode
            ->children()
                ->scalarNode('assets_directory')->defaultValue('uploads')->end()
                ->scalarNode('resolver')->defaultValue('assets')->end()
                ->arrayNode('endpoints')
                    ->defaultValue(array())
                    ->prototype('array')
                        ->children()
                            ->scalarNode('resolver')->end()
                            ->scalarNode('assets_directory')->end()
                            ->arrayNode('validators')
                                ->defaultValue(array())
                                ->prototype('variable')
                                ->end()
                                ->beforeNormalization()
                                    ->always()
                                    ->then(function($values) {
                                        // Normalize null as array
                                        foreach ($values as $key => $value) {
                                            if ($value === NULL) {
                                                $values[$key] = array();
                                            }
                                        }
                                        return $values;
                                    })
                                ->end()
                                ->validate()
                                    ->ifTrue(function ($value){
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
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
