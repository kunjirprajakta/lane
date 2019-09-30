<div class="content-body">

            <div class="row page-titles mx-0">
                <div class="col p-md-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->

 <div class="container-fluid">
    <div class="row">
    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Add Friends</h4>
                                <div class="basic-form">
                                    <?php echo form_open($addFriend);?>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" name="Email_id" placeholder="Enter Friend's Email Id">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-dark" type="submit">Send Request</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
        
        </div>
        
    </div>
    
    <div class="container-fluid">
    
        <div class="row page-titles">
            <div class="col-md-6 col-sm-4 col-lg-6 col-xl-6 p-r-0 align-self-center">
                <h3 class="text-primary">Friend Requests (<?php echo count($request_list); ?>)</h3>
            </div>
        </div>
        <div class="row">
        <?php $i=1; foreach($request_list as $req){
            $name=$this->Common_model->getAll("users",array('id'=>$req['from']))->row_array();
            ?>

                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="member-grid">
                                <div class="text-center">
                                    <img class="img-fluid rounded-circle m-b-15" width="60" src="<?php echo $name['profile_image']; ?>" alt="">
                                    <div class="team_member_info">
                                        <h4><?php echo $name['name']; ?></h4>
                                        <p class="m-b-10">Lane Score: 78</p>
                                        <table class="table">
                                            <tr>
                                                <td style="align:center">
                                                <?php echo form_open($accept); ?>
                                                <input type="hidden" name="id" value="<?php echo $req['from']; ?>">
                                                <button type="submit" class="mb-2 btn btn-sm btn-success mr-1">Accept</button>
                                                </form>
                                                </td>
                                                <td style="align:center">
                                                <?php echo form_open($reject); ?>
                                                <input type="hidden" name="id" value="<?php echo $req['id']; ?>">
                                                <button type="submit" class="mb-2 btn btn-sm btn-danger mr-1">Reject</button>
                                                </form>
                                                </td>
                                            </tr>
                                        </table>
                                        

                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <a class="text-muted" href="#">
                                                    <i class="fa fa-facebook"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a class="text-muted" href="#">
                                                    <i class="fa fa-twitter"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a class="text-muted" href="#">
                                                    <i class="fa fa-linkedin"></i>
                                                </a>
                                            </li>
                                            
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <!-- #/ container -->
    
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-3 col-sm-4 col-lg-3 col-xl-2 p-r-0 align-self-center">
                <h3 class="text-primary">Friends List</h3>
            </div>
        </div>
    
        <div class="row">
                <?php $getFriends = $this->Common_model->getAll("friends",array('user'=>$user_id))->row_array(); 
                $expl_friends = explode(',',$getFriends['friends']);
                foreach($expl_friends as $f){
                    $name = $this->Common_model->getAll("users",array('id'=>$f))->row_array();
                ?>

                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="member-grid">
                                <div class="text-center">
                                    <img class="img-fluid rounded-circle m-b-15" width="60" src="<?php echo $name['profile_image']; ?>" alt="">
                                    <div class="team_member_info">
                                        <h4><?php echo $name['name']; ?></h4>
                                        <p class="m-b-10">Lane Score: 78</p>
                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <a class="text-muted" href="#">
                                                    <i class="fa fa-facebook"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a class="text-muted" href="#">
                                                    <i class="fa fa-twitter"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a class="text-muted" href="#">
                                                    <i class="fa fa-linkedin"></i>
                                                </a>
                                            </li>
                                            
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <!-- #/ container -->
    </div>
</div>
                    
            