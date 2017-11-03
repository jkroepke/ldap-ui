<?php

namespace LdapUiBundle\Controller;

use LdapTools\Object\LdapObjectType;
use LdapTools\Query\LdapQueryBuilder;
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
        $baseDn = $request->request->get('baseDn');
        if (empty($baseDn)) {
            $baseDn = $ldapManager->getConnection()->getConfig()->getBaseDn();
        }

        $response = ['data' => []];
        $requestedColumns = $request->request->get('columns');

        $attributes = [];
        foreach($requestedColumns as $column) {
            $attributes[] = $column['data'];
        }

        $lqb = new LdapQueryBuilder();

        $objects = $ldapManager->buildLdapQuery()
            ->setScopeOneLevel()
            ->select($attributes)
            ->where($lqb->filter()->like('objectclass', '*'))
            ->setBaseDn($baseDn)
            ->getLdapQuery()->getResult();


        foreach($objects as $object) {
            $objectReturn = [];
            foreach($requestedColumns as $column) {
                $field = $column['data'];

                if ($field == 'actions') {
                    $objectReturn[$field] = $this->getActions($object);
                } else {
                    $method = 'get'.ucfirst($field);
                    $objectReturn[$field] = $object->{$method}();
                }
            }

            $response['data'][] = $objectReturn;
        }

        if (empty($response['data'])) {
            return new JsonResponse($response);
        }

        $orders = $request->request->get('order');

        $cmp = function($key, $dir) {
            return function ($a, $b) use ($key, $dir) {
                $str1 = is_array($a[$key]) ? join(',', $a[$key]) : $a[$key];
                $str2 = is_array($b[$key]) ? join(',', $b[$key]) : $b[$key];

                return strnatcmp($str1, $str2) * ($dir == 'asc' ? 1 : -1);
            };
        };

        foreach ($orders as $order)
        {
            usort($response['data'], $cmp($requestedColumns[$order['column']]['data'], $order['dir']));
        }

        return new JsonResponse($response);
    }

    private function getActions($object) {
        return join(' ', [
            '<a href="#" class="edit" data-dn="'.$object->getDn().'"><i class="fa fa-pencil" aria-hidden="true"></i></a>',
            '<a href="#" class="edit" data-dn="'.$object->getDn().'"><i class="fa fa-trash" aria-hidden="true"></i></a>'
        ]);
    }
}
