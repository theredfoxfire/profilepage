<?php

namespace Apps;

interface ProfileRepositoryInterface
{
	public function save(Profile $profile);
	public function getUserProfile(ProfileUser $user);
}
