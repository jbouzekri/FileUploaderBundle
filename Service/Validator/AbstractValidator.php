<?php

/**
 * Copyright 2014 Jonathan Bouzekri. All rights reserved.
 *
 * @copyright Copyright 2014 Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license https://github.com/jbouzekri/FileUploaderBundle/blob/master/LICENSE
 * @link https://github.com/jbouzekri/FileUploaderBundle
 */

namespace Jb\Bundle\FileUploaderBundle\Service\Validator;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * AbstractValidator
 *
 * @author jobou
 */
abstract class AbstractValidator
{
    /**
     * Configure the validator
     *
     * @param OptionsResolverInterface $resolver
     */
    protected function configureOptions(OptionsResolverInterface $resolver)
    {
    }

    /**
     * Apply the validator
     *
     * @param mixed $value
     * @param array $configuration
     *
     * @throws \Jb\Bundle\FileUploaderBundle\Exception\ValidationException
     */
    public function applyValidator($value, array $configuration)
    {
        // Validate configuration
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);
        $configuration = $resolver->resolve($configuration);

        $this->validate($value, $configuration);
    }

    /**
     * Extract the value used in the validator
     *
     * @param mixed $value
     */
    protected function formatValue($value)
    {
        if ($value instanceof \SplFileInfo) {
            return $value->getPathname();
        }

        return $value;
    }

    /**
     * Validate a value
     *
     * @param mixed $value
     * @param array $configuration
     *
     * @throws \Jb\Bundle\FileUploaderBundle\Exception\ValidationException
     */
    abstract protected function validate($value, array $configuration);
}
