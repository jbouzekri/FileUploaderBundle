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

        if ($form->isValid()) {
            $data = $form->getData();
            var_dump($data);

            return new JsonResponse(
                array(
                    $this->get('translator')->trans('Valid')
                )
            );
        }

        // If not processed in valid if. Then form error.
        return new JsonResponse(
            array(
                $this->get('translator')->trans('Invalid crop parameters')
            ),
            400
        );
    }
}
