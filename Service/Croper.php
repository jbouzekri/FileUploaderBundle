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
     * Constructor
     *
     * @param \Liip\ImagineBundle\Imagine\Data\DataManager $dataManager
     * @param \Liip\ImagineBundle\Imagine\Filter\FilterManager $filterManager
     * @param \Knp\Bundle\GaufretteBundle\FilesystemMap $filesystemMap
     */
    public function __construct(
        DataManager $dataManager,
        FilterManager $filterManager,
        FilesystemMap $filesystemMap
    ) {
        $this->dataManager = $dataManager;
        $this->filterManager = $filterManager;
        $this->filesystemMap = $filesystemMap;
    }

    /**
     * Crop an image
     *
     * @param string $endpoint
     * @param array $data
     *
     * @return string
     */
    public function crop(array $data)
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
    }
}
