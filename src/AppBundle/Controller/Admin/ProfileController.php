<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Form\ProfileType;
use AppBundle\Form\MinatType;
use AppBundle\Form\UrlType;
use AppBundle\Form\EducationType;
use AppBundle\Form\WorkExperienceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Profile;
use AppBundle\Entity\Url;
use AppBundle\Entity\Education;
use AppBundle\Entity\WorkExperience;
use Gregwar\Image\Image;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


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
	 * @Route("/user/new", name="user_new")
	 * @Method({"GET"})
	 */
	public function newAction()
	{
		
			return $this->render('admin/user/homeNew.html.twig');
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
		
		$edu = new Education();
		$work = new WorkExperience();
		$url = new Url();
		
		$editForm = $this->createForm(new ProfileType(), $profile, array(
			'method' => 'POST',
		));
		$minatForm = $this->createForm(new MinatType(), $profile, array(
			'method' => 'POST'
		));
		$eduForm = $this->createForm(new EducationType(), $edu, array(
			'method' => 'POST'
		));
		$workForm = $this->createForm(new WorkExperienceType(), $work, array(
			'method' => 'POST'
		));
		$urlForm = $this->createForm(new UrlType(), $url, array(
			'method' => 'POST'
		));
		
		$editForm->handleRequest($request);
		$minatForm->handleRequest($request);
		$eduForm->handleRequest($request);
		$workForm->handleRequest($request);
		$urlForm->handleRequest($request);
		
		if ($editForm->isSubmitted() && $editForm->isValid()) {
            $file = $profile->getFile();
            if (!empty($file)) {
				$dir = $this->container->getParameter('kernel.root_dir').'/../web/images/dosen';
				$l_foto = $profile->getFoto();
				if (!empty($l_foto)) {
					unlink($dir.'/'.$profile->getFoto());
				}
				
				$fileName = md5(uniqid()).'.'.$file->guessExtension();
				$fileName1 = md5(uniqid()).'awal.'.$file->guessExtension();
				
				$file->move($dir, $fileName1);
				Image::open($dir.'/'.$fileName1)
					->scaleResize(320, 320, $background = 0xffffff)
					->save($dir.'/'.$fileName);
				unlink($dir.'/'.$fileName1);
				$profile->setFoto($fileName);
			}
			
			$em->persist($profile);
			$em->flush();
			
			$this->get('session')->getFlashBag()->add('notice', 'Data berhasil diupdate!');
			
			return $this->redirect($this->generateUrl('user_profile_edit'));
		}
		
		if ($minatForm->isSubmitted() && $minatForm->isValid()) {
			$em->flush();
			
			$this->get('session')->getFlashBag()->add('notice', 'Data berhasil diupdate!');
			
			return $this->redirect($this->generateUrl('user_profile_edit'));
		}
		
		if ($eduForm->isSubmitted() && $eduForm->isValid()) {
			$edu->setUser($this->getUser());
			$em->persist($edu);
			$em->flush();
			
			$this->get('session')->getFlashBag()->add('notice', 'Data berhasil diupdate!');
			
			return $this->redirect($this->generateUrl('user_profile_edit'));
		}
		
		if ($workForm->isSubmitted() && $workForm->isValid()) {
			$work->setUser($this->getUser());
			$em->persist($work);
			$em->flush();
			
			$this->get('session')->getFlashBag()->add('notice', 'Data berhasil diupdate!');
			
			return $this->redirect($this->generateUrl('user_profile_edit'));
		}
		
		if ($urlForm->isSubmitted() && $urlForm->isValid()) {
			$url->setUser($this->getUser());
			$em->persist($url);
			$em->flush();
			
			$this->get('session')->getFlashBag()->add('notice', 'Data berhasil diupdate!');
			
			return $this->redirect($this->generateUrl('user_profile_edit'));
		}
		
		if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
			return $this->render('admin/profile/editAdmin.html.twig', array(
				'profile' => $profile,
				'form' => $editForm->createView(),
				'minat' => $minatForm->createView(),
				'edu' => $eduForm->createView(),
				'work' => $workForm->createView(),
				'url' => $urlForm->createView(),
			));
		}
		return $this->render('admin/profile/edit.html.twig', array(
			'profile' => $profile,
			'form' => $editForm->createView(),
			'minat' => $minatForm->createView(),
			'edu' => $eduForm->createView(),
			'work' => $workForm->createView(),
			'url' => $urlForm->createView(),
		));
	}
	
	/**
	 * @Route("/profile/search/person", name="profile_search")
	 * @Method("GET")
	 */
	public function searchAction(Request $request)
	{
		$names = array();
		$term = trim(strip_tags($request->get('term')));
		$isUser = $request->get('user');
		
		$em = $this->getDoctrine()->getManager();
		if (empty($isUser)) {
			$entities = $em->getRepository('AppBundle:Profile')->findPersonName($term);
		} else {
			$entities = $em->getRepository('AppBundle:Profile')->findUserName($term);
		}
		foreach ($entities as $entity) {
			$names[] = $entity->getName();
		}
		$response = new JsonResponse();
		$response->setData($names);
		
		return $response;
	}
	
}
