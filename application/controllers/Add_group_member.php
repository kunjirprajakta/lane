<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Add_group_member extends CI_Controller
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
		if (!$this->tank_auth->is_logged_in()) 
		{
			redirect('/auth/login/');
		} 
		else 
		{
			
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['name']		= $this->session->userdata("name");
				
			$data['addFriend'] = base_url().'index.php/Add_Friend/addFriend';
			$data['request_list']=$this->Common_model->getAll("friend_request",array('to'=>$data['user_id']))->result_array();
			$data['friend_list']=$this->Common_model->getAll("friends")->result_array();
			$data['addMember'] = base_url().'index.php/add_group_member/addMember';
			$data['reject']= base_url().'index.php/Add_Friend/reject';
			$data['accept']= base_url().'index.php/Add_Friend/accept';
			//	$data['add_registration'] = base_url().'Welcome/add';
			//	$data['get_data'] = $this->Register_model->get_data();
			$this->load->view('common/header');
			$this->load->view('common/nav',$data);
			$this->load->view('add_group_member',$data);
			$this->load->view('common/footer');
				
		}
	}

	function addMember()
	{
	 	//$data=this->input->post();
		
	 	$email_id=$this->input->post('emailid');
	 	
	 	$member=$this->Common_model->getAll("users",array('email'=>$email_id))->row_array();
	 	$userId=$this->tank_auth->get_user_id();//we get user's id
	 	$insert=$this->Common_model->insert("groupmember_request",array('from'=>$userId,'to'=>$member['id']));
	 	print_r($insert);
	 	echo "Member request send Successfully";
		
	}
}
//function addFriend()
	
		//$data=this->input->post();
		
		//$email_id=$this->input->post('emailid');
		//$friend=$this->Common_model->getAll("users",array('email'=>$email_id))->row_array();
		//print_r($email_id);
		//$userId=$this->tank_auth->get_user_id();//we get user's id
		//$insert=$this->Common_model->insert("group_member",array('from'=>$userId,'to'=>$friend['id']));
		//echo "Member Request send Successfully";
		
	//}-->