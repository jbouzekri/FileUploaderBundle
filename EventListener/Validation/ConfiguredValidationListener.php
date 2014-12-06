<?php

/**
 * Copyright 2014 Jonathan Bouzekri. All rights reserved.
 *
 * @copyright Copyright 2014 Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license https://github.com/jbouzekri/FileUploaderBundle/blob/master/LICENSE
 * @link https://github.com/jbouzekri/FileUploaderBundle
 */

namespace Jb\Bundle\FileUploaderBundle\EventListener\Validation;

use Oneup\UploaderBundle\Event\ValidationEvent;
use Oneup\UploaderBundle\Uploader\Exception\ValidationException;
use Jb\Bundle\FileUploaderBundle\Service\ValidatorManager;
use Jb\Bundle\FileUploaderBundle\Exception\ValidationException as JbFileUploaderValidationException;

/**
 * ConfiguredValidationListener
 *
 * @author jobou
 */
class ConfiguredValidationListener
{
    /**
     * @var \Jb\Bundle\FileUploaderBundle\Service\ValidatorManager
     */
    protected $validator;

    /**
     * Constructor
     *
     * @param \Jb\Bundle\FileUploaderBundle\Service\ValidatorManager $validator
     */
    public function __construct(ValidatorManager $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Validate a submited file
     *
     * @param ValidationEvent $event
     * @throws \Oneup\UploaderBundle\Uploader\Exception\ValidationException
     */
    public function onValidate(ValidationEvent $event)
    {
        try {
            $this->validator->validate(
                $event->getType(),
                $event->getFile(),
                'upload_validators'
            );
        } catch (JbFileUploaderValidationException $e) {
            throw new ValidationException($e->getMessage(), null, $e);
        }
    }
}
