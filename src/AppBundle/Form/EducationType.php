<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EducationType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('institution', 'text', array(
			'label' => false,
			'attr' => array('placeholder' => 'Institusi', 'class' => 'form-control'),
		))
		->add('level', 'text', array(
			'label' => false,
			'required' => false,
			'attr' => array('placeholder' => 'Tingkatan', 'class' => 'form-control'),
		))
		->add('syear', 'date', array(
			'label' => false,
			'widget' => 'single_text',
			'format' => 'dd-MM-yyyy',
			'required' => false,
			'attr' => array('placeholder' => 'Tahun Masuk', 'class' => 'form-control edu-sdate', 'readonly' => true),
		))
		->add('eyear', 'date', array(
			'label' => false,
			'widget' => 'single_text',
			'format' => 'dd-MM-yyyy',
			'required' => false,
			'attr' => array('placeholder' => 'Tahun Selesai', 'class' => 'form-control edu-edate', 'readonly' => true),
		))
		;
		
	}
	
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'AppBundle\Entity\Education',
		));
	}
	
	public function getName()
	{
		return 'create_education';
	}
}
