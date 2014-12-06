<?php

/**
 * Copyright 2014 Jonathan Bouzekri. All rights reserved.
 *
 * @copyright Copyright 2014 Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license https://github.com/jbouzekri/FileUploaderBundle/blob/master/LICENSE
 * @link https://github.com/jbouzekri/FileUploaderBundle
 */

namespace Jb\Bundle\FileUploaderBundle\Service;

use Jb\Bundle\FileUploaderBundle\Service\ResolverChain;
use Jb\Bundle\FileUploaderBundle\Service\EndpointConfiguration;
use Jb\Bundle\FileUploaderBundle\Exception\JbFileUploaderException;
use Jb\Bundle\FileUploaderBundle\Service\ValidatorManager;

/**
 * Croper
 *
 * @author jobou
 */
class Croper
{
    /**
     * @var \Jb\Bundle\FileUploaderBundle\Service\CropFileManager
     */
    protected $cropManager;

    /**
     *
     * @var \Jb\Bundle\FileUploaderBundle\Service\ResolverChain
     */
    protected $resolvers;

    /**
     * @var \Jb\Bundle\FileUploaderBundle\Service\EndpointConfiguration
     */
    protected $configuration;

    /**
     * @var \Jb\Bundle\FileUploaderBundle\Service\ValidatorManager
     */
    protected $validator;

    /**
     * Constructor
     *
     * @param \Jb\Bundle\FileUploaderBundle\Service\CropFileManager $cropManager
     * @param \Jb\Bundle\FileUploaderBundle\Service\ResolverChain $resolvers
     * @param \Jb\Bundle\FileUploaderBundle\Service\EndpointConfiguration $configuration
     * @param \Jb\Bundle\FileUploaderBundle\Service\ValidatorManager $validator
     */
    public function __construct(
        CropFileManager $cropManager,
        ResolverChain $resolvers,
        EndpointConfiguration $configuration,
        ValidatorManager $validator
    ) {
        $this->cropManager = $cropManager;
        $this->resolvers = $resolvers;
        $this->configuration = $configuration;
        $this->validator = $validator;
    }

    /**
     * Crop an image
     *
     * @param string $endpoint
     * @param array $data
     *
     * @return string
     */
    public function crop($endpoint, array $data)
    {
        // Throw ValidationException if there is an error
        $this->validator->validate($endpoint, $data, 'crop_validators');

        // Generate croped image
        $cropedFile = $this->cropManager->transformFile($data);

        // Save it to filesystem using gaufrette
        $this->cropManager->saveTransformedFile($endpoint, $cropedFile, $data);

        // Return data
        return array(
            'filepath' => $this->resolvers->getResolver($this->getCropResolver($endpoint))->getUrl($data['filename']),
            'filename' => $data['filename']
        );
    }

    /**
     * Get crop resolver configuration
     *
     * @param string $endpoint
     * @return string
     *
     * @throws JbFileUploaderException
     */
    protected function getCropResolver($endpoint)
    {
        $cropedResolver = $this->configuration->getValue($endpoint, 'croped_resolver');
        if (!$cropedResolver) {
            throw new JbFileUploaderException('No croped_resolver configuration for endpoint '.$endpoint);
        }

        return $cropedResolver;
    }
}
