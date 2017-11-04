<?php

namespace LdapUiBundle\Controller;

use LdapTools\Query\LdapQueryBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ObjectController extends Controller
{
    /**
     * @Route("/object/show/{dn}", name="object_show")
     * @Template
     */
    public function showAction(Request $request, $dn)
    {
        $ldapManager = $this->get('ldap_tools.ldap_manager');


        $lqb = new LdapQueryBuilder();

        $object = $ldapManager->buildLdapQuery()
            ->setScopeBase()
            ->setBaseDn($dn)
            ->where($lqb->filter()->like('objectclass', '*'))
            ->getLdapQuery()
            ->getSingleResult();

        var_dump($object->getObjectClass());

        if(count($object) == 0) {
            throw new HttpException(
                Response::HTTP_NOT_FOUND,
                $this->get('translator')->trans('Object not found.')
            );
        }

        return [
            'object' => $object,
        ];
    }
}
