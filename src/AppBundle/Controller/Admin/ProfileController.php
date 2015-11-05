<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Form\ProfileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Profile;


class ProfileController extends Controller
{
	/**
	 * @Route("/user/create/profile", name="create_profile")
	 * @Method({"GET", "POST"})
	 */
	public function createAction(Request $request)
	{
		$profile = new Profile();
		$profile->setUser($this->getUser());
		$form = $this->createForm(new ProfileType(), $profile);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$em = $this->getDoctrine()->getManager();
			$em->persist($profile);
			$em->flush();
			
			return $this->redirectToRoute('user_show_profile', array('id' => $this->getUser()->getId()));
		}
		
		return $this->render('admin/profile/new.html.twig', array(
			'profile' => $profile,
			'form' => $form->createView(),
		));
	}
	
	/**
	 * @Route("/user/profile/{id}", requirements={"id" = "\d+"}, name="user_show_profile")
	 * @Method("GET")
	 */
	public function showAction(Profile $profile)
	{
		if (null === $this->getUser()) {
			throw $this->createAccessDeniedException('Untuk melihat profile, silahkan login terlebih dahulu.');
		}
		
		return $this->render('admin/profile/show.html.twig', array(
			'profile' => $profile,
		));
	}
	
	/**
	 * @Route("/user/profile/edit/{id}", requirements={"id" = "\d+"}, name="user_profile_edit");
	 * @Method({"GET", "POST"})
	 */
	public function editAction(Profile $profile, Request $request)
	{
		if (null === $this->getUser()) {
			throw $this->createAccessDeniedException("Silahkan login terlebih dahulu untuk mengedit.");
		}
		
		$em = $this->getDoctrine()->getManager();
		
		$editForm = $this->createForm(new ProfileType(), $profile);
		
		$editForm->handleRequest($request);
		
		if ($editForm->isSubmitted() && $editForm->isValid()) {
			$em->flush();
			
			return $this->redirectToRoute('user_show_profile', array('id' => $this->getUser()->getId()));
		}
		
		return $this->render('admin/user/edit.html.twig', array(
			'profile' => $profile,
			'edit_form' => $editForm->createView(),
		));
	}
}
