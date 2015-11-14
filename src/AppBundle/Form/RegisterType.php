<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('username', 'text', array(
			'label' => false,
			'attr' => array('placeholder' => 'Username', 'class' => 'form-control'),
		))
		->add('password', 'password', array(
			'label' => false,
			'attr' => array('placeholder' => 'Password', 'class' => 'form-control'),
		))
		;
		
	}
	
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'AppBundle\Entity\Profile',
		));
	}
	
	public function getName()
	{
		return 'user_register';
	}
}
