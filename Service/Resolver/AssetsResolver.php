<?php

/**
 * Copyright 2014 Jonathan Bouzekri. All rights reserved.
 *
 * @copyright Copyright 2014 Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license https://github.com/jbouzekri/FileUploaderBundle/blob/master/LICENSE
 * @link https://github.com/jbouzekri/FileUploaderBundle
 */

namespace Jb\Bundle\FileUploaderBundle\Service\Resolver;

use Symfony\Bundle\FrameworkBundle\Templating\Helper\AssetsHelper;

/**
 * AssetsResolver
 *
 * @author jobou
 */
class AssetsResolver implements ResolverInterface
{
    /**
     * @var \Symfony\Bundle\FrameworkBundle\Templating\Helper\AssetsHelper
     */
    protected $helper;

    /**
     * @var string
     */
    protected $directory;

    /**
     * Constructor
     *
     * @param AssetsHelper $helper
     * @param string $directory
     */
    public function __construct(AssetsHelper $helper, $directory)
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
