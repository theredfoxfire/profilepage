<?php

namespace AppTracker;

use Apps\ProfileRepositoryInterface;
use Apps\ProfileUser;

class GetUserProfile
{
	private $repository;
	
	public function __construct(ProfileRepositoryInterface $repository)
	{
		$this->repository = $repository;
	}
	
	public function getUserProfile(ProfileUser $user)
	{
		return $this->repository->getUserProfile($user);
	}
}
