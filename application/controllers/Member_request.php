<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Member_request extends CI_Controller
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
					$data['member_request_list']=$this->Common_model->getAll("groupmember_request",array('to'=>$data['user_id']))->result_array();
					$data['reject']= base_url().'index.php/Member_request/reject';
					$data['accept']= base_url().'index.php/Member_request/accept';
					$this->load->view('common/header');
					$this->load->view('common/nav',$data);
					$this->load->view('member_request',$data);
					$this->load->view('common/footer');
				
		}
	}

	function accept()
	{	

		$data=$this->input->post();
		$userId=$this->tank_auth->get_user_id();
		$getGroupUsers= $this->Common_model->getAll("groups",array('link'=>$data['link']))->row_array();
		$getUserBalance=$this->Common_model->getAll("total_balance",array('user_id'=>$userId))->row_array();
		$limit=$getGroupUsers['limit'];
	//print_r($getUserBalance['total_amount']);
		if($getGroupUsers['limit']>$getUserBalance['total_amount'])
		{
			echo "please add money";
			redirect('/paytym');

		}
else{
		$expl_user = explode(',',$getGroupUsers['users']);
		
		array_push($expl_user,$userId);

		$impl = implode(',', $expl_user);
		$update = $this->Common_model->update("groups",array('users'=>$impl,'group_balance'=>$getGroupUsers['group_balance']+$limit),array('link'=>$data['link']));
		echo "user added to group successfully";
	
		$updateUserbalance=$this->Common_model->update("total_balance",array('total_amount'=>$getUserBalance['total_amount']-$limit),array('user_id'=>$userId));
		
		$delete=$this->Common_model->delete("groupmember_request",array('link'=>$data['link']));

		redirect('/member_request');
}
		// $userId=$this->tank_auth->get_user_id();//we get user's id, to[id]

		// $req_from_id=$this->input->post('id');  //18-from[id]
		
		// $getList=$this->Common_model->getAll("groups",array('user'=>$userId))->row_array(); //to info
		// $getListFrom=$this->Common_model->getAll("groups",array('user'=>$req_from_id))->row_array(); //from info
		// $getBal=$this->Common_model->getAll('total_balance',array('user_id'=>$user_id))->row_array();

		// if($limit<$getBal['total_amount'])
		// {
		// 	$update=$this->Common_model->update('total_balance',array('total_amount'=>$getBal['total_amount']-$groupLimit),array('user_id'=>$user_id));
		// }








		

		// if(!empty($getList) && !empty($getListFrom)){
		// //to wala part start
		// $getFriendListTo=$this->Common_model->getAll("groups",array('user'=>$userId))->row_array();
		// $expl_to=explode(',',$getFriendListTo['friends']);
		// array_push($expl_to,$req_from_id);
		// $impl_to=implode(',',$expl_to);
		// $update=$this->Common_model->update("groups",array('friends'=>$impl_to),array('user'=>$userId));
		// //to wala part khatam

		// //from wala part start
		// //apan yaha jiski request aayi this uski friend list ko update karenge
		// $getFriendListFrom=$this->Common_model->getAll("groups",array('user'=>$req_from_id))->row_array();
		// $expl_from=explode(',',$getFriendListFrom['friends']);
		// array_push($expl_from,$userId);
		// $impl_from=implode(',',$expl_from);
		// $update=$this->Common_model->update("groups",array('friends'=>$impl_from),array('user'=>$req_from_id));
		// }

		// else if(empty($getListFrom) && !empty($getList)){
		// 	$insert=$this->Common_model->insert("groups",array('user'=>$req_from_id,'friends'=>$userId));
		// 	$getFriendListFrom=$this->Common_model->getAll("groups",array('user'=>$req_from_id))->row_array();
		// 	$expl_from=explode(',',$getFriendListFrom['friends']);
		// 	array_push($expl_from,$userId);
		// 	$impl_from=implode(',',$expl_from);
		// 	$update=$this->Common_model->update("groups",array('friends'=>$impl_from),array('user'=>$req_from_id));
		// }
		// else if(empty($getList) && !empty($getListFrom)){
		// 	$insert=$this->Common_model->insert("groups",array('user'=>$userId,'friends'=>$req_from_id));
		// 	$getFriendListTo=$this->Common_model->getAll("groups",array('user'=>$userId))->row_array();
		// 	$expl_to=explode(',',$getFriendListTo['friends']);
		// 	array_push($expl_to,$req_from_id);
		// 	$impl_to=implode(',',$expl_to);
		// 	$update=$this->Common_model->update("groups",array('friends'=>$impl_to),array('user'=>$userId));
		// }
		// else {
		// 	$insert1=$this->Common_model->insert("groups",array('user'=>$req_from_id,'friends'=>$userId));
		// 	$insert2=$this->Common_model->insert("groups",array('user'=>$userId,'friends'=>$req_from_id));
		// }

	}
	public function reject(){
        $id=$this->input->post('id');
        $delete=$this->Common_model->delete("groupmember_request",array('id'=>$id));
        redirect(base_url('index.php/member_request'));
    }
}
