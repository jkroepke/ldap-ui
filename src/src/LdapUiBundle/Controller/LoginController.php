<?php

namespace LdapUiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use LdapTools\Bundle\LdapToolsBundle\Factory\LdapFactory;

class LoginController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @Template
     */
    public function indexAction(Request $request)
    {
        $ldapFactory = new LdapFactory();

        $availableDomainsLabels = $this->get('ldap_tools.ldap_manager')->getDomains();
        $availableDomains = [];

        foreach($availableDomainsLabels as $domain) {
            $availableDomains[$domain] = $ldapFactory->getConfig($domain)->getDomainName();
        }

        return [
            'availableDomains' => $availableDomains
        ];
    }
}
