<?php

namespace Courtyard\Bundle\ForumBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('courtyard_forum');

        $rootNode
            ->children()
                ->scalarNode('board_class')
                    ->defaultValue('Courtyard\Bundle\ForumBundle\Entity\Board')
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('topic_class')
                    ->defaultValue('Courtyard\Bundle\ForumBundle\Entity\Topic')
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('post_class')
                    ->defaultValue('Courtyard\Bundle\ForumBundle\Entity\Post')
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('topics_per_page')
                    ->defaultValue(25)
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('posts_per_page')
                    ->defaultValue(40)
                    ->cannotBeEmpty()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}