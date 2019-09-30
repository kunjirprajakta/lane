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

        <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="user-profile">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="user-photo m-b-30">
                                            <img src="<?php $getImg=$this->Common_model->getAll("users", array('id'=>$user_id))->row_array(); echo $getImg['profile_image'];?>" alt="" class="img-responsive">
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="user-profile-name">
                                        <?php $i=1; foreach($request as $req){?>
                                        <?php $name=$this->Common_model->getAll("users",array('id'=>$req['id']))->row_array(); 
                                        echo $name['name'];
                                        ?>
                                        <?php } ?></div>
                                        <!-- <div class="user-Location">
                                            <i class="ti-location-pin"></i> NY, USA</div>
                                        <div class="user-job-title">Senior Advisor</div> -->
                                        <!-- <div class="ratings">
                                            <h4>Ratings</h4>
                                            <div class="rating-star">
                                                <span>8.9</span>
                                                <i class="ti-star color-primary"></i>
                                                <i class="ti-star color-primary"></i>
                                                <i class="ti-star color-primary"></i>
                                                <i class="ti-star color-primary"></i>
                                                <i class="ti-star"></i>
                                            </div>
                                        </div> -->
                                        <!-- <div class="user-send-message">
                                            <button class="btn btn-primary btn-addon" type="button">
                                                <i class="ti-email m-r-10"></i>Send Message</button>
                                        </div> -->
                                        <div class="contact-information">
                                        <div class="address-content">
                                                <span class="contact-title">Balance:</span>
                                                <span class="mail-address">
                                                <?php  foreach($balance as $b){?>
                                                    <?php echo $b['total_amount'];
                                                    //echo $b['total_amount'];
                                                ?>
                                                <?php } ?></span>
                                            </div>
                                            <h4>Contact information</h4>
                                            <div class="phone-content">
                                                <span class="contact-title">Phone:</span>
                                                <span class="phone-number">9075127125</span>
                                            </div>
                                            <div class="address-content">
                                                <span class="contact-title">Address:</span>
                                                <span class="mail-address">Pimpri Pune</span>
                                            </div>
                                            <div class="email-content">
                                                <span class="contact-title">Email:</span>
                                                <span class="contact-email">
                                                <?php  foreach($request as $req){?>
                                                    <?php echo $req['email'];
                                                ?>
                                                <?php } ?></span>
                                            </div>
                                            <!-- <div class="website-content">
                                                <span class="contact-title">Website:</span>
                                                <span class="contact-website">www.9kit.net</span>
                                            </div>
                                            <div class="skype-content">
                                                <span class="contact-title">Skype:</span>
                                                <span class="contact-skype">sporsho9</span>
                                            </div> -->
                                        </div>
                                        <div class="basic-information">
                                            <h4>Basic information</h4>
                                            <div class="birthday-content">
                                                <span class="contact-title">Birthday:</span>
                                                <span class="birth-date">Augest 29, 1998 </span>
                                            </div>
                                            <div class="gender-content">
                                                <span class="contact-title">Gender:</span>
                                                <span class="gender"><?php echo $req['gender'];
                                                ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>






 

        <!-- <div class="text-center">
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
                        </div> -->