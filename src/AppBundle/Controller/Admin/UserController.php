<?php
namespace AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\User;
use AppBundle\Entity\Profile;
use AppBundle\Form\SearchType;

class UserController extends Controller
{
	/**
	 * @Route("/admin/list/user", name="user_list")
	 * @Method({"GET", "POST"})
	 */
	public function listUser(Request $request)
	{
		if (null === $this->getUser()) {
			throw $this->createAccessDeniedException('Untuk melihat list user, silahkan login terlebih dahulu.');
		}
		
		$em = $this->getDoctrine()->getManager();
		$profile = new Profile();
		$searchForm = $this->createForm(new SearchType(), $profile, array(
			'method' => 'POST',
		));
		$searchForm->handleRequest($request);
		
		// If submitted form run search query instead of findAll query
		if ($searchForm->isSubmitted() && $searchForm->isValid()) {
			$key = $profile->getName();
			$entities = $em->getRepository('AppBundle:User')->searchUser($key);
			$deleteForm = array();
			foreach ($entities as $entity) {
				$deleteForm[$entity->getId()] = $this->createDeleteForm($entity->getId())->createView();
			}
			
			return $this->render('admin/user/list.html.twig', array(
			'users' => $entities,
			'delete' => $deleteForm,
			'form' => $searchForm->createView(),
		));
		}
		
		$deleteForm = array();
        $entities = $em->getRepository('AppBundle:User')->findAllUser();
        foreach ($entities as $entity) {
			$deleteForm[$entity->getId()] = $this->createDeleteForm($entity->getId())->createView();
		}
		
		return $this->render('admin/user/list.html.twig', array(
			'users' => $entities,
			'delete' => $deleteForm,
			'form' => $searchForm->createView(),
		));
	}
	
	private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_block', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * @Route("user/block/{id}", requirements={"id" = "\d+"}, name="user_block")
     * @Method("DELETE")
     */
    public function blockAction(Request $request, $id)
    {
		$form = $this->createDeleteForm($id);
		$form->handleRequest($request);
		
		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$entity = $em->getRepository('AppBundle:User')->findOneById($id);
			
			if (!$entity) {
				throw $this->createNotFoundException('Data user tidak ditemukan!');
			}
			
			$this->get('session')->getFlashBag()->add('notice', 'User berhasil diblokir!');
			
			$entity->setIsActive(false);
			$em->flush();
		}
		
		return $this->redirect($this->generateUrl('user_list'));
	}
	
	/**
	 * @Route("/user/activated/{id}", requirements={"id": "\d+"}, name="user_activated")
	 * @Method("GET")
	 */
	public function activatedAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		$entity = $em->getRepository('AppBundle:User')->findOneById($id);
		
		if (!$entity) {
			throw $this->createNotFoundException('Data user tidak ditemukan!');
		}
		
		$this->get('session')->getFlashBag()->add('notice', 'User berhasil diaktifkan!');
		
		$entity->setIsActive(true);
		$em->flush();
		
		return $this->redirect($this->generateUrl('user_list'));
	}
}
