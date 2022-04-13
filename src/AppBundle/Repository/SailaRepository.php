<?php

namespace AppBundle\Repository;

use Doctrine\ORM\Query\Expr\Orx;

/**
 * SailaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SailaRepository extends \Doctrine\ORM\EntityRepository
{

    public function findUsersBySailaRoles($roles)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('s')
            ->from('AppBundle:Saila', 's');

        $conditions = [];
        foreach ( $roles as $index => $role ) {
            $conditions[] = "UPPER(s.rola) LIKE :role$index";
            $qb->setParameter("role$index", '%' . strtoupper($role) . '%');
        }

        if (empty($conditions)) {
            throw new \LogicException('Conditions are empty.');
        }

        $qb->andWhere(new Orx($conditions));

        return $qb->getQuery()->execute();
    }

}
