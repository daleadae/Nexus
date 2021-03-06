<?php

namespace Nexus\CoreBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CharactersRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CharactersRepository extends EntityRepository
{
	public function getLeaderBoard()
	{
		// On utilise le QueryBuilder créé par le repository directement pour gagner du temps
		// Plus besoin de faire le select() ni le from() par la suite donc
		$qb = $this->createQueryBuilder('c');

		$qb->leftJoin('c.user', 'u')
		   ->addSelect('u')
		   ->orderBy('c.experience', 'DESC');

		return $qb->getQuery()
		          ->getResult();
	}
}
