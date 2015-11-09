<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Education
 */
class Education
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $institution;

    /**
     * @var string
     */
    private $level;

    /**
     * @var \DateTime
     */
    private $syear;

    /**
     * @var \DateTime
     */
    private $eyear;

    /**
     * @var \AppBundle\Entity\User
     */
    private $user;


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
     * Set institution
     *
     * @param string $institution
     * @return Education
     */
    public function setInstitution($institution)
    {
        $this->institution = $institution;

        return $this;
    }

    /**
     * Get institution
     *
     * @return string 
     */
    public function getInstitution()
    {
        return $this->institution;
    }

    /**
     * Set level
     *
     * @param string $level
     * @return Education
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return string 
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set syear
     *
     * @param \DateTime $syear
     * @return Education
     */
    public function setSyear($syear)
    {
        $this->syear = $syear;

        return $this;
    }

    /**
     * Get syear
     *
     * @return \DateTime 
     */
    public function getSyear()
    {
        return $this->syear;
    }

    /**
     * Set eyear
     *
     * @param \DateTime $eyear
     * @return Education
     */
    public function setEyear($eyear)
    {
        $this->eyear = $eyear;

        return $this;
    }

    /**
     * Get eyear
     *
     * @return \DateTime 
     */
    public function getEyear()
    {
        return $this->eyear;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     * @return Education
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
