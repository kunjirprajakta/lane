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
                        
                            <div class="form-group">
                            	<?php echo form_open($addByEmail);?>
                                <input type="email" name="emailid" class="form-control" placeholder="Using Email" required/>
                                <input type="hidden" name="groupLink" value="<?php echo $groupLink['link']; ?>"/>

                                <button type="submit" class="btn mb-1 btn-rounded btn-secondary">Add Members</button></a>
                            </form>
            			</div>
            		</div>
            	</div>
            </div>
</div>