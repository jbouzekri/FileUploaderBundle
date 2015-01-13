<?php

/**
 * Copyright 2014 Jonathan Bouzekri. All rights reserved.
 *
 * @copyright Copyright 2014 Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license https://github.com/jbouzekri/FileUploaderBundle/blob/master/LICENSE
 * @link https://github.com/jbouzekri/FileUploaderBundle
 */

namespace Jb\Bundle\FileUploaderBundle\Service\Resolver;

use Aws\S3\S3Client;

/**
 * Aws3Resolver
 *
 * @author jobou
 */
class Aws3Resolver implements ResolverInterface
{
    /**
     * @var \Aws\S3\S3Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $bucket;

    /**
     * @var string
     */
    protected $directory;

    /**
     * Constructor
     */
    public function __construct(S3Client $client, $bucket, $directory = null)
    {
        $this->client = $client;
        $this->bucket = $bucket;
        $this->directory = $directory;
    }

    /**
     * {@inheritdoc}
     */
    public function getUrl($filename)
    {
        $path = $filename;
        if ($this->directory) {
            $path = sprintf('%s/%s', $this->directory, $path);
        }

        return $this->client->getObjectUrl($this->bucket, $path);
    }
}
