


        <!--**********************************
            Content body start
        ***********************************-->
 

        <div class="content-body">

            <div class="container-fluid mt-3">
                <div class="row">
                <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-3">
                            <div class="card-body">
                                <h3 class="card-title text-white">Account Balance</h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white">   
                                <?php 
                                    $balance = $this->Common_model->getAll("total_balance",array('user_id'=>$user_id))->row_array();
                                    echo $balance['total_amount'];
                                ?>    
                            
                                </h2>
                                    <a class="text-white mb-0" href= "<?php echo base_url('index.php/paytym');?>" ><button  class="btn btn-success">Add Money</button></p></a>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-inr"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-3">
                            <div class="card-body">
                                <h3 class="card-title text-white">Friends</h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white">   
                                <?php echo $numberFriends; ?>    
                                </h2>
                                    <a class="text-white mb-0" href= "<?php echo base_url('index.php/add_friend');?>" ><button  class="btn btn-success">Add Friends</button></p></a>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-user-circle"></i></span>
                            </div>
                        </div>
                    </div>
              
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-3">
                            <div class="card-body">
                                <h3 class="card-title text-white">Group</h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white">                               
                                     <?php echo $numberGroups; ?>    </h2>
                               
                                    <a class="text-white mb-0" href= "<?php echo base_url('index.php/create_group');?>"><button  class="btn btn-success">Group</button></p></a>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-users"></i></span>
                            </div>
                        </div>
                    </div>
        </div>
        </div>



    <?php $allGrp = $this->Common_model->getAll("groups")->result_array();
        //now check for logged in user groups
        $i=0;
        foreach($allGrp as $a){
            $expl_usr = explode(',',$a['users']);
            if(in_array($user_id,$expl_usr)){
                $i+=1;
            }
        }
        if($i>0){
    ?>
    <div class="container-fluid mt-12">
        
        <div class="row">
        <?php foreach($allGrp as $g) {
            $expl_usr = explode(',',$g['users']);
            if(in_array($user_id,$expl_usr)){
            ?>
                <div class="col-xl-4 col-lg-12 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="wallet-card">
                                <div class="wallet-logo">
                                    <i class="cc BTC"></i>
                                    <h4><?php echo $g['group_name']; ?></h4>
                                </div>
                                <div class="wallet-address">
                                    <h5>Add / Withdraw Money</h5>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-outline-primary" type="button">
                                                <i class="cc BTC"></i>
                                            </button>
                                        </div>
                                        <input type="text" id="amt-<?php echo $g['id']; ?>" placeholder="100" class="form-control">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary" type="button">
                                                <i class="fa fa-file-text"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="wallet-info">
                                <table class="table">
                                    <tr>
                                        <td>Group Balance</td>
                                        <td id="grp_bal-"<?php echo $g['id']; ?>>8,520/- </td>
                                    </tr>
                                    <tr>
                                        <td>Group Limit</td>
                                        <td><?php echo $g['limit']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Group Lane Score</td>
                                        <td><?php echo $g['lane_limit']; ?></td>
                                    </tr>
                                </table>
                                    
                                    <?php echo form_open($borrow); ?>
                                        <input type="hidden" name="id" value="<?php echo $g['id']; ?>">
                                        <a class="btn btn-danger" onclick="withdraw(<?php echo $g['id']; ?>);" href="#">Withdraw</a>


                                    <a class="btn btn-success" href="#">Deposit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
            <?php }//end of internal if (for showing specific group names)
            } //end of foreach 
        } //end of if statement for checking of group 
        
        ?>
    </div>

    <script>
        function withdraw(id){
            var amount = $("#amt-"+id).val();
            if(amount != ""){
                $.ajax({
                    url: '<?php echo base_url() ?>/index.php/Welcome/withdraw/'+id+'/'+amount,
                    cache: false,

                    success: function(response){
                        $("#grp_bal"+id).html(response);
                    }
                });
            }else{
                alert("Enter a valid amount!");
            }
            
        } 
    </script>
       <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Transactions</h4>
                            <div class="table-responsive verticle-middle">
                                <table class="table">
                                    <thead class="thead-warning">
                                        <tr>
                                            <th scope="col">Group</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Change In</th>
                                            <th scope="col">Change 24h</th>
                                            <th scope="col">Change 7d</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>
                                                <i class="cc BTC f-s-30"></i>
                                            </th>
                                            <td>Bitcoin</td>
                                            <td>$12655</td>
                                            <td>
                                                <span class="color-danger">- 0.35%</span>
                                            </td>
                                            <td>
                                                <span class="color-danger">- 0.45%</span>
                                            </td>
                                            <td>
                                                <span class="color-success">+ 0.45%</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <i class="cc LTC f-s-30"></i>
                                            </th>
                                            <td>Litecoin</td>
                                            <td>$12655</td>
                                            <td>
                                                <span class="color-danger">- 0.35%</span>
                                            </td>
                                            <td>
                                                <span class="color-danger">- 0.45%</span>
                                            </td>
                                            <td>
                                                <span class="color-success">+ 0.45%</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <i class="cc XRP f-s-30"></i>
                                            </th>
                                            <td>Ripple</td>
                                            <td>$12655</td>
                                            <td>
                                                <span class="color-danger">- 0.35%</span>
                                            </td>
                                            <td>
                                                <span class="color-danger">- 0.45%</span>
                                            </td>
                                            <td>
                                                <span class="color-success">+ 0.45%</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <i class="cc DASH f-s-30"></i>
                                            </th>
                                            <td>Dash</td>
                                            <td>$12655</td>
                                            <td>
                                                <span class="color-danger">- 0.35%</span>
                                            </td>
                                            <td>
                                                <span class="color-danger">- 0.45%</span>
                                            </td>
                                            <td>
                                                <span class="color-success">+ 0.45%</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <i class="cc NOTE f-s-30"></i>
                                            </th>
                                            <td>Note</td>
                                            <td>$12655</td>
                                            <td>
                                                <span class="color-danger">- 0.35%</span>
                                            </td>
                                            <td>
                                                <span class="color-danger">- 0.45%</span>
                                            </td>
                                            <td>
                                                <span class="color-success">+ 0.45%</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <i class="cc NEO f-s-30"></i>
                                            </th>
                                            <td>NEO</td>
                                            <td>$12655</td>
                                            <td>
                                                <span class="color-danger">- 0.35%</span>
                                            </td>
                                            <td>
                                                <span class="color-danger">- 0.45%</span>
                                            </td>
                                            <td>
                                                <span class="color-success">+ 0.45%</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
       </div></div></div></div>
       