<?php

namespace DaybreakStudios\Bundle\AirbrakeBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('daybreak_studios_airbrake');
		$settings = $rootNode->children();

		$settings
			->scalarNode('api_key')
			->end();

		$settings
			->integerNode('project_id')
				->min(0)
			->end();

		$settings
			->arrayNode('ignored_exceptions')
				->defaultValue([])
			->end();

		$settings
			->scalarNode('host')
				->defaultNull()
			->end();

        return $treeBuilder;
    }
}
