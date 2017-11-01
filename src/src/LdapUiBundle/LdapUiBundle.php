<?php

/**
 * LdapUi
 *
 * @category   DependencyInjection
 * @package    LdapUi
 * @author     Jan-Otto Kröpke
 * @copyright  2017 Jan-Otto Kröpke
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace LdapUiBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class LdapUiBundle extends Bundle
{
    public function getParent()
    {
        return 'LdapToolsBundle';
    }
}
