<?php

/**
 * Copyright 2014 Jonathan Bouzekri. All rights reserved.
 *
 * @copyright Copyright 2014 Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license https://github.com/jbouzekri/FileUploaderBundle/blob/master/LICENSE
 * @link https://github.com/jbouzekri/FileUploaderBundle
 */

namespace Jb\Bundle\FileUploaderBundle\Controller;

use Jb\Bundle\FileUploaderBundle\Form\Type\CropType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * CropController
 *
 * @author jobou
 */
class CropController extends Controller
{
    /**
     * Filter for croping
     *
     * @param Request $request
     * @param string $endpoint
     *
     * @return JsonResponse
     */
    public function filterAction(Request $request, $endpoint)
    {
        $form = $this->createForm(CropType::class);

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
