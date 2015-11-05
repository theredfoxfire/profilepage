<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Profile;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ShowMyProfileController extends Controller
{
	/**
	 * @Route("/", name="person_list")
	 * @Method({"GET"})
	 */
	public function listAction()
	{
		$em = $this->getDoctrine()->getManager();
		$listPerson = $em->getRepository("AppBundle:User")->getPersonList();
		
		return $this->render('front/profile/list.html.twig', array(
			'listPerson' => $listPerson,
		));
	}
	
	/**
	 * @Route("/person/show/profile/{id}", requirements={"id" = "\d+"}, name="person_show_profile")
	 * @Method({"GET"})
	 */
	public function showAction($id = null )
	{
		$em = $this->getDoctrine()->getManager();
		$profile = $em->getRepository("AppBundle:Profile")->getPersonProfile();
		
		return $this->render('front/profile/show.html.twig', array(
			'profile' => $profile,
		));
	}
}
