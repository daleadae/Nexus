<?php

namespace Nexus\CoreBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * FightLogRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FightLogRepository extends EntityRepository
{
	public function getLastLog($limit = 10)
	{
		// On utilise le QueryBuilder créé par le repository directement pour gagner du temps
		// Plus besoin de faire le select() ni le from() par la suite donc
		$qb = $this->createQueryBuilder('l');

		$qb->leftJoin('l.character', 'c')
		   ->addSelect('c')
		   ->leftJoin('c.user', 'u')
		   ->addSelect('u')
		   ->leftJoin('l.monster', 'm')
		   ->addSelect('m')
		   ->orderBy('l.date', 'DESC')
		   ->setFirstResult(0)
		   ->setMaxResults($limit);

		return $qb->getQuery()
		          ->getResult();
	}
}
