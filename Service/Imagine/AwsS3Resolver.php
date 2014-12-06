<?php

namespace Jb\Bundle\FileUploaderBundle\Service\Imagine;

use Aws\S3\Enum\CannedAcl;
use Aws\S3\S3Client;
use Liip\ImagineBundle\Binary\BinaryInterface;
use Liip\ImagineBundle\Exception\Imagine\Cache\Resolver\NotStorableException;
use Psr\Log\LoggerInterface;
use Liip\ImagineBundle\Imagine\Cache\Resolver\AwsS3Resolver as BaseAwsS3Resolver;

class AwsS3Resolver extends BaseAwsS3Resolver
{
    /**
     * Constructs a cache resolver storing images on Amazon S3.
     *
     * @param S3Client $storage The Amazon S3 storage API. It's required to know authentication information.
     * @param string $bucket The bucket name to operate on.
     * @param string $acl The ACL to use when storing new objects. Default: owner read/write, public read
     * @param array $objUrlOptions A list of options to be passed when retrieving the object url from Amazon S3.
     */
    public function __construct(S3Client $storage, $bucket, $acl = "public-read", array $objUrlOptions = array())
    {
        $this->storage = $storage;
        $this->bucket = $bucket;
        $this->acl = $acl;
        $this->objUrlOptions = $objUrlOptions;
    }

    /**
     * Returns the object path within the bucket.
     *
     * @param string $path The base path of the resource.
     * @param string $filter The name of the imagine filter in effect.
     *
     * @return string The path of the object on S3.
     */
    protected function getObjectPath($path, $filter)
    {
        // If original in aws3, then it is in the images folder
        if ($filter == 'original') {
            return $path;
        }

        return parent::getObjectPath($path, $filter);
    }
}
