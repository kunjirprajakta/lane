<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Create_group extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('tank_auth');

		$this->load->helper('form');
	//	$this->load->model('GetCurrent_model');
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
			$data['borrow'] = base_url().'index.php/Create_group/borrow';
			$data['updatelimit'] = base_url().'index.php/Create_group/updatelimit';

			$data['addGroup'] = base_url().'index.php/Create_group/addGroup';
			$data['addMembers'] = base_url().'index.php/Create_group/addMembers';
			$data['request_list']=$this->Common_model->getAll("group_request",array('to'=>$data['user_id']))->result_array();
			$data['group_list']=$this->Common_model->getAll("groups")->result_array();
			
		    $data['reject']= base_url().'index.php/Create_group/reject';
			$data['accept']= base_url().'index.php/Create_group/accept';
			$data['borrowMoney'] = base_url().'index.php/Create_group/borrowMoney';
			


			$this->load->view('common/header');
			$this->load->view('common/nav',$data);
			$this->load->view('create_group',$data);
			$this->load->view('common/footer');
				
		}
	}
	public function addGroup()
	{
		
		$user_id=$this->tank_auth->get_user_id();//we get user's id
		$groupName=$this->input->post('group_name');
		$member_limit=$this->input->post('member_limit');
		$lane_limit=$this->input->post('lane_limit');
		$limit=$this->input->post('limit');

		$getBal=$this->Common_model->getAll('total_balance',array('user_id'=>$user_id))->row_array();
        if($getBal['total_amount']>=$limit )
        {
			$uniqueId=rand(11111,99999);
			$insert=$this->Common_model->insert("groups",array('admin'=>$user_id,'group_name'=>$groupName,'limit'=>$limit,'link'=>$uniqueId,'group_balance'=>$limit,'lane_limit'=>$lane_limit,'users'=>$user_id,'member_limit'=>$member_limit));

			$getGroup=$this->Common_model->getAll("groups",array('link'=>$uniqueId))->row_array();
			
            $groupLimit=$getGroup['limit'];
			   $this->updatelimit($groupLimit);
			   redirect('/create_group');

		}
		else
		{
			echo "group cannot be create";
		}
	}
		
	
	 public function updatelimit($groupLimit){
	 	$user_id=$this->tank_auth->get_user_id();//we get user's id

	 	$getBal=$this->Common_model->getAll('total_balance',array('user_id'=>$user_id))->row_array();
	// 	print_r($getBal['total_amount']);
	 	$update=$this->Common_model->update('total_balance',array('total_amount'=>$getBal['total_amount']-$groupLimit),array('user_id'=>$user_id));
	 	$getGroup=$this->Common_model->getAll("groups",array('admin'=>$user_id))->row_array();
         $insertTransaction=$this->Common_model->insert('transaction',array('user_from'=>$user_id,'group_to'=>$getGroup['id'],'type'=>'deposit','user_id'=>$user_id));

 	 }

	public function addMembers(){
		$data['groupLink']=$this->input->post();

		$data['addByEmail'] = base_url().'index.php/Create_group/addByEmail';

		$this->load->view('common/header');
		$this->load->view('common/nav',$data);
		$this->load->view('add_group_member',$data);
		$this->load->view('common/footer');
	}

	public function addByEmail(){
		$data=$this->input->post();
		//$data1=$this->input->post('groupLink');
		$user_id=$this->tank_auth->get_user_id();
		$toId = $this->Common_model->getAll("users",array('email'=>$data['emailid']))->row_array();
	//	print_r($toId['id']);
		$groupMember = $this->Common_model->insert("groupmember_request",array('from'=>$user_id, 'to'=>$toId['id'], 'link'=>$data['groupLink']));
		echo "frnd request sent succesfully";
		redirect('create_group');
	}



	public function joinGroup($uniqueId){
//<<<<<<< HEAD
		$getGroup=$this->Common_model->getAll("groups",array('link'=>$uniqueId))->row_array();
	 	$expl_userrs=explode(',',$getGroup['users']);
		$user_id=$this->tank_auth->get_user_id();
		array_push($expl_userrs,$user_id);
		$impl_users=implode(',',$expl_userrs);
		$update=$this->Common_model->update("groups",array('users'=>$impl_users),array('link'=>$uniqueId));
//=======
		 $getGroup=$this->Common_model->getAll("groups",array('link'=>$uniqueId))->row_array();
		 $expl_userrs=explode(',',$getGroup['users']);
		 $user_id=$this->tank_auth->get_user_id();
		 array_push($expl_userrs,$user_id);
		 $impl_users=implode(',',$expl_userrs);
		 $update=$this->Common_model->update("groups",array('users'=>$impl_users),array('link'=>$uniqueId));
//>>>>>>> 0b483ba3d4bb00288a0735d77b35df7b884029d6
		$data['user_id']	= $this->tank_auth->get_user_id();
		$data['username']	= $this->tank_auth->get_username();
		$data['name']		= $this->session->userdata("name");

		$this->load->view('common/header');
		$this->load->view('common/nav');
		$this->load->view('join_group');
		$this->load->view('common/footer');

	}

