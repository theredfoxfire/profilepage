<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Profile;
use AppBundle\Entity\User;
use AppBundle\Form\SearchType;
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
	 * @Method({"GET", "POST"})
	 */
	public function listAction(Request $request)
	{
		$profile = new Profile();
		$em = $this->getDoctrine()->getManager();
		$listPerson = $em->getRepository("AppBundle:User")->getPersonList();
		$searchForm = $this->createForm(new SearchType(), $profile, array(
			'method' => 'POST',
		));
		$searchForm->handleRequest($request);
		
		if ($searchForm->isSubmitted() && $searchForm->isValid()) {
			$key = $profile->getName();
			$persons = $em->getRepository('AppBundle:Profile')->findPerson($key);
			
			return $this->render('front/profile/list.html.twig', array(
				'persons' => $persons,
				'form' => $searchForm->createView(),
			));
		}
		
		return $this->render('front/profile/list.html.twig', array(
			'persons' => $listPerson,
			'form' => $searchForm->createView(),
		));
	}
	
	/**
	 * @Route("/person/show/profile/{id}", requirements={"id" = "\d+"}, name="person_show_profile")
	 * @Method({"GET"})
	 */
	public function showAction($id = null )
	{
		$em = $this->getDoctrine()->getManager();
		$profile = $em->getRepository("AppBundle:Profile")->findOneById($id);
		
		return $this->render('front/profile/show.html.twig', array(
			'profile' => $profile,
		));
	}
}
