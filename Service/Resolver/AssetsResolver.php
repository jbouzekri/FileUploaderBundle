<?php

/**
 * Copyright 2014 Jonathan Bouzekri. All rights reserved.
 *
 * @copyright Copyright 2014 Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license https://github.com/jbouzekri/FileUploaderBundle/blob/master/LICENSE
 * @link https://github.com/jbouzekri/FileUploaderBundle
 */

namespace Jb\Bundle\FileUploaderBundle\Service\Resolver;

use Symfony\Component\Templating\Helper\CoreAssetsHelper;
use Jb\Bundle\FileUploaderBundle\Service\EndpointConfiguration;

/**
 * AssetsResolver
 *
 * @author jobou
 */
class AssetsResolver implements ResolverInterface
{
    /**
     * @var \Symfony\Component\Templating\Helper\CoreAssetsHelper
     */
    protected $helper;

    /**
     * @var string
     */
    protected $directory;

    /**
     * Constructor
     *
     * @param CoreAssetsHelper $helper
     * @param string $directory
     */
    public function __construct(CoreAssetsHelper $helper, $directory)
    {
        $this->helper = $helper;
        $this->directory = $directory;
    }

    /**
     * {@inheritdoc}
     */
    public function getUrl($key)
    {
        return $this->helper->getUrl(
            trim($this->directory, '/') . '/' . $key
        );
    }
}
