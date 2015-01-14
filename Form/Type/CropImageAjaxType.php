<?php

/**
 * Copyright 2014 Jonathan Bouzekri. All rights reserved.
 *
 * @copyright Copyright 2014 Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license https://github.com/jbouzekri/FileUploaderBundle/blob/master/LICENSE
 * @link https://github.com/jbouzekri/FileUploaderBundle
 */

namespace Jb\Bundle\FileUploaderBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

/**
 * CropImageAjaxType
 */
class CropImageAjaxType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setOptional(
            array(
                'max_width',
                'max_height',
                'reset_button',
                'reset_button_label',
                'confirm_button_label',
                'crop_options'
            )
        );

        $resolver->setDefaults(
            array(
                'resolver_key' => 'croped_resolver',
                'max_width' => 350,
                'max_height' => 350,
                'reset_button' => true,
                'reset_button_label' => 'Reset',
                'confirm_button_label' => 'Confirm',
                'crop_options' => array()
            )
        );
    }

    /**
     * {@inheritDoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['use_crop'] = true;
        $view->vars['max_width'] = $options['max_width'];
        $view->vars['max_height'] = $options['max_height'];
        $view->vars['reset_button'] = $options['reset_button'];
        $view->vars['reset_button_label'] = $options['reset_button_label'];
        $view->vars['confirm_button_label'] = $options['confirm_button_label'];
        $view->vars['crop_options'] = $options['crop_options'];
    }

    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return 'jb_image_ajax';
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'jb_crop_image_ajax';
    }
}
