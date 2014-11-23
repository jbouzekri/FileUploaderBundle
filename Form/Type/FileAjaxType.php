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
use Jb\Bundle\FileUploaderBundle\Service\FileHistoryManagerInterface;

/**
 * FileAjaxType
 */
class FileAjaxType extends AbstractType
{
    /**
     * @var FileHistoryManagerInterface
     */
    protected $fileHistoryManager;

    /**
     * Constructor
     *
     * @param \Jb\Bundle\FileUploaderBundle\Form\Type\FileHistoryManagerInterface $fileHistoryManager
     */
    public function __construct(FileHistoryManagerInterface $fileHistoryManager)
    {
        $this->fileHistoryManager = $fileHistoryManager;
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        // Endpoint mandatory for fileupload bundle
        $resolver->setRequired(array('endpoint'));

        $resolver->setOptional(array('display_link'));
        $resolver->setDefaults(array(
            'display_link' => true
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $fileHistory = null;
        $fileHistoryUrl = null;
        if ($form->getData() !== null) {
            $fileHistory = $this->fileHistoryManager->findOneByFileName($form->getData());
            $fileHistoryUrl = $this->fileHistoryManager->getUrl($fileHistory);
        }

        $className = 'result_filename';
        if (isset($view->vars['attr']['class'])) {
            $view->vars['attr']['class'] .= ' ' . $className;
        } else {
            $view->vars['attr']['class'] = $className;
        }

        $view->vars['file_history'] = $fileHistory;
        $view->vars['file_history_url'] = $fileHistoryUrl;
        $view->vars['endpoint'] = $options['endpoint'];
        $view->vars['display_link'] = $options['display_link'];
    }

    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return 'text';
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'jb_file_ajax';
    }
}