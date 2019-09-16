




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
            <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-3">
                            <div class="card-body">
                                <h3 class="card-title text-white">Total Balance </h3>
                                <div class="d-inline-block">
                                <h2 class="text-white">                               
                                     <?php echo $tat; ?>    </h2>
                                </h2>
                             
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-desktop"></i></span>
                            </div>
                        </div>
                    </div>
                

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        
                            <div>
                                <h4>Amount</h4>
                                <section>
                                    <div class="row">
                                        <div class="col-lg-6">

                                        <?php echo form_open($StartPayment);?>
                                        <input type="text" class="form-control" type="submit" name="amountpay" placeholder="amount">
                                   <button class="btn btn-success">Pay</button>
                                    
                                                </form>

                                        

</div>
                                        </div>
                                       
                                

                            </div>
                    </div>
                </div>
            </div>