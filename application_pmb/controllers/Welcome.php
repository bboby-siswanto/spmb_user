<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MX_Controller {

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		print('');
	}

	public function test()
	{
		// echo 'test';
		echo Modules::run('registration/Auth/index');
		// echo $data;
	}
}
