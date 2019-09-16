<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class profile extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('tank_auth');

		$this->load->helper('form');
		$this->load->model('GetCurrent_model');
		$this->load->model('Common_model');

	}

	function index()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			
					$data['user_id']	= $this->tank_auth->get_user_id();
					$data['username']	= $this->tank_auth->get_username();
					$data['name']		= $this->session->userdata("name");
					$data['request_name']=$this->Common_model->getAll("users",array('id'=>$data['user_id']))->result_array();
					$data['friends']=$this->Common_model->getAll("friends",array('user'=>$data['user_id']))->result_array();
					$data['brrowing']=$this->Common_model->getAll("group_account",array('member_id'=>$data['user_id']))->result_array();

					$data['list']=$this->Common_model->getAll("friends")->result_array();
				
				//	$data['add_registration'] = base_url().'Welcome/add';
				//	$data['get_data'] = $this->Register_model->get_data();
			$this->load->view('common/header');
			$this->load->view('common/nav',$data);
			$this->load->view('profile',$data);
			$this->load->view('common/footer');
				
		}
	}




}