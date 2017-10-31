<?php

namespace LdapUiBundle;

use LdapUiBundle\DependencyInjection\Compiler\ParametersCompilerPass;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class LdapUiBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ParametersCompilerPass(), PassConfig::TYPE_AFTER_REMOVING);
    }
}
