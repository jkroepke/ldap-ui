<?php

namespace LdapUiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use LdapTools\Bundle\LdapToolsBundle\Factory\LdapFactory;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class BrowserController extends Controller
{
    /**
     * @Route("/browser", name="browser")
     * @Template
     * @param Request $request
     * @return array
     */
    public function browserAction(Request $request)
    {
        return [];
    }

    /**
     * @Route("/browser/jstree", name="browser_jstree")
     * @param Request $request
     * @return JsonResponse
     */
    public function jsTreeAction(Request $request)
    {
        $ldapManager = $this->get('ldap_tools.ldap_manager');
        $response = [];

        if($request->query->get('id') === '#') {
            $response[] = [
                'id' => $ldapManager->getConnection()->getConfig()->getBaseDn(),
                'type' => 'root',
                'text' => $ldapManager->getConnection()->getConfig()->getDomainName(),
                'parent' => $request->query->get('id'),
                'children' => true,
            ];
        } else {
            $organisationUnits = $ldapManager->buildLdapQuery()->setScopeOneLevel()
                ->fromOUs()->setBaseDn($request->query->get('id'))->getLdapQuery()->getResult();

            foreach($organisationUnits as $organisationUnit) {
                $response[] = [
                    'id' => $organisationUnit->getDn(),
                    'text' => $organisationUnit->getName(),
                    'parent' => $request->query->get('id'),
                    'children' => true,
                ];
            }
        }
        return new JsonResponse($response);
    }
}
