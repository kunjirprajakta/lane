<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class student_registration extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('tank_auth');

		$this->load->helper('form');
		$this->load->model('GetCurrent_model');
		$this->load->model('Common_model');

	}

	public function index()
	{
		$this->load->view('common/header');
		$this->load->view('common/nav');
		$this->load->view('student_registration');
		$this->load->view('common/footer');
	}
}

				