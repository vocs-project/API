<?php

namespace VOCS\PlatformBundle\Repository;

use VOCS\PlatformBundle\Entity\User;

/**
 * WordTradUserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class WordTradUserRepository extends \Doctrine\ORM\EntityRepository
{
    public function getWordTradUserHardList(User $user) {
        $qb = $this->createQueryBuilder('wtu');
        return $qb

            ->where('wtu.badRepetition > 2')
            ->andWhere('wtu.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }

}
