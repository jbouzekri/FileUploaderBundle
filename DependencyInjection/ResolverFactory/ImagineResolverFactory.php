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
 * ImagineResolverFactory
 *
 * @author jobou
 */
class ImagineResolverFactory implements ResolverFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getKey()
    {
        return 'imagine';
    }

    /**
     * {@inheritdoc}
     */
    public function addConfiguration(ArrayNodeDefinition $node)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function create(ContainerBuilder $container, $id, array $factory)
    {

    }
}
