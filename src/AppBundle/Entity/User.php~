<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * User
 */
class User implements AdvancedUserInterface, \Serializable
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var array
     */
    private $roles;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $salt;

    /**
     * @var \AppBundle\Entity\Profile
     */
    private $profile;

	public function __construct()
	{
		$this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
	}

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set roles
     *
     * @param array $roles
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return array 
     */
    public function getRoles()
    {
        $roles = $this->roles;
		
		if (empty($roles)) {
			$roles[] = 'ROLE_USER';
		}
		
		return array_unique($roles);
    }

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set profile
     *
     * @param \AppBundle\Entity\Profile $profile
     * @return User
     */
    public function setProfile(\AppBundle\Entity\Profile $profile = null)
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Get profile
     *
     * @return \AppBundle\Entity\Profile 
     */
    public function getProfile()
    {
        return $this->profile;
    }
    
    public function eraseCredentials()
    {
		
	}

    /**
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $education;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $url;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $workexperience;


    /**
     * Add education
     *
     * @param \AppBundle\Entity\Education $education
     * @return User
     */
    public function addEducation(\AppBundle\Entity\Education $education)
    {
        $this->education[] = $education;

        return $this;
    }

    /**
     * Remove education
     *
     * @param \AppBundle\Entity\Education $education
     */
    public function removeEducation(\AppBundle\Entity\Education $education)
    {
        $this->education->removeElement($education);
    }

    /**
     * Get education
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEducation()
    {
        return $this->education;
    }

    /**
     * Add url
     *
     * @param \AppBundle\Entity\Url $url
     * @return User
     */
    public function addUrl(\AppBundle\Entity\Url $url)
    {
        $this->url[] = $url;

        return $this;
    }

    /**
     * Remove url
     *
     * @param \AppBundle\Entity\Url $url
     */
    public function removeUrl(\AppBundle\Entity\Url $url)
    {
        $this->url->removeElement($url);
    }

    /**
     * Get url
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Add workexperience
     *
     * @param \AppBundle\Entity\WorkExperience $workexperience
     * @return User
     */
    public function addWorkexperience(\AppBundle\Entity\WorkExperience $workexperience)
    {
        $this->workexperience[] = $workexperience;

        return $this;
    }

    /**
     * Remove workexperience
     *
     * @param \AppBundle\Entity\WorkExperience $workexperience
     */
    public function removeWorkexperience(\AppBundle\Entity\WorkExperience $workexperience)
    {
        $this->workexperience->removeElement($workexperience);
    }

    /**
     * Get workexperience
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getWorkexperience()
    {
        return $this->workexperience;
    }
    /**
     * @var boolean
     */
    private $is_active;


    /**
     * Set is_active
     *
     * @param boolean $isActive
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->is_active = $isActive;

        return $this;
    }

    /**
     * Get is_active
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->is_active;
    }
    
    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->is_active;
    }
    
    public function serialize()
    {
        return serialize(array(
			$this->id,
			$this->roles,
			$this->username,
			$this->password,
			$this->salt,
            $this->is_active
        ));
    }
    public function unserialize($serialized)
    {
        list (
			$this->id,
			$this->roles,
			$this->username,
			$this->password,
			$this->salt,
            $this->is_active
        ) = unserialize($serialized);
    }
}
