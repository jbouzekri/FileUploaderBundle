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
 * FileAjaxType
 */
class ImageAjaxType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        // Endpoint mandatory for fileupload bundle
        $resolver->setRequired(array('img_width'));
        $resolver->setOptional(array('default_image'));

        $resolver->replaceDefaults(
            array(
                'img_width' => 100,
                'default_image' => 'bundles/jbfileuploader/img/default.png'
            )
        );
    }

    /**
     * {@inheritDoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['display_link'] = false;
        $view->vars['img_width'] = $options['img_width'];
        $view->vars['default_image'] = $options['default_image'];
    }

    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return 'jb_file_ajax';
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'jb_image_ajax';
    }
}
