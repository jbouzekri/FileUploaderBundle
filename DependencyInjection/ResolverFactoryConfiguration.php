<?php

/**
 * Copyright 2014 Jonathan Bouzekri. All rights reserved.
 *
 * @copyright Copyright 2014 Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license https://github.com/jbouzekri/FileUploaderBundle/blob/master/LICENSE
 * @link https://github.com/jbouzekri/FileUploaderBundle
 */

/**
 * @namespace
 */
namespace Jb\Bundle\FileUploaderBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Resolver factory configuration for the FileUploader Extension
 *
 * @author Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 */
class ResolverFactoryConfiguration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $treeBuilder
            ->root('jb_fileuploader')
                ->ignoreExtraKeys()
                ->fixXmlConfig('resolver_factory', 'resolver_factories')
                ->children()
                    ->arrayNode('resolver_factories')
                        ->defaultValue(array())
                        ->prototype('scalar')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
