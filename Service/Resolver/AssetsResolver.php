<?php

/**
 * Copyright 2014 Jonathan Bouzekri. All rights reserved.
 *
 * @copyright Copyright 2014 Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license https://github.com/jbouzekri/FileUploaderBundle/blob/master/LICENSE
 * @link https://github.com/jbouzekri/FileUploaderBundle
 */

namespace Jb\Bundle\FileUploaderBundle\Service\Resolver;

use Symfony\Component\Asset\Packages;

/**
 * AssetsResolver
 *
 * @author jobou
 */
class AssetsResolver implements ResolverInterface
{
    /**
     * @var Packages
     */
    protected $assetPackages;

    /**
     * @var string
     */
    protected $directory;

    /**
     * AssetsResolver constructor.
     * @param Packages $assetPackages
     * @param $directory
     */
    public function __construct(Packages $assetPackages, $directory)
    {
        $this->assetPackages = $assetPackages;
        $this->directory = $directory;
    }

    /**
     * {@inheritdoc}
     */
    public function getUrl($key)
    {
        return $this->assetPackages->getUrl(
            trim($this->directory, '/') . '/' . $key
        );
    }
}
