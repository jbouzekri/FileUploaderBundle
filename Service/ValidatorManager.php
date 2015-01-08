<?php

/**
 * Copyright 2014 Jonathan Bouzekri. All rights reserved.
 *
 * @copyright Copyright 2014 Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license https://github.com/jbouzekri/FileUploaderBundle/blob/master/LICENSE
 * @link https://github.com/jbouzekri/FileUploaderBundle
 */

namespace Jb\Bundle\FileUploaderBundle\Service;

use Jb\Bundle\FileUploaderBundle\Service\ValidatorChain;
use Jb\Bundle\FileUploaderBundle\Service\EndpointConfiguration;

/**
 * ValidatorManager
 *
 * @author jobou
 */
class ValidatorManager
{
    /**
     * @var \Jb\Bundle\FileUploaderBundle\Service\ValidatorChain
     */
    protected $validators;

    /**
     * @var \Jb\Bundle\FileUploaderBundle\Service\EndpointConfiguration
     */
    protected $configuration;

    /**
     * Constructor
     *
     * @param \Jb\Bundle\FileUploaderBundle\Service\ValidatorChain $validators
     * @param \Jb\Bundle\FileUploaderBundle\Service\EndpointConfiguration $configuration
     */
    public function __construct(ValidatorChain $validators, EndpointConfiguration $configuration)
    {
        $this->validators = $validators;
        $this->configuration = $configuration;
    }

    /**
     * Validate by applying validators from validator chain
     *
     * @param string $endpoint
     * @param mixed $value
     * @param string $configKey
     *
     * @throws \Jb\Bundle\FileUploaderBundle\Exception\ValidationException
     */
    public function validate($endpoint, $value, $configKey = 'upload_validators')
    {
        $validationConfiguration = $this->configuration->getValue($endpoint, $configKey);

        foreach ((array) $validationConfiguration as $validationType => $config) {
            $validator = $this->validators->getValidator($validationType);
            $validator->applyValidator($value, $config);
        }
    }
}