//<<<<<<< HEAD
	 function addMember()
	 {
	 	//$data=this->input->post();
		
	 	$email_id=$this->input->post('Email_id');
	 	$member=$this->Common_model->getAll("users",array('email'=>$email_id))->row_array();
	 	$userId=$this->tank_auth->get_user_id();//we get user's id
	 	$insert=$this->Common_model->insert("group_request",array('from'=>$userId,'to'=>$member['id']));
	 	echo "Member added Successfully";
		
	 }
	 function borrow()
	 {
		$data['grpid']=$this->input->post('id');
		$data['borrow']=$this->input->post('borrow');
        $userId=$this->tank_auth->get_user_id();

//	$data['borrow'] = base_url().'index.php/Create_group/borrow';
	//	$data['borrowMoney'] = base_url().'index.php/Create_group/borrowMoney';
	//$grp['list']=$this->Common_model->getAll("groups",array('id'=>'1'))->result_array();
			//$insert=$this->Common_model->insert("group_account",array('member_id'=>$userId,'borrow'=>$data['borrow'],'group_id'=>$data['grpid']));

			echo $data['borrow'];
			$data['lane'] = base_url()."/Create_group/lane";
            $this->load->view('common/header');
			$this->load->view('common/nav',$data);
			$this->load->view('borrow',$data);
			$this->load->view('common/footer');
			//$this->lane($groupid);

	 }
	function lane(){
		$borrow=$this->input->post('borrow_amount');
		$group_id=$this->input->post('id');
		$userId=$this->tank_auth->get_user_id();
		$insert=$this->Common_model->insert("group_account",array('member_id'=>$userId,'borrow'=>$borrow,'group_id'=>$group_id));
	    $grp=$this->Common_model->getAll("groups",array('id'=>$group_id))->row_array();

	    $update=$this->Common_model->update("groups",array('group_balance'=>$grp['group_balance']-$borrow),array('id'=>$group_id));
		$getBal=$this->Common_model->getAll("total_balance",array('user_id'=>$userId))->row_array();
		
		$updatebal=$this->Common_model->update("total_balance",array('total_amount'=>$getBal['total_amount']+$borrow),array('user_id'=>$userId));


       $insertTransaction=$this->Common_model->insert("transaction",array('user_to'=>$userId,'group_from'=>$group_id,'type'=>'withdraw'));
redirect('/create_group');

	}	

	public function laneScoreCount(){
		$numberOfTransactions; //Tanmay
		$numberOfFriends; //Done
		$totalDeposit; // Jagruti
		$totalWithdraw; //Jagruti
		$repaymentTimeTaken=$this->repaymentTimeTaken(); //Prajakta
	}

	public function repaymentTimeTaken(){
		
	}

	public function getTotalGroups(){
		$groups=$this->Common_model->getAll("groups")->result_array();

	}

	public function tempsize()
		{
			$userId=$this->tank_auth->get_user_id();
			$groups=$this->Common_model->getAll("groups")->result_array();
			$getBal=$this->Common_model->getAll("total_balance",array('user_id'=>$userId))->row_array();
			//groups created in this group jisme khud logged in user hai
			//if group size more than 2 hai to increment karneka value

			foreach($groups as $d){

			}

			//$count=$this->Common_model->getusercount("groups");
	//print_r($data);
			// $n=sizeof($data);
			
			// for($i=0;$i<$n;$i++)
			// {
			// 	$expl=explode(',',$data[$i]['users']);
			// 	$count=sizeof($expl);
			// 	print_r($i);

			// 	 if($count>2)
			// 	 {
			// 		  print_r($data[$i]);
			// 	 	$update=$this->Common_model->update("total_balance",array('lane_score'=>$getBal['lane_score']+1),array('user_id'=>$data[$i]['admin']));
			// 	 }
			// }
		}
	


}