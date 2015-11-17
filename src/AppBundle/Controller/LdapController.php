<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\Profile;
use AppBundle\Form\RegisterType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class LdapController extends Controller
{
	/**
	 * @Route("/ldap/auth", name="ldap_register")
	 * @Method({"GET", "POST"})
	 */
	public function registerAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$user = new User();
		$regForm = $this->createForm(new RegisterType(), $user, array(
			'method' => 'POST',
		));
		
		$regForm->handleRequest($request);
		
		if ($regForm->isSubmitted() && $regForm->isValid()) {
			$username = $user->getUsername();
			$password = $user->getPassword();
			$user = $em->getRepository('AppBundle:User')->findOneByUsername($username);

			if ($user) {
				$factory = $this->get('security.encoder_factory');
				$encoder = $factory->getEncoder($user);
				$ep = $encoder->encodePassword($password, $user->getSalt());
				
				$user_log = $em->getRepository('AppBundle:User')->getLogUser($username, $ep);
				
				if (!$user_log) {
					$this->get('session')->getFlashBag()->add('notice', 'Login gagal, periksa kembali username & password Anda.');
					return $this->redirect($this->generateUrl('ldap_register'));
				}
				
				if ($user->getIsActive() == false) {
					$this->get('session')->getFlashBag()->add('notice', 'Login gagal, sepertinya akun Anda sudah tidak aktif.');
					return $this->redirect($this->generateUrl('ldap_register'));
				}
				
				$this->authenticateUser($user);
				return $this->redirect($this->generateUrl('user_home'));
			}
			
			/**
			 * LDAP AUTH
			 */
			$hash = hash('sha256', $password);
			$LDAPServerAddress1="10.150.9.90"; // <- IP address for your 1st DC
			$LDAPServerAddress2="10.150.9.90"; // <- IP address for your 2nd DC...and so on...
			$LDAPServerPort="636";
			$LDAPServerTimeOut ="60";
			$LDAPContainer="dc=stkipsurya,dc=local"; // <- your domain info
			$BIND_username = "pdc\\ldap2"; // <- an account in AD to test using
			$BIND_password = "st3k1p";
			$filter = "sAMAccountName=".$username;
			$login_error_code = 0;
				if(($ds=ldap_connect($LDAPServerAddress1)) || ($ds=ldap_connect($LDAPServerAddress2))) {
					ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
					ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
      
					if($r=ldap_bind($ds,$BIND_username,$BIND_password)) {
						if($sr=ldap_search($ds, $LDAPContainer, $filter, array('distinguishedName'))) {
							if($info = ldap_get_entries($ds, $sr)) {
								if ($info['count'] == 0) {
									$login_error_code = 4;
								} else {
									$BIND_username = $info[0]['distinguishedname'][0];
									$BIND_password = $password;
								}
								if (@$r2=ldap_bind($ds,$BIND_username,$BIND_password)) {
									if($sr2=ldap_search($ds, $LDAPContainer, $filter, array("givenName","sn","mail","displayName","department"))) {
										if($info2 = ldap_get_entries($ds, $sr2)) {
											if ($info2['count'] == 0) {
												$login_error_code = 4;
											} else {
												$ldap_name = $info2[0]["givenname"][0]." ".$info2[0]["sn"][0];
												$ldap_email = $info2[0]["mail"][0];	
												$ldap_displayname = $info2[0]["displayname"][0];
												$ou = explode(",",$info[0]['distinguishedname'][0]);
												$name = explode("=",$ou[0]);
												$name = $name[1];
												$ou = explode("=",$ou[1]);
												$ou = $ou[1];
											}
										} else {
											$login_error = "Could not read entries"; $login_error_code=1;
										}
								} else {
									$login_error = "Could not search"; $login_error_code=2;
								}
							} else {
								$login_error = "User password incorrect"; $login_error_code=3;
							}
						} else {
							$login_error = "User name not found"; $login_error_code=4;
						}
					} else {
						$login_error = "Could not search"; $login_error_code=5;
					}
				} else {
					$login_error = "Could not bind"; $login_error_code=6;
				}
			} else {
				$login_error = "Could not connect"; $login_error_code=7;
			}
			//END OF LDAP AUTH
   
			if($login_error_code > 0){
				$this->get('session')->getFlashBag()->add('notice', 'Login gagal, periksa kembali username & password Anda.');
				return $this->redirect($this->generateUrl('ldap_register'));
			} else {
				if ($ou == 'STUDENTS' or $ou == 'SU' or $ou == 'CENTER' or $ou == 'MANAGEMENT' or $ou == 'YS-GROUP') {
					$this->get('session')->getFlashBag()->add("notice", "Mohon maaf {$ou} tidak diperkenankan menggunkan aplikasi ini.");
					return $this->redirect($this->generateUrl('ldap_register'));
				}
				$user = $em->getRepository('AppBundle:User')->findOneByUsername($username);
				
				if (!$user) {
					$new = new User();
					$factory = $this->get('security.encoder_factory');
					$encoder = $factory->getEncoder($new);
					$ep = $encoder->encodePassword($password, $new->getSalt());
					$new->setUsername($username);
					$new->setIsActive(false);
					$new->setIsAdmin(false);
					$new->setPassword($ep);
					$em->persist($new);
					$em->flush();
					
					$user = $em->getRepository('AppBundle:User')->findOneByUsername($new->getUsername());
					
					//set new Profile for new User
					$profile = new Profile();
					$profile->setUser($user);
					$profile->setName($name);
					$em->persist($profile);
					$em->flush();
					
					$this->authenticateUser($user);
					return $this->redirect($this->generateUrl('user_new'));
				} else {
					$this->authenticateUser($user);
					return $this->redirect($this->generateUrl('user_home'));
				}
			}
		}
		
		return $this->render('front/user/register.html.twig', array(
			'form' => $regForm->createView(),
		));
	}
	
	private function authenticateUser(UserInterface $user)
	{
		$providerKey = 'main';
		$token = new UsernamePasswordToken($user, null, $providerKey, $user->getRoles());
		
		$this->container->get('security.context')->setToken($token);
	}
	
}
