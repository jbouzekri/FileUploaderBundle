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
 * FileHistoryManagerInterface
 *
 * @author jobou
 */
interface FileHistoryManagerInterface
{
    /**
     * Create and save a file history object
     *
     * @param string $fileName
     * @param string $originalName
     * @param string $type
     * @param int $userId
     *
     * @return FileHistory
     */
    public function createAndSave($fileName, $originalName, $type, $userId = null);

    /**
     * Instantiate a new file history object
     *
     * @param string $fileName
     * @param string $originalName
     * @param string $type
     * @param int $userId
     *
     * @return FileHistory
     */
    public function create($fileName, $originalName, $type, $userId);

    /**
     * Find one FileHistory by filename
     *
     * @param string $fileName
     *
     * @return FileHistory
     */
    public function findOneByFileName($fileName);
}
