<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkExperienceType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('company', 'text', array(
			'label' => false,
			'attr' => array('placeholder' => 'Perusahaan', 'class' => 'form-control'),
		))
		->add('position', 'text', array(
			'label' => false,
			'required' => false,
			'attr' => array('placeholder' => 'Jabatan/Posisi', 'class' => 'form-control'),
		))
		->add('about', 'textarea', array(
			'label' => false,
			'required' => false,
			'attr' => array('placeholder' => 'Deskripsi tentang pekerjaan Anda', 'class' => 'form-control'),
		))
		->add('syear', 'date', array(
			'label' => false,
			'widget' => 'single_text',
			'format' => 'dd-MM-yyyy',
			'required' => false,
			'attr' => array('placeholder' => 'Tahun Masuk', 'class' => 'form-control work-sdate', 'readonly' => true),
		))
		->add('eyear', 'date', array(
			'label' => false,
			'widget' => 'single_text',
			'format' => 'dd-MM-yyyy',
			'required' => false,
			'attr' => array('placeholder' => 'Tahun Keluar', 'class' => 'form-control work-edate', 'readonly' => true),
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
		return 'create_work';
	}
}
