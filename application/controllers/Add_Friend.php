<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Add_Friend extends CI_Controller
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
				
				$data['addFriend'] = base_url().'index.php/Add_Friend/addFriend';
				$data['request_list']=$this->Common_model->getAll("friend_request",array('to'=>$data['user_id']))->result_array();
				$data['friend_list']=$this->Common_model->getAll("friends")->result_array();
				$data['reject']= base_url().'index.php/Add_Friend/reject';
				$data['accept']= base_url().'index.php/Add_Friend/accept';
				//	$data['add_registration'] = base_url().'Welcome/add';
				//	$data['get_data'] = $this->Register_model->get_data();
			$this->load->view('common/header');
			$this->load->view('common/nav',$data);
			$this->load->view('add_friend',$data);
			$this->load->view('common/footer');
				
		}
	}
	 function addFriend()
	{
		//$data=this->input->post();
		
		$email_id=$this->input->post('Email_id');
		$friend=$this->Common_model->getAll("users",array('email'=>$email_id))->row_array();
		$userId=$this->tank_auth->get_user_id();//we get user's id
		$insert=$this->Common_model->insert("friend_request",array('from'=>$userId,'to'=>$friend['id']));
		//print_r($friend['id']);
		echo "Friend Request send Successfully";
		redirect('add_friend');
		
	}
	function accept()
	{	
		$userId=$this->tank_auth->get_user_id();//we get user's id, to[id]

		$req_from_id=$this->input->post('id');  //18-from[id]
		
		$getList=$this->Common_model->getAll("friends",array('user'=>$userId))->row_array(); //to info
		$getListFrom=$this->Common_model->getAll("friends",array('user'=>$req_from_id))->row_array(); //from info
		echo $getListFrom['user'];


		if(!empty($getList) && !empty($getListFrom)){
		//to wala part start
		$getFriendListTo=$this->Common_model->getAll("friends",array('user'=>$userId))->row_array();
		$expl_to=explode(',',$getFriendListTo['friends']);
		array_push($expl_to,$req_from_id);
		$impl_to=implode(',',$expl_to);
		$update=$this->Common_model->update("friends",array('friends'=>$impl_to),array('user'=>$userId));
		//to wala part khatam

		//from wala part start
		//apan yaha jiski request aayi this uski friend list ko update karenge
		$getFriendListFrom=$this->Common_model->getAll("friends",array('user'=>$req_from_id))->row_array();
		$expl_from=explode(',',$getFriendListFrom['friends']);
		array_push($expl_from,$userId);
		$impl_from=implode(',',$expl_from);
		$update=$this->Common_model->update("friends",array('friends'=>$impl_from),array('user'=>$req_from_id));
		$insert3=$this->Common_model->insert("lane_friend_temp",array('user_id'=>$req_from_id,'friends_id'=>$userId));

		}

		else if(empty($getListFrom) && !empty($getList)){
			$insert=$this->Common_model->insert("friends",array('user'=>$req_from_id,'friends'=>$userId));
			$getFriendListFrom=$this->Common_model->getAll("friends",array('user'=>$req_from_id))->row_array();
			$expl_from=explode(',',$getFriendListFrom['friends']);
			array_push($expl_from,$userId);
			$impl_from=implode(',',$expl_from);
			$update=$this->Common_model->update("friends",array('friends'=>$impl_from),array('user'=>$req_from_id));
			$insert3=$this->Common_model->insert("lane_friend_temp",array('user_id'=>$req_from_id,'friends_id'=>$userId));

		}
		else if(empty($getList) && !empty($getListFrom)){
			$insert=$this->Common_model->insert("friends",array('user'=>$userId,'friends'=>$req_from_id));
			$getFriendListTo=$this->Common_model->getAll("friends",array('user'=>$req_from_id))->row_array();
			$expl_to=explode(',',$getFriendListTo['friends']);
			array_push($expl_to,$userId);
			$impl_to=implode(',',$expl_to);
			$update=$this->Common_model->update("friends",array('friends'=>$impl_to),array('user'=>$req_from_id));
			$insert3=$this->Common_model->insert("lane_friend_temp",array('user_id'=>$req_from_id,'friends_id'=>$userId));

		}
		else {
			$insert1=$this->Common_model->insert("friends",array('user'=>$req_from_id,'friends'=>$userId));
			$insert2=$this->Common_model->insert("friends",array('user'=>$userId,'friends'=>$req_from_id));
			$insert3=$this->Common_model->insert("lane_friend_temp",array('user_id'=>$req_from_id,'friends_id'=>$userId));
		}

		$delete=$this->Common_model->delete("friend_request",array('to'=>$userId));
		 redirect(base_url('index.php/add_friend'));
		

	}

	public function reject(){
        $id=$this->input->post('id');
        $delete=$this->Common_model->delete("friend_request",array('id'=>$id));
        redirect(base_url('index.php/add_friend'));
    }
}
