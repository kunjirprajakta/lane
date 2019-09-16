
 <?php   require_once(APPPATH."libraries/config_paytm.php");
    require_once(APPPATH."libraries/encdec_paytm.php");
    

if (!defined('BASEPATH')) exit('No direct script access allowed');



class Paytym extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('tank_auth');

		$this->load->helper('form');
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
          $data['user_info']=$this->Common_model->getAll("users",array('id'=>$this->tank_auth->get_user_id()))->row_array();
          $data['displayamount'] = base_url().'index.php/Paytym/displayamount';
          $data['StartPayment'] = base_url().'index.php/Paytym/StartPayment';
          $data['bal']=$this->Common_model->getAll("total_balance",array('user_id'=>$this->tank_auth->get_user_id()))->row_array();
          $data['tat']=$data['bal']['total_amount'];
     
				//	$data['add_registration'] = base_url().'Welcome/add';
				//	$data['get_data'] = $this->Register_model->get_data();
			$this->load->view('common/header');
			$this->load->view('common/nav',$data);
			$this->load->view('paytym',$data);
			$this->load->view('common/footer');
				
		}
  }
 

  
  



  

    public function StartPayment()
    {
   
   // TXN_AMOUNT
  
        $data['user_info']= $this->Common_model->getAll("users",array('id'=>$this->tank_auth->get_user_id()))->row_array();
        $userid=$data['user_info']['id'];
        $useremail=$data['user_info']['email'];
        $paramList["MID"] = PAYTM_MERCHANT_MID;
        $paramList["ORDER_ID"] = $userid."-".rand(2000,100);     
        $paramList["CUST_ID"] = $userid;   /// according to your logic
        $paramList["INDUSTRY_TYPE_ID"] = 'RETIAL';
        $paramList["CHANNEL_ID"] = 'WEB';
        $paramList["TXN_AMOUNT"] =  $this->input->post('amountpay');
        $paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;
   
        $paramList["CALLBACK_URL"] = "http://localhost/lane/Paytym/PaytmResponse/".$userid."/".$paramList["TXN_AMOUNT"];
        $paramList["MSISDN"] = '77777777'; //Mobile number of customer
        $paramList["EMAIL"] =$useremail;
        $paramList["VERIFIED_BY"] = "EMAIL"; //
        $paramList["IS_USER_VERIFIED"] = "YES"; //
        $insert=$this->Common_model->insert("total_deposit",$paramList);
        $checkSum = getChecksumFromArray($paramList,PAYTM_MERCHANT_KEY);

        ?>
       

        <!--submit form to payment gateway OR in api environment you can pass this form data-->
   
        <form id="myForm" action="<?php echo PAYTM_TXN_URL ?>" method="post">
        <?php
         foreach ($paramList as $a => $b) {
       echo '<input type="hidden" name="'.htmlentities($a).'" value="'.htmlentities($b).'">';
       }
       ?>
            <input type="hidden" name="CHECKSUMHASH" value="<?php echo $checkSum ?>">
        </form>
        <script type="text/javascript">
            document.getElementById('myForm').submit();
         </script>

<?php
    }
    

    /////////// response from paytm gateway////////////
    public function PaytmResponse($userid,$amount)
    {
      $getinfo=$this->Common_model->getAll('total_balance',array('user_id'=>$userid))->row_array();
      if(isset($getinfo))
      {
        $update=$this->Common_model->update('total_balance',array('total_amount'=>$getinfo['total_amount']+$amount),array('user_id'=>$userid));
      }
      else{
        $insert=$this->Common_model->insert('total_balance',array('user_id'=>$userid,'total_amount'=>$amount));

      }
      $data['amount']=$this->Common_model->getAll("total_balance",array('user_id'=>$this->tank_auth->get_user_id()))->row_array();
      $total=$data['amount']['total_amount'];

      redirect(base_url('index.php/paytym'));
      //$insert=$this->Common_model->insert('total_balance',array('user_id'=>$userid,'total_amount'=>$amount));

     // redirect(base_url('index.php/paytym'));
        // $paytmChecksum = "";
        // $paramList = array();
        // $isValidChecksum = "FALSE";

        // $paramList = $_POST;
        // echo "<pre>";
        // print_r($paramList);
   
//        $paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg
//
//        $isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.
//
//        if($isValidChecksum == "TRUE")
//        {
//            if ($_POST["STATUS"] == "TXN_SUCCESS")
//            { /// put your to save into the database // tansaction successfull
//                var_dump($paramList);
//            }
//            else {/// failed
//                var_dump($paramList);
//            }
//        }else
//        {//////////////suspicious
//           // put your code here
//       
//        }
    }
  }









    