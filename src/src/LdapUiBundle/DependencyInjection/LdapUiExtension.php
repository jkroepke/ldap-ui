<?php

namespace LdapUiBundle\DependencyInjection;

use LdapUiBundle\DependencyInjection\Configuration;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class LdapUiExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration($container->getParameter('kernel.debug'));

        $config = $this->processConfiguration($configuration, $configs);

        // $container->setDefinition('ldap.acl', new Definition());
    }
}
