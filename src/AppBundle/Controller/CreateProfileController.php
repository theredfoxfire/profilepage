<?php

namespace AppBundle\Controller;

use AppTracker\CreateProfile;
use AppTracker\Event;
use AppBundle\Entity\Profile;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class CreateProfileController
{
    private $useCase;
    private $profileForm;
    private $flashBag;
    private $router;

    public function __construct(
        Createprofile $useCase,
        FormInterface $profileForm,
        FlashBagInterface $flashBag,
        RouterInterface $router
    )
    {
        $this->useCase = $useCase;
        $this->profileForm = $profileForm;
        $this->flashBag = $flashBag;
        $this->router = $router;
    }
	
	public function createAction(Request $request)
	{
		$this->profileForm->handleRequest($request);
		
		if (!$this->profileForm->isValid()) {
			$this->onFailure(new Event(['reason' => 'Invalid profile values provided.']));
			
			return new RedirectResponse($this->router->generate('show_my_profile'));
		}
		
		$profile = $this->instantiateProfileFromFormData($this->profileForm->getData());
		$this->useCase->createprofile($profile);
		
		return new RedirectResponse($this->router->generate('show_my_profile'));
	}
	
	public function onSuccess(Event $event)
	{
		$this->flashBag->add('success', 'Profile telah berhasil dibuat');
	}
	
	public function onFailure(Event $event)
	{
		$this->flashBag->add('failure', 'Gagal untuk membuat profile' . PHP_EOL . $event->get('reason'));
	}
	
	private function instantiateProfileFromFormData(array $data)
	{
		return new Profile($data['name'], $this->securityToken->getUser());
	}
}
