<?php

/**
 * Copyright 2014 Jonathan Bouzekri. All rights reserved.
 *
 * @copyright Copyright 2014 Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license https://github.com/jbouzekri/ConfigKnpMenuBundle/blob/master/LICENSE
 * @link https://github.com/jbouzekri/ConfigKnpMenuBundle
 */

namespace Jb\Bundle\FileUploaderBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * JbFileUploaderBundle bundle
 *
 * @author Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 */
class JbFileUploaderBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new DependencyInjection\Compiler\ResolverCompilerPass());
        $container->addCompilerPass(new DependencyInjection\Compiler\ValidatorCompilerPass());
    }
}
