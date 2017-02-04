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
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
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
            ->add('x', IntegerType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Range(['min' => 0]),
                ]
            ])
            ->add('y', IntegerType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Range(['min' => 0]),
                ]
            ])
            ->add('width', IntegerType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Range(['min' => 0]),
                ]
            ])
            ->add('height', IntegerType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Range(['min' => 0]),
                ]
            ])
            ->add('filename', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ]
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
        ));
    }
}
