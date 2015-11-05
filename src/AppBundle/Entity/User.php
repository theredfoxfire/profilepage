<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\Table(name="user")
 */
class User implements UserInterface
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer", name="id")
	 */
	private $id;
	
	/**
	 * @ORM\Column(type="string", unique=true, length=255, name="username")
	 */
	private $username;
	
	/**
	 * @ORM\Column(type="string", name="password")
	 */
	private $password;
	
	/**
	 * @ORM\Column(type="json_array", name="roles")
	 */
	private $roles = array();
	
	private $salt;
	
	/**
	 * @ORM\OneToMany(
     *      targetEntity="Profile",
     *      mappedBy="user"
     * )
	 */
	protected $profiles;
	
	public function __construct()
	{
		$this->profiles = new ArrayCollection();
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getUsername()
	{
		return $this->username;
	}
	
	public function setUsername($username)
	{
		$this->username = $username;
	}
	
	public function getPassword()
	{
		return $this->password;
	}
	
	public function setPassword($password)
	{
		$this->password = $password;
	}
	
	public function getRoles()
	{
		$roles = $this->roles;
		
		if (empty($roles)) {
			$roles[] = 'ROLE_USER';
		}
		
		return array_unique($roles);
	}
	
	public function setRoles($roles)
	{
		$this->roles = $roles;
	}
	
	public function getSalt()
	{
		return $this->salt;
	}
	
	public function setSalt()
	{
		$this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
	}
	
	public function eraseCredentials()
	{
		
	}
	
	public function getProfile()
	{
		return $this->profiles;
	}
	
	public function addProfile(Profile $profile)
	{
		$this->profiles->add($profile);
		$profile->setUser($this);
	}
}
