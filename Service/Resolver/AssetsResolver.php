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
     * @var \Jb\Bundle\FileUploaderBundle\Service\EndpointConfiguration
     */
    protected $configuration;

    /**
     * Constructor
     *
     * @param CoreAssetsHelper $helper
     * @param EndpointConfiguration $configuration
     */
    public function __construct(CoreAssetsHelper $helper, EndpointConfiguration $configuration)
    {
        $this->helper = $helper;
        $this->configuration = $configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function getUrl($key, $endpoint)
    {
        return $this->helper->getUrl(
            trim($this->configuration->getValue($endpoint, 'assets_directory'),'/') . '/' . $key
        );
    }
}
