<?php

/**
 * LdapUi
 *
 * @category   Bundle
 * @package    LdapUi
 * @author     Jan-Otto Kröpke
 * @copyright  2017 Jan-Otto Kröpke
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace LdapUiBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use LdapUiBundle\DependencyInjection\LdapUiExtension;

class LdapUiBundle extends Bundle
{
    /**
     * @return string
     */
    public function getParent()
    {
        return 'LdapToolsBundle';
    }

    public function getContainerExtension()
    {
        return new LdapUiExtension();
    }

    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
    }
}
