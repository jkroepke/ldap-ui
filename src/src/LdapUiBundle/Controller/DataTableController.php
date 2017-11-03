<?php

namespace LdapUiBundle\Controller;

use LdapTools\Object\LdapObjectType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use LdapTools\Bundle\LdapToolsBundle\Factory\LdapFactory;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class DataTableController extends Controller
{
    /**
     * @Route("/datatable", name="datatable", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function dataTableAction(Request $request)
    {
        $ldapManager = $this->get('ldap_tools.ldap_manager');
        $baseDn = $request->query->get('baseDn');
        if (empty($baseDn)) {
            $baseDn = $ldapManager->getConnection()->getConfig()->getBaseDn();
        }

        $response = [];
        $requestedColumns = $request->request->get('columns');

        $attributes = [];
        foreach($requestedColumns as $column) {
            $attributes[] = $column['data'];
        }

        $objects = $ldapManager->buildLdapQuery()
            ->setScopeOneLevel()
            ->select($attributes)
            ->setBaseDn($baseDn)
            ->getLdapQuery()->getResult();

        var_dump($objects);exit;

        foreach($objects as $object) {
            $objectReturn = [];
            foreach($requestedColumns as $column) {
                $method = 'get'.ucfirst($column['data']);
                $objectReturn[$column['data']] = $object->{$method}();
            }

            $response[] = $objectReturn;
        }


        return new JsonResponse(['data' => $response]);
    }
}