<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller
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
				//	$data['friendsCount'] = base_url().'index.php/Welcome/friendsCount';
				    $data['bal']=$this->Common_model->getAll("total_balance",array('user_id'=>$this->tank_auth->get_user_id()))->row_array();
                    $amount=$data['bal']['total_amount'];
					$data['list']=$this->Common_model->getAll("groups")->result_array();
					$data['list']=$this->Common_model->getMembers()->result_array();
					$data['borrow'] = base_url().'index.php/Welcome/borrow';
					$data['lane_score'] = base_url().'index.php/Welcome/lane_score';
					$score['list']=$this->Common_model->getfriendcount('lane_friend_temp');

					//get count of friends start
					$user_id=$this->tank_auth->get_user_id();
					$getCount=$this->Common_model->getAll("friends",array('user'=>$user_id))->row_array();
					$expl=explode(',',$getCount['friends']);
					//print_r($getCount);
					$i=0;
					foreach($expl as $e)
					{
						$i=$i+1;
			
					}
					$data['numberFriends']=$i;



					
					//get count of friends end
					 $user_id=$this->tank_auth->get_user_id();
					 $getUsers=$this->Common_model->getAll("groups")->result_array();
					 $i=0;
					 foreach($getUsers as $user)
					 {
					 	$expl=explode(',',$user['users']);
					 	foreach($expl as $e)
					 	{
					 		if($e == $user_id)
					 		{
					 			$i+=1;
					 		}
					 	}
					 }
					 $data['numberGroups']=$i;
					// echo $i;

					//get count of groups start

					//get count of groups end
				//	$data['add_registration'] = base_url().'Welcome/add';
				//	$data['get_data'] = $this->Register_model->get_data();
					$this->load->view('common/header');
					$this->load->view('common/nav',$data);
					$this->load->view('welcome',$data);
					$this->load->view('common/footer');
				
		}
	}

	// public function friendsCount(){
	// 	$user_id=$this->tank_auth->get_user_id();
	// 	$getUsers=$this->Common_model->getAll("groups")->result_array();
	// 	$i=0;
	// 	foreach($getUsers as $user){
	// 		$expl=explode(',',$user['users']);
	// 		foreach($expl as $e){
	// 			if($e == $user_id){
	// 				$i+=1;
	// 			}
	// 		}
	// 	}
	// 	echo $i;
	// }

	function borrow()
	{
	   $data['grpid']=$this->input->post('id');
	   $data['borrow']=$this->input->post('borrow');
	   $userId=$this->tank_auth->get_user_id();

	   //$data['borrow'] = base_url().'index.php/Create_group/borrow';
   	   //$data['borrowMoney'] = base_url().'index.php/Create_group/borrowMoney';
    //    $grp['list']=$this->Common_model->getAll("groups",array('id'=>'1'))->result_array();
	//    $insert=$this->Common_model->insert("group_account",array('member_id'=>$userId,'borrow'=>$data['borrow'],'group_id'=>$data['grpid']));

		   echo $data['borrow'];
		   $data['lane'] = base_url()."/Welcome/lane";
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


	  $insertTransaction=$this->Common_model->insert("transaction",array('user_to'=>$userId,'group_from'=>$group_id,'type'=>'deposit'));
redirect('/welcome');

   }	
