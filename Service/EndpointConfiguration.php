<?php

/**
 * Copyright 2014 Jonathan Bouzekri. All rights reserved.
 *
 * @copyright Copyright 2014 Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license https://github.com/jbouzekri/FileUploaderBundle/blob/master/LICENSE
 * @link https://github.com/jbouzekri/FileUploaderBundle
 */

namespace Jb\Bundle\FileUploaderBundle\Service;

/**
 * EndpointConfiguration
 *
 * @author jobou
 */
class EndpointConfiguration
{
    /**
     * @var array
     */
    protected $endpoints;

    /**
     * Constructor
     *
     * @param array $endpoints
     */
    public function __construct(array $endpoints)
    {
        $this->endpoints = $endpoints;
    }


    /**
     * Get configuration value
     *
     * @param string $endpoint
     * @param string $key
     *
     * @return mixed
     */
    public function getValue($endpoint, $key)
    {
        if (isset($this->endpoints['endpoints'][$endpoint])
            && isset($this->endpoints['endpoints'][$endpoint][$key])
        ) {
            return $this->endpoints['endpoints'][$endpoint][$key];
        }

        if (isset($this->endpoints[$key])) {
            return $this->endpoints[$key];
        }

        return null;
    }

    /**
     * Get enpoint configuration
     *
     * @param string $endpoint
     * @return mixed
     */
    public function getEndpoint($endpoint)
    {
        return $this->endpoints[$endpoint];
    }
}
