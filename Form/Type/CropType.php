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
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Range;

/**
 * CropType
 */
class CropType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('x', 'integer', array(
                'constraints' => array(new NotBlank(), new Range(array('min' => 0)))
            ))
            ->add('y', 'integer', array(
                'constraints' => array(new NotBlank(), new Range(array('min' => 0)))
            ))
            ->add('width', 'integer', array(
                'constraints' => array(new NotBlank(), new Range(array('min' => 0)))
            ))
            ->add('height', 'integer', array(
                'constraints' => array(new NotBlank(), new Range(array('min' => 0)))
            ))
            ->add('filename', 'text', array(
                'constraints' => array(new NotBlank())
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'jb_fileuploader_crop';
    }
}
