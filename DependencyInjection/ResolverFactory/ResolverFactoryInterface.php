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

/**
 * ResolverFactoryInterface
 * @author jobou
 */
interface ResolverFactoryInterface
{
    /**
     * Indicates which types of resolver is handled by this factory
     *
     * @var string
     */
    public function getKey();

    /**
     * Add configuration to extension
     *
     * @param ArrayNodeDefinition $node
     */
    public function addConfiguration(ArrayNodeDefinition $node);

    /**
     * Create a resolver service definition
     *
     * @param ContainerBuilder $container
     * @param string $id
     * @param array $factory
     */
    public function create(ContainerBuilder $container, $id, array $factory);
}
