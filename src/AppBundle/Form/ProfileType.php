<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('name', 'text', array(
			'label' => false,
			'attr' => array('placeholder' => 'Nama Lengkap', 'class' => 'form-control'),
		))
		->add('pob', 'text', array(
			'label' => false,
			'required' => false,
			'attr' => array('placeholder' => 'Tempat kelahiran', 'class' => 'form-control'),
		))
		->add('email', 'email', array(
			'label' => false,
			'required' => false,
			'attr' => array('placeholder' => 'Alamat email', 'class' => 'form-control'),
		))
		->add('dob', 'date', array(
			'label' => false,
			'required' => false,
			'widget' => 'single_text',
			'format' => 'dd-MM-yyyy',
			'attr' => array('placeholder' => 'Tanggal lahir', 'class' => 'form-control birth-date', 'readonly' =>true),
		))
		->add('phone', 'text', array(
			'label' => false,
			'required' => false,
			'attr' => array('placeholder' => 'Nomor Telephone atau Hp', 'class' => 'form-control'),
		))
		->add('address', 'textarea', array(
			'label' => false,
			'required' => false,
			'attr' => array('placeholder' => 'Alamat tinggal', 'class' => 'form-control'),
		))
		->add('about', 'textarea', array(
			'label' => false,
			'required' => false,
			'attr' => array('placeholder' => 'Sekilas tentang Anda', 'class' => 'form-control'),
		))
		->add('expertise', 'hidden', array(
			'label' => false,
			'required' => false,
			'attr' => array('placeholder' => 'Minat & Keahlian', 'class' => 'form-control',),
		))
		->add('file', 'file', array(
			'label' => false,
			'required' => false,
		))
		->add('position', 'text', array(
			'label' => false,
			'required' => false,
			'attr' => array('class' => 'form-control')
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
		return 'create_profile';
	}
}
