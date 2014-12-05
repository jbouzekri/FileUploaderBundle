<?php

/**
 * Copyright 2014 Jonathan Bouzekri. All rights reserved.
 *
 * @copyright Copyright 2014 Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 * @license https://github.com/jbouzekri/FileUploaderBundle/blob/master/LICENSE
 * @link https://github.com/jbouzekri/FileUploaderBundle
 */

/**
 * @namespace
 */
namespace Jb\Bundle\FileUploaderBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\Reference;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class JbFileUploaderExtension extends Extension
{
    /**
     * @var array
     */
    protected $factories = null;

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();

        // first assemble the resolver factories
        $factoryConfig = new ResolverFactoryConfiguration();
        $config        = $processor->processConfiguration($factoryConfig, $configs);
        $factories     = $this->createResolverFactories($config, $container);

        $config = $this->processConfiguration(new MainConfiguration($factories), $configs);
        $this->loadConfiguration($container, $config);

        $resolvers = array();
        foreach ($config['resolvers'] as $name => $resolver) {
            $resolvers[$name] = $this->createResolver($name, $resolver, $container, $factories);
        }

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('form_types.yml');
        $loader->load('resolvers.yml');
        $loader->load('services.yml');
        $loader->load('validators.yml');

        $resolverChain = $container->findDefinition('jb_fileuploader.resolver_chain');

        foreach ($resolvers as $name => $resolver) {
            $resolverChain->addMethodCall('addResolver', array(new Reference($resolver), $name));
        }
    }

    /**
     * Load configuration
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     * @param array $config
     */
    protected function loadConfiguration(ContainerBuilder $container, array $config)
    {
        $container->setParameter('jb_fileuploader.endpoints', $config);
        $container->setParameter('jb_fileuploader.crop_route', $config['crop_route']);
    }

    /**
     * Creates the resolver factories
     *
     * @param  array            $configs
     * @param  ContainerBuilder $container
     *
     * @return null|array
     */
    protected function createResolverFactories(array $configs, ContainerBuilder $container)
    {
        if (null !== $this->factories) {
            return $this->factories;
        }

        // load bundled resolver factories
        $tempContainer = new ContainerBuilder();
        $parameterBag  = $container->getParameterBag();
        $loader        = new Loader\YamlFileLoader($tempContainer, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('resolver_factories.yml');

        // load user-created resolver factories
        foreach ($configs['resolver_factories'] as $factory) {
            $loader->load($parameterBag->resolveValue($factory));
        }

        $services  = $tempContainer->findTaggedServiceIds('jb_fileuploader.resolver.factory');

        $factories = array();
        foreach (array_keys($services) as $id) {
            $factory = $tempContainer->get($id);
            $factories[str_replace('-', '_', $factory->getKey())] = $factory;
        }

        return $this->factories = $factories;
    }

    /**
     * Create resolver
     *
     * @param string $name
     * @param array $config
     * @param ContainerBuilder $container
     * @param array $factories
     *
     * @return string
     *
     * @throws \LogicException
     */
    protected function createResolver($name, array $config, ContainerBuilder $container, array $factories)
    {
        foreach ($config as $key => $resolver) {
            if (array_key_exists($key, $factories)) {
                $id = sprintf('jb_fileuploader.%s_resolver', $name);
                $factories[$key]->create($container, $id, $resolver);

                return $id;
            }
        }

        throw new \LogicException(sprintf('The resolver \'%s\' is not configured.', $name));
    }
}
