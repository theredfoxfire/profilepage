<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use AppBundle\Entity\Profile;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadProfileUser implements FixtureInterface, ContainerAwareInterface
{
	private $container;
	
	public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
	
	public function load(ObjectManager $manager)
	{
		$this->loadUsers($manager);
	}
	
    private function loadUsers(ObjectManager $manager)
    {
        $johnUser = new User();
        $factory = $this->container->get('security.encoder_factory');
        $encoder = $factory->getEncoder($johnUser);
        $johnUser->setUsername('user');
        $encodedPassword = $encoder->encodePassword('12345', $johnUser->getSalt());
        $johnUser->setPassword($encodedPassword);
        $manager->persist($johnUser);

        $annaAdmin = new User();
        $annaAdmin->setUsername('admin');
        $annaAdmin->setRoles(array('ROLE_ADMIN'));
        $encodedPassword = $encoder->encodePassword('12345', $annaAdmin->getSalt());
        $annaAdmin->setPassword($encodedPassword);
        $manager->persist($annaAdmin);

        $manager->flush();
    }
}
