<?php

/**
 * Copyright 2014 Jonathan Bouzekri. All rights reserved.
 *
 * @copyright Copyright 2014 Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license https://github.com/jbouzekri/FileUploaderBundle/blob/master/LICENSE
 * @link https://github.com/jbouzekri/FileUploaderBundle
 */

namespace Jb\Bundle\FileUploaderBundle\Service\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * FileOwner
 *
 * @author jobou
 * @Annotation
 */
class FileOwner extends Constraint
{
    /**
     * @var string
     */
    public $message = 'You do not own the submitted file "%filename%".';

    /**
     * {@inheritdoc}
     */
    public function validatedBy()
    {
        return 'jb_file_owner';
    }
}
