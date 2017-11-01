<?php

namespace LdapUiBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class LdapUiExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration($container->getParameter('kernel.debug'));
        $config = $this->processConfiguration($configuration, $configs);

        $this->setLdapConfigDefinition($container, $config);
    }

    /**
     * @param ContainerBuilder $container
     * @param array $config
     */
    protected function setLdapConfigDefinition(ContainerBuilder $container, array $config)
    {
        $ldapCfg = ['general' => $config['general']];

        // Only tag the cache warmer if there are domains listed in the config...
        if (isset($config['domains']) && !empty($config['domains'])) {
            $ldapCfg['domains'] = $config['domains'];
            $container->getDefinition('ldap_tools.cache_warmer.ldap_tools_cache_warmer')->addTag('kernel.cache_warmer');
        } else {
            $container->getDefinition('data_collector.ldap_tools')->replaceArgument(0, null);
        }

        $definition = $container->getDefinition('ldap_tools.configuration');
        $definition->addMethodCall('loadFromArray', [$ldapCfg]);
        $definition->addMethodCall('setEventDispatcher', [new Reference('ldap_tools.event_dispatcher')]);
    }
}
