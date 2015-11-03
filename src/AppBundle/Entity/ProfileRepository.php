<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Apps\Profile as BaseProfile;
use Apps\ProfileUser as BaseProfileUser;
use Apps\ProfileRepositoryInterface;

class ProfileRepository extends EntityRepository implements ProfileRepositoryInterface
{
	public function save(BaseProfile $profile)
	{
		$this->_em->persist($profile);
		$this->_em->flush();
	}
	
	public function getUserProfile(BaseProfileUser $user)
	{
		return $this->findBy(['manager' => $manager]);
	}
}
