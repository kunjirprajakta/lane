  <!-- sidebar -->
  <div class="nk-sidebar">
            <div class="nk-nav-scroll">

                <div class="nav-user">
                    <img src="<?php $getImg=$this->Common_model->getAll("users", array('id'=>$user_id))->row_array(); echo $getImg['profile_image'];?>" alt="" class="rounded-circle">
                    <h5>Tanmay Nigde</h5>
                    <p>UI Developer</p>

                    <div class="nav-user-option">
                        <div class="setting-option">
                            <div data-toggle="dropdown">
                                <i class="icon-settings"></i>
                            </div>
                            <div class="dropdown-menu animated flipInX">
                                <a class="dropdown-item" href="#">Account</a>
                                <a class="dropdown-item" href="#">Lock</a>
                                <a class="dropdown-item" href="<?php echo base_url('/index.php/logout') ?>">Logout</a>
                            </div>
                        </div>
                        <div class="notification-option">
                            <div data-toggle="dropdown">
                                <i class="icon-bell"></i>
                            </div>
                            <div class="dropdown-menu animated flipInX">
                                <a class="dropdown-item" href="#">Email
                                    <span class="badge badge-primary pull-right m-t-3">05</span>
                                </a>
                                <a class="dropdown-item" href="#">Feed back
                                    <span class="badge badge-danger pull-right m-t-3">02</span>
                                </a>
                                <a class="dropdown-item" href="#">Report
                                    <span class="badge badge-warning pull-right m-t-3">02</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <ul class="metismenu" id="menu">

                    <li class="nav-label">Main</li>
                   
                            <li>
                                    <a  href= "<?php echo base_url('index.php/welcome');?>" aria-expanded="false">
                                    <span class="nav-text">Dashboard</span></a>
                            </li>
                            <li>
                                    <a href= "<?php echo base_url('index.php/add_friend');?>" aria-expanded="false">
                                    <span class="nav-text">Add Friends</span></a>
                            </li>
                            </li>
                            <li>
                                    <a href= "<?php echo base_url('index.php/create_group');?>" aria-expanded="false">
                                    <span class="nav-text">Create Group</span></a>
                            </li>
                            <li>
                                    <a href= "<?php echo base_url('index.php/member_request');?>" aria-expanded="false">
                                    <span class="nav-text">Friend Request</span></a>                            </li>
                            <li>
                                    <a href= "<?php echo base_url('index.php/profile');?>" aria-expanded="false">
                                    <span class="nav-text">Profile</span></a>
                            </li>
                    
                </ul>
            </div>
            <!-- #/ nk nav scroll -->
        </div>
        <!-- #/ sidebar -->
