<div class="content-body">

            <div class="row page-titles mx-0">
                <div class="col p-md-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li>
                    </ol>
                </div>
            </div>


        <!--**********************************
            Content body start
        ***********************************-->
 

        <div class="text-center">
                                <img alt="" class="rounded-circle m-t-10 w-50px" src="../assets/images/users/1.jpg">
                                <h1 class="f-w-500 m-t-15">
                                <?php $i=1; foreach($request_name as $req){?>
                                <?php $name=$this->Common_model->getAll("users",array('id'=>$req['id']))->row_array(); 
                                echo $name['name'];
                                ?>
                                <?php } ?>
                                </h1>
         </div>
         <div class="card-body">
                            <h6 class="f-s-30 f-w-300">User Id:
                            <?php $i=1; foreach($request_name as $req){?>
                            <?php $name=$this->Common_model->getAll("users",array('id'=>$req['id']))->row_array(); 
                            echo $name['id'];
                            ?>
                            <?php } ?>
                           
                        </div>



         <div class="card-body">
                            <h5 class="f-s-30 f-w-300">My Friends:
                            <?php $i=1; foreach($friends as $fri){?>
                            <?php $id=$this->Common_model->getAll("friends",array('user'=>$fri['user']))->row_array();?>
                            <?php $expl_friend=explode(',',$id['friends']); 
                               foreach($expl_friend as $ex){
                                   $name=$this->Common_model->getAll("users",array('id'=>$ex))->row_array();
                                   echo $name['name']."<br><br>";
                               } 
                            ?>
                            
                

                    
                            <?php } ?></h5>
                        </div>

                        <div class="card-body ">
                            <h6 class="f-s-30 f-w-300">My lane Score:</h6>
                            <span class="f-s-30 f-w-300 text-danger"></span>
                        </div>

                        <div class="card-body">
                            <h5 class="f-s-30 f-w-300">My Lendings:</h5>
                            <span class="f-s-30 f-w-300"></span>
                        </div>

                        <div class="card-body ">
                            <h5 class="f-s-30 f-w-300">My Borrowings:
                            <?php $i=1; foreach($brrowing as $borr){?>
                            <?php $name=$this->Common_model->getAll("group_account",array('member_id'=>$borr['id']))->row_array(); 
                            echo $name['borrow'];
                            ?>
                            <?php } ?></h5>
                            <span class="f-s-30 f-w-300 text-danger"></span>
                        </div>