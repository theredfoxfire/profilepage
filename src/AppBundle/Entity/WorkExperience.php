<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WorkExperience
 */
class WorkExperience
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $company;

    /**
     * @var string
     */
    private $position;

    /**
     * @var string
     */
    private $syear;

    /**
     * @var string
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
     * Set company
     *
     * @param string $company
     * @return WorkExperience
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return string 
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set position
     *
     * @param string $position
     * @return WorkExperience
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return string 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set syear
     *
     * @param string $syear
     * @return WorkExperience
     */
    public function setSyear($syear)
    {
        $this->syear = $syear;

        return $this;
    }

    /**
     * Get syear
     *
     * @return string 
     */
    public function getSyear()
    {
        return $this->syear;
    }

    /**
     * Set eyear
     *
     * @param string $eyear
     * @return WorkExperience
     */
    public function setEyear($eyear)
    {
        $this->eyear = $eyear;

        return $this;
    }

    /**
     * Get eyear
     *
     * @return string 
     */
    public function getEyear()
    {
        return $this->eyear;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     * @return WorkExperience
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
    /**
     * @var string
     */
    private $about;


    /**
     * Set about
     *
     * @param string $about
     * @return WorkExperience
     */
    public function setAbout($about)
    {
        $this->about = $about;

        return $this;
    }

    /**
     * Get about
     *
     * @return string 
     */
    public function getAbout()
    {
        return $this->about;
    }
}
