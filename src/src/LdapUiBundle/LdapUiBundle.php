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

class LdapUiBundle extends Bundle
{
    /**
     * @return string
     */
#    public function getParent()
#    {
#        return 'TwigBundle';
#    }

    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
    }
}
