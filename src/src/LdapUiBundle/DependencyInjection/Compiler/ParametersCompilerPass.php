<?php

/**
 * ParametersCompilerPass.php
 *
 * Loads symfony configuration from database
 *
 * @category   DependencyInjection
 * @package    LdapUi
 * @author     Jan-Otto Kröpke
 * @copyright  2017 Jan-Otto Kröpke
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */

# https://stackoverflow.com/questions/28713495/how-to-load-symfonys-config-parameters-from-database-doctrine
namespace LdapUiBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ParametersCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $em = $container->get('doctrine.orm.default_entity_manager');
        # $paypal_params = $em->getRepository('featureBundle:paymentGateways')->findAll();
        # $container->setParameter('paypal_data', $paypal_params);
    }
}