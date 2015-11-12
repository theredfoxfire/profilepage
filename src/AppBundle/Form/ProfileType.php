<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$posisi = array(
			"Ketua Yayasan" => "Ketua Yayasan",
			"Ketua STKIP Surya" => "Ketua STKIP Surya",
			"Wakil Ketua STKIP Surya" => "Wakil Ketua STKIP Surya",
			"Ketua Prodi Matematika" => "Ketua Prodi Matematika",
			"Ketua Prodi Fisika" => "Ketua Prodi Fisika",
			"Ketua Prodi Kimia" => "Ketua Prodi Kimia",
			"Ketua Prodi Teknik Informasi & Komputer" => "Ketua Prodi Teknik Informasi & Komputer",
			"Wakil Ketua Prodi Matematika" => "Wakil Ketua Prodi Matematika",
			"Wakil Ketua Prodi Fisika" => "Wakil Ketua Prodi Fisika",
			"Wakil Ketua Prodi Kimia" => "Wakil Ketua Prodi Kimia",
			"Wakil Ketua Prodi Teknik Informatika & Komputer" => "Wakil Ketua Prodi Teknik Informatika & Komputer",
			"Kepala Staff Badan Akademik" => "Kepala Staff Badan Akademik",
			"Kepala Staff Badan Kemahasiswaan" => "Kepala Staff Badan Kemahasiswaan",
			"Kepala Staff Badan Keamanan" => "Kepala Staff Badan Keamanan",
			"Kepala Staff Badan Informasi dan Telekomunikasi" => "Kepala Staff Badan Informasi dan Telekomunikasi",
			"Dosen Pendidikan Matematika" => "Dosen Pendidikan Matematika",
			"Dosen Pendidikan Fisika" => "Dosen Pendidikan Fisika",
			"Dosen Pendidikan Kimia" => "Dosen Pendidikan Kimia",
			"Dosen Pendidikan Teknik Informatika & Komputer" => "Dosen Pendidikan Teknik Informatika & Komputer",
			"Staff Badan Akademik" => "Staff Badan Akademik",
			"Staff Badan Kemahasiswaan" => "Staff Badan Kemahasiswaan",
			"Staff Badan Keamanan" => "Staff Badan Keamanan",
			"Staff Badan Informasi dan Telekomunikasi" => "Staff Badan Informasi dan Telekomunikasi",
			"Tutor Pendidikan Matematika" => "Tutor Pendidikan Matematika",
			"Tutor Pendidikan Fisika" => "Tutor Pendidikan Fisika",
			"Tutor Pendidikan Kimia" => "Tutor Pendidikan Kimia",
			"Tutor Pendidikan Teknik Informatika & Komputer" => "Tutor Pendidikan Teknik Informatika & Komputer",
		);
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
		->add('position', 'choice', array(
			'label' => false,
			'choices' => $posisi,
			'required' => true,
			'empty_value' => "--Pilih Posisi/Jabatan--",
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
