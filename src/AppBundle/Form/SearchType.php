<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('name', 'text', array(
			'label' => false,
			'attr' => array('placeholder' => 'Nama Yang Dicari', 'class' => 'form-control'),
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
		return 'profile_search';
	}
}
