<?php

namespace Courtyard\Bundle\ForumBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class CourtyardForumExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        foreach (array('forms.yml', 'services.yml', 'controllers.yml', 'repositories.yml') as $file) {
            $loader->load($file);
        }

        foreach (array('board', 'topic', 'post') as $entityName) {
            $container->setParameter("courtyard_forum.entity_class.$entityName", $config["{$entityName}_class"]);

            if ($entityName != 'board') {
                if (!empty($config[$entityName . 's_per_page'])) {
                    $container->setParameter("courtyard_forum.pagination.{$entityName}s_per_page", $config["{$entityName}s_per_page"]);
                }
            }
        }
    }
}
