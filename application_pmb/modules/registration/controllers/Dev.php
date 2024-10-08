<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dev extends App_core
{
	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('auth')){
			redirect(site_url('candidate/profile'));
		}
		$this->load->model('Registrations', 'Reg');
	}

	public function index()
	{
		$mba_study_programs = $this->Reg->get_study_program_lists(array(
			'program_id' => 1,
			'study_program_is_active' => true
		));
		$data['study_programs'] = $mba_study_programs;
		$data['pages'] = 'signup';
		$this->load->view('registration/layout', $data);
	}

	public function get_image_size()
	{
		$slide1 = 'https://pmb.iuli.ac.id/assets/img/banner/01/Profile-1208px.jpg';
		$slide2 = 'https://pmb.iuli.ac.id/assets/img/banner/02/Besiswa-1208px.jpg';
		$slide3 = 'https://pmb.iuli.ac.id/assets/img/banner/03/Employee-Class-1208px.jpg';
		$slide4 = 'https://pmb.iuli.ac.id/assets/img/banner/04/Semester.jpg';

		print('<h3>Slide 1</h3>');
		list($width1, $height1, $type1, $attr1) = getimagesize($slide1);
		echo "Image width: ".$width1;
		echo "<br>";
		echo "Image height: ".$height1;
		echo "<br>";
		echo "Image type: ".$type1;
		echo "<br>";
		echo "Attribute: ".$attr1;

		print('<h3>Slide 2</h3>');
		list($width2, $height2, $type2, $attr2) = getimagesize($slide2);
		echo "Image width: ".$width2;
		echo "<br>";
		echo "Image height: ".$height2;
		echo "<br>";
		echo "Image type: ".$type2;
		echo "<br>";
		echo "Attribute: ".$attr2;

		print('<h3>Slide 3</h3>');
		list($width3, $height3, $type3, $attr3) = getimagesize($slide3);
		echo "Image width: ".$width3;
		echo "<br>";
		echo "Image height: ".$height3;
		echo "<br>";
		echo "Image type: ".$type3;
		echo "<br>";
		echo "Attribute: ".$attr3;

		print('<h3>Slide 4</h3>');
		list($width4, $height4, $type4, $attr4) = getimagesize($slide4);
		echo "Image width: ".$width4;
		echo "<br>";
		echo "Image height: ".$height4;
		echo "<br>";
		echo "Image type: ".$type4;
		echo "<br>";
		echo "Attribute: ".$attr4;
	}

	public function sign_up()
	{
		$data['pages'] = 'signup';
		$this->load->view('registration/layout', $data);
	}

	public function sign_in()
	{
		$data['pages'] = 'signin';
		$this->load->view('registration/layout', $data);
	}
}