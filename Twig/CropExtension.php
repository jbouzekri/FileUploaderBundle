<?php

/**
 * Copyright 2014 Jonathan Bouzekri. All rights reserved.
 *
 * @copyright Copyright 2014 Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license https://github.com/jbouzekri/FileUploaderBundle/blob/master/LICENSE
 * @link https://github.com/jbouzekri/FileUploaderBundle
 */

namespace Jb\Bundle\FileUploaderBundle\Twig;

use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * CropExtension
 *
 * @author jobou
 */
class CropExtension extends \Twig_Extension
{
    /**
     * @var \Symfony\Component\Routing\Router
     */
    protected $router;

    /**
     * @var string
     */
    protected $routeName;

    /**
     * Constructor
     *
     * @param \Symfony\Component\Routing\Router $router
     * @param string $routeName
     */
    public function __construct(Router $router, $routeName)
    {
        $this->router = $router;
        $this->routeName = $routeName;
    }

    /**
     * {@inheritDoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction(
                'jb_fileuploader_crop_endpoint',
                array($this, 'getCropEndpoint')
            )
        );
    }

    /**
     * Get crop endpoint url
     *
     * @param string $endpoint
     * @param array $parameters
     * @param bool $absolute
     *
     * @return string
     */
    public function getCropEndpoint(
        $endpoint,
        $parameters = array(),
        $absolute = UrlGeneratorInterface::ABSOLUTE_PATH
    ) {
        $parameters = array_merge($parameters, array('endpoint' => $endpoint));

        return $this->router->generate($this->routeName, $parameters, $absolute);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'jb_fileuploader_crop_extension';
    }
}
