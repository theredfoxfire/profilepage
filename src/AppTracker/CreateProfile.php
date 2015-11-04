<?php

namespace AppTracker;

use Apps\Profile;
use Apps\ProfileRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CreateProfile
{
	const SUCCESS = 'app_tracker.profile_creation_success';
	const FAILURE = 'app_tracker.profile_creation_failure';
	
	private $repository;
	private $dispatcher;
	
	public function __construct(ProfileRepositoryInterface $repository, EventDispatcherInterface $dispatcher)
	{
		$this->repository = $repository;
		$this->dispatcher = $dispatcher;
	}
	
	public function createProfile(Profile $profile)
	{
		if (!$profile->getName()) {
			$this->dispatcher->dispatcher(self::FAILURE, new Event([
				'profile' => $profile,
				'reason' => 'Profile tidak ada namanya.'
			]));
			
			return;
		}
		
		$this->repository->save($profile);
		$this->dispatcher->dispatch(self::SUCCESS, new Event(['profile' => $profile]));
	}
}
