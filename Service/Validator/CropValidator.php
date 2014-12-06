<?php

/**
 * Copyright 2014 Jonathan Bouzekri. All rights reserved.
 *
 * @copyright Copyright 2014 Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license https://github.com/jbouzekri/FileUploaderBundle/blob/master/LICENSE
 * @link https://github.com/jbouzekri/FileUploaderBundle
 */

namespace Jb\Bundle\FileUploaderBundle\Service\Validator;

use Jb\Bundle\FileUploaderBundle\Exception\ValidationException;

/**
 * CropValidator
 *
 * @author jobou
 */
class CropValidator extends AbstractImageValidator
{
    /**
     * {@inheritdoc}
     */
    protected function extractWidthHeight($value)
    {
        if (empty($value) || !isset($value['width']) || !isset($value['height'])) {
            throw new ValidationException('Unable to determine size.');
        }

        return array(
            'width' => (int) $value['width'],
            'height' => (int) $value['height']
        );
    }
}
