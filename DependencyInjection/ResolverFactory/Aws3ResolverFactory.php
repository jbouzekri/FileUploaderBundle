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
namespace Jb\Bundle\FileUploaderBundle\DependencyInjection\ResolverFactory;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Aws3ResolverFactory
 *
 * @author jobou
 */
class Aws3ResolverFactory implements ResolverFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getKey()
    {
        return 'aws3';
    }

    /**
     * {@inheritdoc}
     */
    public function addConfiguration(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('service_id')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('bucket')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('directory')->defaultValue(null)->end()
            ->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function create(ContainerBuilder $container, $id, array $config)
    {
        $container
            ->setDefinition($id, new DefinitionDecorator('jb_fileuploader.resolver.aws3.prototype'))
            ->setScope('request')
            ->addArgument(new Reference($config['service_id']))
            ->addArgument($config['bucket'])
            ->addArgument($config['directory'])
        ;
    }
}
