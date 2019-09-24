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
                <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Create Group</h4>
                                <div class="basic-form">
                                    <?php echo form_open($addGroup);?>
                                        
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Name Of Group</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="group_name" placeholder="Group Name" required="required">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Balance Limit</label>
                                            <div class="col-sm-6">
                                                <input type="number" class="form-control" name="limit" placeholder="Balance Limit" required="required">
                                            </div>
                                        </div>
                                        <fieldset class="form-group">
                                            <div class="row">
                                                <label class="col-form-label col-sm-2 pt-0">Group Member Limit</label>
                                                <div class="col-sm-6">
                                                    <select name="member_limit" id="">
                                                        <option value="5">5</option>
                                                        <option value="10">10</option>
                                                        <option value="15">15</option>
                                                        <option value="20">20</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset class="form-group">
                                            <div class="row">
                                                <label class="col-form-label col-sm-2 pt-0">Minimum Lane Score</label>
                                                <div class="col-sm-10">
                                                    <select name="lane_limit" id="">
                                                        <option value="25">25</option>
                                                        <option value="35">35</option>
                                                        <option value="40">40</option>
                                                        <option value="60">60</option>
                                                        <option value="70">70</option>
                                                        <option value="80">80</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </fieldset>
                                        
                                        <div class="form-group row">
                                            <div class="col-sm-10">
                                                <button type="submit" class="btn btn-primary">Create Your Group</button>
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
                <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">My Group Details</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped verticle-middle">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Group Name</th>
                                            <th scope="col">Group Balance</th>
                                            <th scope="col">Lane Score Limit</th>
                                            <th scope="col">Group Member Limit</th>
                                            <th scope="col">Balance</th>
                                            <th scope="col">Add Member</th>
                                            <th scope="col">Share</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $groups = $this->Common_model->getAll("groups")->result_array(); $i=1;
                                    foreach($groups as $gr){
                                        $expl_myGrp = explode(',',$gr['users']);
                                        if(in_array($user_id,$expl_myGrp)){ ?>
                                        
                                        <tr>
                                            <td align="center">
                                                <a href="#" class="text-muted"><?php echo $i; ?></a>
                                            </td>
                                            <td align="center">
                                                <a href="#" class="" <?php if($user_id == $gr['admin']){ echo "style='color:red'"; } ?> ><?php echo $gr['group_name']; ?></a>
                                            </td>
                                            <td align="center"><?php echo $gr['group_balance']; ?>
                                                <span class="fa fa-inr"></span>
                                            </td>
                                            <td align="center"><?php echo $gr['lane_limit']; ?></td>
                                            <td align="center"><?php echo $gr['member_limit']; ?></td>
                                            <td align="center">
                                                <div class="progress progress-xs">
                                                    <div class="progress-bar bg-primary w-60pc" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </td>
                                            
                                            <td align="center">
                                                <span>
                                                <?php echo form_open($addMembers); ?>
                          <input type="hidden" name="link" value="<?php echo $gr['link']; ?>">
                          <button type="submit" class="mb-2 btn btn-sm btn-danger mr-1">+</button>
                          </form>
                                                 
                                                    
                                                </span>
                                            </td>
                                            <td align="center">
                                                <span>
                                                    <a title="" data-placement="top" data-toggle="add" href="#" data-original-title="Add">
                                                        <i class="fa fa-plus color-muted m-r-5"></i>
                                                    </a>
                                                    
                                                </span>
                                            </td>
                                        </tr>
                                        
                                    </tbody>
                                    <?php $i=$i+1; }    
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                    
                </div>
            </div>
        
         
                        </div>
                    </div>
                </div>  