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
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                                <th>#</th>
                                <th>Name</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                            <?php $i=1; foreach($member_request_list as $req){?>
                                <tr>
                                    <td>
                                    <?php echo $i; ?>
                                    </td>
                                    <td>
                                    <?php $name=$this->Common_model->getAll("users",array('id'=>$req['from']))->row_array(); 
                                    echo $name['name'];
                                    ?>
                                    </td>
                                    <td>
                                        <?php echo form_open($accept); ?>
                                        <input type="hidden" name="link" value="<?php echo $req['link']; ?>">
                                        <button type="submit" class="mb-2 btn btn-sm btn-success mr-1">Accept</button>
                                        </form>
                                        <?php echo form_open($reject); ?>
                                        <input type="hidden" name="id" value="<?php echo $req['id']; ?>">
                                        <button type="submit" class="mb-2 btn btn-sm btn-danger mr-1">Reject</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                            





                    </div>
                </div>
            </div>
</div>