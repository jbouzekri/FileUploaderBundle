<?php

/**
 * Copyright 2014 Jonathan Bouzekri. All rights reserved.
 *
 * @copyright Copyright 2014 Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license https://github.com/jbouzekri/FileUploaderBundle/blob/master/LICENSE
 * @link https://github.com/jbouzekri/FileUploaderBundle
 */

namespace Jb\Bundle\FileUploaderBundle\Service\Resolver;

/**
 * ResolverInterface
 *
 * @author jobou
 */
interface ResolverInterface
{
    /**
     * Get the url
     *
     * @param string $key
     *
     * @return string
     */
    public function getUrl($key);
}
