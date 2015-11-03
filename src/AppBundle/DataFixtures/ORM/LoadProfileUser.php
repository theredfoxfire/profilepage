<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixturesInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\ProfileUser;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadProfileUser implements FixturesInterface, ContainerAwareInterface
{
	private $container;
	
	public function setContainer(ContainerInterface $container = null)
	{
		$this->container = $container;
	}
	
	public function load(ObjectManager $manager)
	{
		$pm = new ProfileUser('superadmin');
		$pm->setPassword($this->encodePassword($pm, 'superadmin'));
		$manager->persist($pm);
		
		$manager->flush();
	}
	
	private function encodePassword($user, $plainPassword)
	{
		$encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
		
		return $encoder->encodePassword($plainPassword, $user->getSalt());
	}
}
