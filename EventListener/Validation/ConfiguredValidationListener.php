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
use Jb\Bundle\FileUploaderBundle\Service\ValidatorChain;
use Jb\Bundle\FileUploaderBundle\Service\EndpointConfiguration;
use Jb\Bundle\FileUploaderBundle\Exception\ValidationException as JbFileUploaderValidationException;

/**
 * ConfiguredValidationListener
 *
 * @author jobou
 */
class ConfiguredValidationListener
{
    /**
     * @var \Jb\Bundle\FileUploaderBundle\Service\EndpointConfiguration
     */
    protected $configuration;

    /**
     * @var \Jb\Bundle\FileUploaderBundle\Service\ValidatorChain
     */
    protected $validators;

    /**
     * Constructor
     *
     * @param ValidatorChain $validators
     * @param EndpointConfiguration $configuration
     */
    public function __construct(ValidatorChain $validators, EndpointConfiguration $configuration)
    {
        $this->validators = $validators;
        $this->configuration = $configuration;
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
            $this->validate($event);
        } catch (JbFileUploaderValidationException $e) {
            throw new ValidationException($e->getMessage(), null, $e);
        }
    }

    /**
     * Apply all validators to uploaded file
     *
     * @param ValidationEvent $event
     *
     * @throws \Jb\Bundle\FileUploaderBundle\Exception\ValidationException
     */
    protected function validate(ValidationEvent $event)
    {
        $validationConfiguration = $this->configuration->getValue($event->getType(), 'upload_validators');

        foreach ($validationConfiguration as $validationType => $config) {
            $validator = $this->validators->getValidator($validationType);
            $validator->applyValidator($event->getFile(), $config);
        }
    }
}
