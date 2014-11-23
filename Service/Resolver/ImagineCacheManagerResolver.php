<?php

/**
 * Copyright 2014 Jonathan Bouzekri. All rights reserved.
 *
 * @copyright Copyright 2014 Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license https://github.com/jbouzekri/FileUploaderBundle/blob/master/LICENSE
 * @link https://github.com/jbouzekri/FileUploaderBundle
 */

namespace Jb\Bundle\FileUploaderBundle\Service\Resolver;

use Liip\ImagineBundle\Imagine\Cache\CacheManager;

/**
 * ImagineCacheManagerResolver
 *
 * @author jobou
 */
class ImagineCacheManagerResolver implements ResolverInterface
{
    /**
     * @var \Liip\ImagineBundle\Imagine\Cache\CacheManager
     */
    protected $imagine;

    /**
     * Constructor
     *
     * @param \Liip\ImagineBundle\Imagine\Cache\CacheManager $imagine
     */
    public function __construct(CacheManager $imagine)
    {
        $this->imagine = $imagine;
    }

    /**
     * {@inheritdoc}
     */
    public function getUrl($key)
    {
        return $this->imagine->getBrowserPath($key, 'original');
    }
}
