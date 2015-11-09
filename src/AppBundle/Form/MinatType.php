<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MinatType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
		->add('expertise', 'textarea', array(
			'label' => false,
			'attr' => array('placeholder' => 'Minat & Keahlian', 'class' => 'form-control'),
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
		return 'create_minat';
	}
}
