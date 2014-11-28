<?php

/**
 * Copyright 2014 Jonathan Bouzekri. All rights reserved.
 *
 * @copyright Copyright 2014 Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license https://github.com/jbouzekri/FileUploaderBundle/blob/master/LICENSE
 * @link https://github.com/jbouzekri/FileUploaderBundle
 */

namespace Jb\Bundle\FileUploaderBundle\Service\Validator;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Jb\Bundle\FileUploaderBundle\Exception\ValidationException;

/**
 * ImageValidator
 *
 * @author jobou
 */
class ImageValidator extends AbstractValidator
{
    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setOptional(array(
            'MinWidth',
            'MaxWidth',
            'MinHeight',
            'MaxHeight',
            'MinRatio',
            'MaxRatio'
        ));
    }

    /**
     * {@inheritdoc}
     */
    protected function validate($value, array $configuration)
    {
        // No configuration. Do nothing
        if (
            !isset($configuration['MinWidth']) && !isset($configuration['MaxWidth'])
            && !isset($configuration['MinHeight']) && !isset($configuration['MaxHeight'])
            && !isset($configuration['MinRatio']) && !isset($configuration['MaxRatio'])
        ) {
            return;
        }

        $size = @getimagesize($this->formatValue($value));

        if (empty($size) || ($size[0] === 0) || ($size[1] === 0)) {
            throw new ValidationException('Unable to determine size.');
        }
    }
}
