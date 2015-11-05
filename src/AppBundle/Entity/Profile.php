<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Profile
 * @ORM\Table(name="profile")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProfileRepository")
 */
class Profile
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer", name="id")
	 */
	private $id;
	
	/**
	 * @ORM\Column(type="string", length=255, name="name")
	 * @Assert\NotBlank()
	 */
	private $name;
	
	/**
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="profiles")
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
	 */
	private $user;
	
	public function getId()
	{
		return $this->id;
	}
	
	public function setName($name)
	{
		$this->name = $name;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function getUser()
	{
		return $this->user;
	}
	
	public function setUser(User $user = null)
	{
		$this->user = $user;
	}
}
