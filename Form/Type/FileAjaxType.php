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
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
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
     * @param FileHistoryManagerInterface $fileHistoryManager
     */
    public function __construct(FileHistoryManagerInterface $fileHistoryManager)
    {
        $this->fileHistoryManager = $fileHistoryManager;
    }
    
    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        // Endpoint mandatory for fileupload bundle
        $resolver->setRequired(array('endpoint'));
        
        $resolver->setDefined(array(
            'download_link',
            'remove_link',
            'loading_file',
            'resolver_key',
            'progress'
        ));
        
        $resolver->setDefaults(array(
            'download_link' => true,
            'remove_link' => true,
            'loading_file' => 'bundles/jbfileuploader/img/ajax-loader-small.gif',
            'resolver_key' => 'upload_resolver',
            'progress'=>false
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
            $fileHistoryUrl = $this->fileHistoryManager->getUrl($fileHistory, $options['resolver_key']);
        }
        
        $className = 'jb_result_filename';
        if (isset($view->vars['attr']['class'])) {
            $view->vars['attr']['class'] .= ' ' . $className;
        } else {
            $view->vars['attr']['class'] = $className;
        }
        
        $view->vars['file_history'] = $fileHistory;
        $view->vars['file_history_url'] = $fileHistoryUrl;
        $view->vars['endpoint'] = $options['endpoint'];
        $view->vars['download_link'] = $options['download_link'];
        $view->vars['remove_link'] = $options['remove_link'];
        $view->vars['loading_file'] = $options['loading_file'];
        $view->vars['progress'] = $options['progress'];
        $view->vars['use_crop'] = false;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return TextType::class;
    }
}
