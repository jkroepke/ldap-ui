<?php

namespace LdapUiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use LdapTools\Bundle\LdapToolsBundle\Factory\LdapFactory;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @Template
     * @param Request $request
     * @param AuthenticationUtils $authUtils
     * @return array
     */
    public function loginAction(Request $request, AuthenticationUtils $authUtils)
    {
        $ldapFactory = new LdapFactory();

        $availableDomainsLabels = $this->get('ldap_tools.ldap_manager')->getDomains();
        $availableDomains = [];

        foreach($availableDomainsLabels as $domain) {
            $availableDomains[$domain] = $ldapFactory->getConfig($domain)->getDomainName();
        }

        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        return [
            'availableDomains' => $availableDomains,
            'error' => $error,
            'lastUsername' => $lastUsername,
        ];
    }
}
