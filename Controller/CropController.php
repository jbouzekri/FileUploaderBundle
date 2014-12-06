<?php

/**
 * Copyright 2014 Jonathan Bouzekri. All rights reserved.
 *
 * @copyright Copyright 2014 Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license https://github.com/jbouzekri/FileUploaderBundle/blob/master/LICENSE
 * @link https://github.com/jbouzekri/FileUploaderBundle
 */

namespace Jb\Bundle\FileUploaderBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * CropController
 *
 * @author jobou
 */
class CropController extends \Symfony\Bundle\FrameworkBundle\Controller\Controller
{
    /**
     * Filter for croping
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function filterAction(Request $request, $endpoint)
    {
        $form = $this->createForm('jb_fileuploader_crop');

        $form->handleRequest($request);

        // Form invalid. Exit.
        if (!$form->isValid()) {
            return $this->createErrorResponse(
                $this->get('translator')->trans('Invalid crop parameters')
            );
        }

        // Else process crop
        try {
            return new JsonResponse(
                $this->get('jb_fileuploader.croper')->crop($endpoint, $form->getData())
            );
        } catch (\Exception $e) {
            return $this->createErrorResponse($e->getMessage());
        }
    }

    /**
     * Create error message
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    protected function createErrorResponse($message)
    {
        return new JsonResponse(
            array(
                'error' => $message
            ),
            400
        );
    }
}
