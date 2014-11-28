<?php

/**
 * Copyright 2014 Jonathan Bouzekri. All rights reserved.
 *
 * @copyright Copyright 2014 Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license https://github.com/jbouzekri/FileUploaderBundle/blob/master/LICENSE
 * @link https://github.com/jbouzekri/FileUploaderBundle
 */

namespace Jb\Bundle\FileUploaderBundle\Service;

use Jb\Bundle\FileUploaderBundle\Exception\JbFileUploaderException;
use Jb\Bundle\FileUploaderBundle\Service\Validator\AbstractValidator;

/**
 * ValidatorChain
 *
 * @author jobou
 */
class ValidatorChain
{
    /**
     * @var array
     */
    private $validators;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->validators = array();
    }

    /**
     * Add a validator
     *
     * @param \Jb\Bundle\FileUploaderBundle\Service\Validator\AbstractValidator $validator
     */
    public function addValidator(AbstractValidator $validator, $alias)
    {
        $this->validators[$alias] = $validator;
    }

    /**
     * Get a validator by its alias
     *
     * @param string $alias
     *
     * @return \Jb\Bundle\FileUploaderBundle\Service\Validator\AbstractValidator
     *
     * @throws \Jb\Bundle\FileUploaderBundle\Exception\JbFileUploaderException
     */
    public function getValidator($alias)
    {
        if (array_key_exists($alias, $this->validators)) {
            return $this->validators[$alias];
        }

        throw new JbFileUploaderException('Unknown validator ' . $alias);
    }
}
