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
 * AbstractImageValidator
 *
 * @author jobou
 */
abstract class AbstractImageValidator extends AbstractValidator
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
        if (!isset($configuration['MinWidth']) && !isset($configuration['MaxWidth'])
            && !isset($configuration['MinHeight']) && !isset($configuration['MaxHeight'])
            && !isset($configuration['MinRatio']) && !isset($configuration['MaxRatio'])
        ) {
            return;
        }

        // Extract width height from value
        $size = $this->extractWidthHeight($value);

        // Validate
        $this->isValid($size['width'], $size['height'], $configuration);
    }

    /**
     * Extract width and height from value
     *
     * @return array associative with key width and height
     */
    abstract protected function extractWidthHeight($value);

    /**
     * Common image/crop validator check
     *
     * @param int $width
     * @param int $height
     * @param array $configuration
     *
     * @throws ValidationException
     */
    protected function isValid($width, $height, array $configuration)
    {
        if (isset($configuration['MinWidth']) && $this->validateConfig('MinWidth', $configuration)) {
            if ($width < $configuration['MinWidth']) {
                throw new ValidationException('Minimum width must be '.$configuration['MinWidth'].'px');
            }
        }

        if (isset($configuration['MaxWidth']) && $this->validateConfig('MaxWidth', $configuration)) {
            if ($width > $configuration['MaxWidth']) {
                throw new ValidationException('Maximum width must be '.$configuration['MaxWidth'].'px');
            }
        }

        if (isset($configuration['MinHeight']) && $this->validateConfig('MinHeight', $configuration)) {
            if ($height < $configuration['MinHeight']) {
                throw new ValidationException('Minimum height must be '.$configuration['MinHeight'].'px');
            }
        }

        if (isset($configuration['MaxHeight']) && $this->validateConfig('MaxHeight', $configuration)) {
            if ($height > $configuration['MaxHeight']) {
                throw new ValidationException('Minimum height must be '.$configuration['MaxHeight'].'px');
            }
        }

        $ratio = round($width / $height, 2);

        if (isset($configuration['MinRatio']) && $this->validateConfig('MinRatio', $configuration, true)) {
            if ($ratio < $configuration['MinRatio']) {
                throw new ValidationException('Minimum ratio must be '.$configuration['MinRatio']);
            }
        }

        if (isset($configuration['MaxRatio']) && $this->validateConfig('MaxRatio', $configuration, true)) {
            if ($ratio < $configuration['MaxRatio']) {
                throw new ValidationException('Maximum ratio must be '.$configuration['MaxRatio']);
            }
        }
    }

    /**
     * Validate configuration value
     *
     * @param string $key
     * @param array $configuration
     * @param bool $isFloat
     *
     * @return bool
     *
     * @throws ValidationException
     */
    protected function validateConfig($key, array $configuration, $isFloat = false)
    {
        if (!$isFloat && !ctype_digit((string) $configuration[$key])) {
            throw new ValidationException(sprintf('"%s" is not a valid %s configuration', $configuration[$key], $key));
        }

        if ($isFloat && !is_numeric((string) $configuration[$key])) {
            throw new ValidationException(sprintf('"%s" is not a valid %s configuration', $configuration[$key], $key));
        }

        return true;
    }
}
