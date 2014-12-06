<?php

/**
 * Copyright 2014 Jonathan Bouzekri. All rights reserved.
 *
 * @copyright Copyright 2014 Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license https://github.com/jbouzekri/FileUploaderBundle/blob/master/LICENSE
 * @link https://github.com/jbouzekri/FileUploaderBundle
 */

namespace Jb\Bundle\FileUploaderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FileHistory
 *
 * @ORM\Entity
 * @ORM\Table(name="jb_filehistory")
 */
class FileHistory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(type="string", length=255, name="file_name")
     *
     * @var string
     */
    protected $fileName;

    /**
     * @ORM\Column(type="string", length=255, name="original_name")
     *
     * @var string
     */
    protected $originalName;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    protected $type;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var int
     */
    protected $userId;

    /**
     * Set fileName
     *
     * @param string $fileName
     * @return FileHistory
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set originalName
     *
     * @param string $originalName
     * @return FileHistory
     */
    public function setOriginalName($originalName)
    {
        $this->originalName = $originalName;

        return $this;
    }

    /**
     * Get originalName
     *
     * @return string
     */
    public function getOriginalName()
    {
        return $this->originalName;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     * @return FileHistory
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return FileHistory
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
