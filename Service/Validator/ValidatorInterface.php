<?php

/**
 * Copyright 2014 Jonathan Bouzekri. All rights reserved.
 *
 * @copyright Copyright 2014 Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license https://github.com/jbouzekri/FileUploaderBundle/blob/master/LICENSE
 * @link https://github.com/jbouzekri/FileUploaderBundle
 */

namespace Jb\Bundle\FileUploaderBundle\Service\Validator;

/**
 * ValidatorInterface
 *
 * @author jobou
 */
interface ValidatorInterface
{
    /**
     * Validate a value
     *
     * @param mixed $value
     * @param array $configuration
     *
     * @throws \Jb\Bundle\FileUploaderBundle\Exception\ValidationException
     */
    public function validate($value, array $configuration);
}
