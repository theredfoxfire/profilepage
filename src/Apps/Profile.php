<?php

namespace Apps;

class Profile
{
	protected $name;
	protected $user;
	
	public function __construct($name, ProfileUser $user)
	{
		$this->name = $name;
		$this->user = $user;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function getUser()
	{
		return $this->manager;
	}
}
