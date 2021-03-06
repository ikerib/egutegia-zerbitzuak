<?php

namespace AppBundle\Repository;

use Doctrine\ORM\NonUniqueResultException;

/**
 * FirmaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FirmaRepository extends \Doctrine\ORM\EntityRepository
{
    public function ErabiltzaileakEskaeraFirmatzekeDu($userid, $firmaid)
    {
        $qm = $this->createQueryBuilder('f')
            ->innerJoin('f.firmadet', 'fd')
            ->innerJoin('fd.firmatzailea', 'u')
            ->where('u.id = :userid')
            ->andWhere('f.id=:firmaid')
            ->setParameter('userid', $userid)
            ->setParameter('firmaid', $firmaid)
        ;


        return $qm->getQuery()->getResult();
    }

    public function checkFirmaComplete($id)
    {
        $qb = $this->createQueryBuilder('f')
            ->innerJoin('f.firmadet', 'fd')
            ->where('fd.firmatua=false OR fd.firmatua is NULL')
            ->andWhere('f.id=:id')
            ->setParameter('id', $id)
            ->select('COUNT(fd.id) as zenbat')
        ;


        //dump($qb->getQuery()->getSQL());
        //dump($id);
        //  return $qb->getQuery()->getResult();

        return $qb->getQuery()->getSingleScalarResult();
    }

}
