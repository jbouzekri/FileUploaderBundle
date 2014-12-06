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
use Jb\Bundle\FileUploaderBundle\Service\EndpointConfiguration;
use Liip\ImagineBundle\Binary\BinaryInterface;

/**
 * Croper
 *
 * @author jobou
 */
class CropFileManager
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
     * @var \Jb\Bundle\FileUploaderBundle\Service\EndpointConfiguration
     */
    protected $configuration;

    /**
     * Constructor
     *
     * @param DataManager $dataManager
     * @param FilterManager $filterManager
     * @param FilesystemMap $filesystemMap
     * @param EndpointConfiguration $configuration
     */
    public function __construct(
        DataManager $dataManager,
        FilterManager $filterManager,
        FilesystemMap $filesystemMap,
        EndpointConfiguration $configuration
    ) {
        $this->dataManager = $dataManager;
        $this->filterManager = $filterManager;
        $this->filesystemMap = $filesystemMap;
        $this->configuration = $configuration;
    }

    /**
     * Transform the file
     *
     * @param string $endpoint
     * @param array $data
     *
     * @return \Liip\ImagineBundle\Binary\BinaryInterface
     */
    public function transformFile(array $data)
    {
        return $this->filterManager->apply(
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
    }

    /**
     * Save the transformed file
     *
     * @param string $endpoint
     * @param BinaryInterface $cropedFile
     * @param array $data
     */
    public function saveTransformedFile($endpoint, BinaryInterface $cropedFile, array $data)
    {
        $this
            ->filesystemMap
            ->get(
                $this->configuration->getValue($endpoint, 'croped_fs')
            )
            ->write(
                $data['filename'],
                $cropedFile->getContent()
            );
    }
}
