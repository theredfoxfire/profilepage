<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Tempalating\EngineInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

class SecurityController
{
	private $templating; 
	
	public function __construct(EngineInterface $templating)
	{
		$this->templating = $templating;
	}
	
	public function loginAction(Request $request)
	{
		$session = $request->getSession();
		
		if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
			$error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
		} else {
			$error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
			$session->remove(SecurityContext::AUTHENTICATION_ERROR);
		}
		
		return $this->templating->renderResponse(
			'AppBundle:Security:login.html.twig',
			['last_username' => $session->get(SecurityContext::LAST_USERNAME), 'error' => $error]
		);
	}
}
