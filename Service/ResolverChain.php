<?php

/**
 * Copyright 2014 Jonathan Bouzekri. All rights reserved.
 *
 * @copyright Copyright 2014 Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license https://github.com/jbouzekri/FileUploaderBundle/blob/master/LICENSE
 * @link https://github.com/jbouzekri/FileUploaderBundle
 */

namespace Jb\Bundle\FileUploaderBundle\Service;

use Jb\Bundle\FileUploaderBundle\Exception\JbFileUploaderException;
use Jb\Bundle\FileUploaderBundle\Service\Resolver\ResolverInterface;

/**
 * ResolverChain
 *
 * @author jobou
 */
class ResolverChain
{
    /**
     * @var array
     */
    private $resolvers;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->resolvers = array();
    }

    /**
     * Add a resolver
     *
     * @param \Jb\Bundle\FileUploaderBundle\Service\Resolver\ResolverInterface $resolver
     */
    public function addResolver(ResolverInterface $resolver, $alias)
    {
        $this->resolvers[$alias] = $resolver;
    }

    /**
     *
     * @param string $alias
     *
     * @return \Jb\Bundle\FileUploaderBundle\Service\Resolver\ResolverInterface
     *
     * @throws \Jb\Bundle\FileUploaderBundle\Exception\JbFileUploaderException
     */
    public function getResolver($alias)
    {
        if (array_key_exists($alias, $this->resolvers)) {
            return $this->resolvers[$alias];
        }

        throw new JbFileUploaderException('Unknown resolver ' . $alias);
    }
}
