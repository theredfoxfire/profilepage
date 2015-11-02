<?php

namespace AppBundle\Controller;

use AppTracker\GetUserProfile;
use AppBundle\Entity\Profile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Templatting\EngineInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class ShowMyProfileController
{
	private $useCase;
	private $securityToken;
	private $profileFormView;
	private $templating;
	
	public function __construct(
		GetUserProfile $useCase,
		TokenInterface $securityToken,
		FormView $profileFormView,
		EngineInterface $templating
	)
	{
		$this->useCase = $useCase;
		$this->securityToken = $securityToken;
		$this->profileFormView = $profileFormView;
		$this->templating = $templating;
	}
	
	public function showAction()
	{
		$profile = $this->useCase->getUserProfile($this->securityToken->getUser());
		
		return $this->templating->renderResponse('AppBundle:Profile:show.html.twig', [
			'profile_form' => $this->profileFormView,
			'profile' => array_map([$this, 'prepareProfileView'], $profile),
		]);
	}
	
	public function prepareProfileView(Profile $profile)
	{
		return ['name' => $profile->getName()];
	}
}
