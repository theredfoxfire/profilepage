<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Form\ProfileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Profile;


class ProfileController extends Controller
{
	/**
	 * @Route("/user/home", name="user_home")
	 * @Method({"GET"})
	 */
	public function homeAction()
	{
		if (null === $this->getUser()) {
			throw $this->createAccessDeniedException('Untuk melihat profile, silahkan login terlebih dahulu.');
		}
		
		if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
			return $this->render('admin/user/homeAdmin.html.twig');
		}
		
		if ($this->get('security.context')->isGranted('ROLE_USER')) {
			return $this->render('admin/user/homeUser.html.twig');
		}
	}
	
	/**
	 * @Route("/user/profile/edit", name="user_profile_edit");
	 * @Method({"GET", "POST"})
	 */
	public function editAction(Request $request)
	{
		if (null === $this->getUser()) {
			throw $this->createAccessDeniedException("Silahkan login terlebih dahulu untuk mengedit.");
		}
		
		$em = $this->getDoctrine()->getManager();
		
		$profile = $em->getRepository('AppBundle:Profile')->findOneByUser($this->getUser());
		
		$editForm = $this->createForm(new ProfileType(), $profile, array(
			'method' => 'POST'
		));
		
		$editForm->handleRequest($request);
		
		if ($editForm->isSubmitted() && $editForm->isValid()) {
			$em->flush();
			
			$this->get('session')->getFlashBag()->add('notice', 'Data berhasil diupdate!');
			
			return $this->redirect($this->generateUrl('user_profile_edit'));
		}
		
		return $this->render('admin/profile/edit.html.twig', array(
			'profile' => $profile,
			'form' => $editForm->createView(),
		));
	}
}
