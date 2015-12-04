<?php

namespace DaybreakStudios\Bundle\AirbrakeBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class DaybreakStudiosAirbrakeExtension extends Extension
{
	/**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
		$loader->load('parameters.yml');
        $loader->load('services.yml');

		$container->setParameter('daybreak_studios_airbrake.api_key', $config['api_key']);
		$container->setParameter('daybreak_studios_airbrake.project_id', $config['project_id']);
		$container->setParameter('daybreak_studios_airbrake.ignored_exceptions', $config['ignored_exceptions']);
		$container->setParameter('daybreak_studios_airbrake.host', $config['host']);
    }
}
