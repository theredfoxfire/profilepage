<?php

namespace AppTracker\Apps;

use Apps\ProfileRepositoryInterface;
use Apps\Profile;
use Apps\ProfileUser;

class InMemoryProfileRepository implements ProfileRepositoryInterface
{
	private $profile = [];
	
	public function save(Profile $profile)
	{
		$user = $profile->getUser();
		
		if (!isset($this->profile[$user->getName()])) {
			$this->profile[$user->getName()] = [];
		}
		
		$this->profile[$user->getName()][] = $profile;
	}
	
	public function getUserProfile(ProfileUser $user)
	{
		if (!isset($this->profile[$user->getName()])) {
			return [];
		}
		
		return $this->profile[$user->getName()];
	}
}
