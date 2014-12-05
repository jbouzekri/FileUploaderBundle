<?php

/**
 * Copyright 2014 Jonathan Bouzekri. All rights reserved.
 *
 * @copyright Copyright 2014 Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license https://github.com/jbouzekri/FileUploaderBundle/blob/master/LICENSE
 * @link https://github.com/jbouzekri/FileUploaderBundle
 */

namespace Jb\Bundle\FileUploaderBundle\Service;

use Liip\ImagineBundle\Imagine\Data\DataManager;
use Liip\ImagineBundle\Imagine\Filter\FilterManager;
use Knp\Bundle\GaufretteBundle\FilesystemMap;
use Jb\Bundle\FileUploaderBundle\Service\ResolverChain;
use Jb\Bundle\FileUploaderBundle\Service\EndpointConfiguration;
use Jb\Bundle\FileUploaderBundle\Exception\JbFileUploaderException;

/**
 * Croper
 *
 * @author jobou
 */
class Croper
{
    /**
     * @var \Liip\ImagineBundle\Imagine\Data\DataManager
     */
    protected $dataManager;

    /**
     * @var \Liip\ImagineBundle\Imagine\Filter\FilterManager
     */
    protected $filterManager;

    /**
     * @var \Knp\Bundle\GaufretteBundle\FilesystemMap
     */
    protected $filesystemMap;

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
     * Constructor
     *
     * @param \Liip\ImagineBundle\Imagine\Data\DataManager $dataManager
     * @param \Liip\ImagineBundle\Imagine\Filter\FilterManager $filterManager
     * @param \Knp\Bundle\GaufretteBundle\FilesystemMap $filesystemMap
     * @param \Jb\Bundle\FileUploaderBundle\Service\ResolverChain $resolvers
     * @param \Jb\Bundle\FileUploaderBundle\Service\EndpointConfiguration $configuration
     */
    public function __construct(
        DataManager $dataManager,
        FilterManager $filterManager,
        FilesystemMap $filesystemMap,
        ResolverChain $resolvers,
        EndpointConfiguration $configuration
    ) {
        $this->dataManager = $dataManager;
        $this->filterManager = $filterManager;
        $this->filesystemMap = $filesystemMap;
        $this->resolvers = $resolvers;
        $this->configuration = $configuration;
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
        // @TODO : configure endpoint original
        $cropedFile = $this->filterManager->apply(
            $binaryFile = $this->dataManager->find('original', $data['filename']),
            array(
                'filters' => array(
                    'crop'=> array(
                        'start' => array($data['x'], $data['y']),
                        'size' => array($data['width'], $data['height'])
                    )
                )
            )
        );

        // @TODO : configure filesystem name
        $this->filesystemMap->get('croped')->write($data['filename'], $cropedFile->getContent());

        return $this->resolvers->getResolver($this->getCropResolver($endpoint))->getUrl($data['filename']);
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
