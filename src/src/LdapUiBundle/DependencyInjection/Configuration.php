<?php

namespace LdapUiBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @var bool Whether or not debug mode is in use.
     */
    protected $debug;

    /**
     * @param bool $debug
     */
    public function __construct($debug)
    {
        $this->debug = (bool) $debug;
    }

    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ldap_ui');
        $this->addHideSection($rootNode);
        $this->addAclSection($rootNode);

        return $treeBuilder;
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    protected function addHideSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('hide')
                ->arrayPrototype()
                ->children()
                    ->arrayNode('objects')
                    ->info('Hide LDAP Objects in the UI')->end()
                    ->arrayNode('attributes')
                    ->info('Hide LDAP Attributes in the UI')->end()
                ->end()
        ->end();
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    protected function addAclSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('acls')
                ->children()
                    ->arrayNode('objects')
                    ->arrayPrototype()
                    ->children()
                        ->arrayNode('deny')
                        ->arrayPrototype()
                        ->children()
                            ->arrayNode('objects')
                            ->arrayPrototype()
                            ->children()
                                ->arrayNode('view')->end()
                                ->arrayNode('create')->end()
                                ->arrayNode('edit')->end()
                                ->arrayNode('delete')->end()
                            ->arrayNode('attributes')
                            ->arrayPrototype()
                            ->children()
                                ->arrayNode('view')->end()
                                ->arrayNode('create')->end()
                                ->arrayNode('edit')->end()
                                ->arrayNode('delete')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
        ->end();
    }
}
