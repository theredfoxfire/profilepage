<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('title', 'text', array(
			'label' => false,
			'required' => false,
			'attr' => array('placeholder' => 'Judul Publikasi', 'class' => 'form-control'),
		))
		->add('url', 'text', array(
			'label' => false,
			'attr' => array('placeholder' => 'Alamat URL', 'class' => 'form-control'),
		))
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'AppBundle\Entity\Url',
		));
	}

	public function getName()
	{
		return 'create_url';
	}
}
