<?php
namespace AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\User;

class UserController extends Controller
{
	/**
	 * @Route("/admin/list/user", name="user_list")
	 * @Method({"GET"})
	 */
	public function listUser()
	{
		if (null === $this->getUser()) {
			throw $this->createAccessDeniedException('Untuk melihat list user, silahkan login terlebih dahulu.');
		}
		
		$em = $this->getDoctrine()->getManager();
		$listUser = $em->getRepository('AppBundle:User')->getListUser();
		
		return $this->render('admin/user/list.html.twig');
	}
}
