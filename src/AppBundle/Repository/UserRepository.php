<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\User;


class UserRepository extends EntityRepository
{
	public function getPersonList()
	{
		return $this->
		createQueryBuilder('p')
		->select('p')
		->orderBy('p.username')
		->getQuery()
		->getResult();
	}
}
