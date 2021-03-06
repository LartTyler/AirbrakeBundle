<?php

namespace DaybreakStudios\Bundle\AirbrakeBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
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

		if (isset($config['enabled']) && $config['enabled'] === true) {
			$definition = $container->getDefinition('daybreak_studios_airbrake.service.airbrake');
			$definition->addMethodCall('enable', [
				$config['api_key'],
				$config['project_id'],
				isset($config['ignored_exceptions']) ? $config['ignored_exceptions'] : [],
				isset($config['environment']) ? $config['environment'] : $container->getParameter('kernel.environment'),
				isset($config['version']) ? $config['version'] : null,
				isset($config['host']) ? $config['host'] : null
			]);
		}
    }
}