public function laneScore()
{

	 $score=$this->Common_model->getfriendcount('lane_friend_temp');
	 $countt=$this->Common_model->getnumrows('lane_friend_temp');
 
	for($i=0;$i<$countt;$i++) 
	{
	 	if($score[$i]['total']>='2')
     	{
			$getBal=$this->Common_model->getAll("total_balance",array('user_id'=>$score[$i]['user_id']))->row_array();

     }
	 		$update=$this->Common_model->update("total_balance",array('lane_score'=>$getBal['lane_score']+1),array('user_id'=>$score[$i]['user_id']));
	}
	
	
	// print_r($groupscore);

// lane score for transaction

 $getTransaction=$this->Common_model->getTransaction("transaction");
 $countTran=$this->Common_model->getTransactionrows("transaction");
 for($i=0;$i<$countTran;$i++) 
	{
 	if($getTransaction[$i]['total']>='2')
     {
	$getBal=$this->Common_model->getAll("total_balance",array('user_id'=>$getTransaction[$i]['user_id']))->row_array();

		$update=$this->Common_model->update("total_balance",array('lane_score'=>$getBal['lane_score']+1),array('user_id'=>$getTransaction[$i]['user_id']));
	}
 	}
	
//lane score for type = deposit
$getTransaction=$this->Common_model->getDepositrows("transaction");
$n=sizeof($getTransaction);
for($i=0;$i<$n;$i++)
{

$getdeposit=$this->Common_model->getAll("transaction",array('type'=>"deposit",'user_id'=>$getTransaction[$i]['user_id']))->result_array();



   $count=0;
 foreach($getdeposit as $deposit)
  { 
	  if($deposit['amount']>=500)
	  {

	   $count=1+$count;
			if($count>1)
			{
			$getBal=$this->Common_model->getAll("total_balance",array('user_id'=>$deposit['user_id']))->row_array();

			$update=$this->Common_model->update("total_balance",array('lane_score'=>$getBal['lane_score']+1),array('user_id'=>$deposit['user_id']));
			}

	  }

  }
 }

 //   lane score for type = withdraw
 $getTransaction=$this->Common_model->getWithdrawrows("transaction");
 //print_r($getTransaction);
 $n=sizeof($getTransaction);
for($i=0;$i<$n;$i++)
{

$getWithdraw=$this->Common_model->getAll("transaction",array('type'=>"withdraw",'user_id'=>$getTransaction[$i]['user_id']))->result_array();
//print_r($getWithdraw);
	$count=0;
	foreach($getWithdraw as $withdraw) {
		if($withdraw['amount']>=500) {
			$count=1+$count;
				if($count>1) {
				   //print_r($count);
				   $getBal=$this->Common_model->getAll("total_balance",array('user_id'=>$withdraw['user_id']))->row_array();
				   $update=$this->Common_model->update("total_balance",array('lane_score'=>$getBal['lane_score']+1),array('user_id'=>$withdraw['user_id']));

				}
		}
	}
}

//lane score time taken to deposit





$getTransaction=$this->Common_model->getDepositrows("transaction");

$getWithdraw=$this->Common_model->getWithdrawrows("transaction");


 $w=sizeof($getWithdraw);
for($i=0;$i<$w;$i++)
  {

 $Withdraw=$this->Common_model->getAll("transaction",array('type'=>"withdraw",'user_id'=>$getWithdraw[$i]['user_id']))->result_array();
 foreach($Withdraw as $with)
 {

 $fromgroup=$with['group_from'];
 $touser=$with['user_to'];
 $time1=$with['Time'];	
 $getUser=$with['user_id'];
 $deposit=$this->Common_model->getAll("transaction",array('type'=>"deposit",'user_id'=>$getUser))->result_array();
//print_r($deposit);
 }

  foreach($deposit as $depo)
 {

 $togroup=$depo['group_to'];
 $fromuser=$depo['user_from'];

if($fromgroup==$togroup&&$touser==$fromuser){
  $time1=$with['Time'];
  $time2=$depo['Time'];
  $diff = abs(strtotime($time2) - strtotime($time1));
  $years = floor($diff / (365*60*60*24));
  $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
 $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
if($days==4){
$id=$depo['user_id'];
	$getBal=$this->Common_model->getAll("total_balance",array('user_id'=>$id))->row_array();
	
	$update=$this->Common_model->update("total_balance",array('lane_score'=>$getBal['lane_score']+1),array('user_id'=>$id));
	
//   lane score for type = withdraw
  $getTransaction=$this->Common_model->getWithdrawrows("transaction");
  //print_r($getTransaction);
  $n=sizeof($getTransaction);

}




}

  }
}



}


	public function withdraw($id,$amount){
		$borrow=$amount;
		$group_id=$id;
		$userId=$this->tank_auth->get_user_id();
		$insert=$this->Common_model->insert("group_account",array('member_id'=>$userId,'borrow'=>$borrow,'group_id'=>$group_id));
		$grp=$this->Common_model->getAll("groups",array('id'=>$group_id))->row_array();
 
		$update=$this->Common_model->update("groups",array('group_balance'=>$grp['group_balance']-$borrow),array('id'=>$group_id));

		$getBal=$this->Common_model->getAll("total_balance",array('user_id'=>$userId))->row_array();
		
		$updatebal=$this->Common_model->update("total_balance",array('total_amount'=>$getBal['total_amount']+$borrow),array('user_id'=>$userId));
 
 
	   	$insertTransaction=$this->Common_model->insert("transaction",array('user_to'=>$userId,'group_from'=>$group_id,'type'=>'deposit'));
 
		$getUpdatedGrpBalace = $this->Common_model->getAll("groups", array('id'=>$id))->row_array();
		
		echo json_encode($getUpdatedGrpBalace['group_balance']);
		
	}

}
	// public function deposit($id,$amount){
	// 	$deposit=$amount;
	// 	$group_id=$id;
	// 	$userId=$this->tank_auth->get_user_id();
	// 	$insert=$this->Common_model->insert("group_account",array('member_id'=>$userId,'borrow'=>$borrow,'group_id'=>$group_id));
	// 	$grp=$this->Common_model->getAll("groups",array('id'=>$group_id))->row_array();
 
	// 	$update=$this->Common_model->update("groups",array('group_balance'=>$grp['group_balance']-$borrow),array('id'=>$group_id));

	// 	$getBal=$this->Common_model->getAll("total_balance",array('user_id'=>$userId))->row_array();
		
	// 	$updatebal=$this->Common_model->update("total_balance",array('total_amount'=>$getBal['total_amount']+$borrow),array('user_id'=>$userId));
 
 
	//    	$insertTransaction=$this->Common_model->insert("transaction",array('user_to'=>$userId,'group_from'=>$group_id,'type'=>'deposit'));
 
	// 	$getUpdatedGrpBalace = $this->Common_model->getAll("groups", array('id'=>$id))->row_array();
		
	// 	echo json_encode($getUpdatedGrpBalace['group_balance']);
		
	// }




