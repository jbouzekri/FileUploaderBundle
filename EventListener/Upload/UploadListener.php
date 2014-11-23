<?php

/**
 * Copyright 2014 Jonathan Bouzekri. All rights reserved.
 *
 * @copyright Copyright 2014 Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license https://github.com/jbouzekri/FileUploaderBundle/blob/master/LICENSE
 * @link https://github.com/jbouzekri/FileUploaderBundle
 */

namespace Jb\Bundle\FileUploaderBundle\EventListener\Upload;

use Oneup\UploaderBundle\Event\PostPersistEvent;
use Jb\Bundle\FileUploaderBundle\Entity\FileHistory;
use Jb\Bundle\FileUploaderBundle\Service\FileHistoryManagerInterface;

/**
 * UploadListener
 * Append the filename and route to the response
 */
class UploadListener
{
    /**
     * @var FileHistoryManagerInterface
     */
    protected $fileHistoryManager;

    /**
     * Constructor
     *
     * @param FileHistoryManagerInterface $fileHistoryManager
     */
    public function __construct(FileHistoryManagerInterface $fileHistoryManager)
    {
        $this->fileHistoryManager = $fileHistoryManager;
    }

    /**
     * {@inheritDoc}
     */
    public function onUpload(PostPersistEvent $event)
    {
        // Create and persist a file history object
        $fileHistory = $this->createFileHistory($event);

        // Add filename information to response
        $response = $event->getResponse();
        $response['filename'] = $fileHistory->getFileName();
        $response['originalname'] = $fileHistory->getOriginalName();
        $response['filepath'] = $this->fileHistoryManager->getUrl($fileHistory);
    }

    /**
     * Create a filehistory to retrieve original name and uploading user
     *
     * @param PostPersistEvent $event
     *
     * @return FileHistory
     */
    protected function createFileHistory(PostPersistEvent $event)
    {
        // Find original filename in request uploaded file
        $files = $event->getRequest()->files->all();
        $uploadedFile = array_pop($files);
        $originalFileName = $uploadedFile->getClientOriginalName();

        // Get generated filename
        $fileName = $event->getFile()->getBasename();

        // Fill FileHistory object
        return $this->fileHistoryManager->createAndSave($fileName, $originalFileName, $event->getType());
    }
}
