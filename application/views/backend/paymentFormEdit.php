
<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<style>
	td{
		vertical-align: middle !important;
	}
</style>
      <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-quote-right" aria-hidden="true"></i> Payment</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?=base_url('payment')?>">Payments</a></li>
                        <li class="breadcrumb-item active"> Edit payment</li>
                    </ol>
                </div>
            </div>
            <div class="message"></div>
            <div class="container-fluid">
               <div class="row mt-3">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"> Edit Payment<span class="pull-right " ></span></h4>
                            </div>
                            <?php echo validation_errors(); ?>
                               <?php echo $this->upload->display_errors(); ?>
                               
                               <?php echo $this->session->flashdata('formdata'); ?>
                               <?php echo $this->session->flashdata('feedback'); ?>
                            <div class="card-body">
								<form role="form" action="<?= $path ?>" method="post"
									enctype="multipart/form-data" id="noScript">

										<div class="row">
                                            <div class="col-12 mt-2 mb-3">
                                                <?php if($payment->invoice_id){?>
                                                    <input type="hidden" class="form-control" name="advance_payment" value="0" required>
                                                    <h4>
                                                        <small>Description: &nbsp;</small>Payment for invoice  #<?=$inv->inv_no?>
                                                    </h4>
                                                <?php } else {?>
                                                    <input type="hidden" class="form-control" name="advance_payment" value="1" required>
                                                    <h4>
                                                        <small>Description: &nbsp; </small>Advance payment.
                                                    </h4>
                                                <?php }?>
                                            </div>
											<div class="col-md-5">
												<div class="form-group">
													<label for="exampleInputPassword1"># Receipt No. <span class="req">*</span></label>
													<input type="text" class="form-control" name="receipt_no" value="<?=$payment->receipt_no?>"
														placeholder="Enter quotation no" required>
												</div>
											</div>
											<div class="col-md-5">
												<div class="form-group">
													<label for="exampleInputPassword1">Payment date <span class="req">*</span></label>
													<input type="text" class="form-control datepicker pl-3" value="<?=date('Y-m-d',strtotime($payment->payment_date))?>" name="payment_date" placeholder="Enter payment date" required>
												</div>
											</div>
											<div class="col-md-5">
												<div class="form-group">
													<label>Select client <span class="req">*</span></label>
													<select class="form-control bg-light" name="client_id" data-placeholder="Select a client" id="client_id" style="pointer-events:none" required readonly>
														<option value="">-- Select --</option>
														<?php foreach ($clients as $client): ?>
                                                            <?php if($payment->client_id==$client->id){ ?>
															    <option value="<?= $client->id; ?>" selected><?= $client->name.' ('.$client->person.')' ?></option>
                                                            <?php } else{ ?>
															    <option value="<?= $client->id; ?>"><?= $client->name.' ('.$client->person.')' ?></option>
                                                            <?php } ?>
														<?php endforeach; ?>
													</select>
												</div>
											</div>
											<div class="col-md-5">
												<div class="form-group">
													<label for="exampleInputPassword1">Payment amount (in Rs.)<span class="req">*</span></label>
													<input type="number" class="form-control" name="amount" value="<?=$payment->amount?>"
														placeholder="Enter amount" required>    
												</div>
											</div>
											<div class="col-md-5">
												<div class="form-group">
													<label for="exampleInputPassword1">Personal remarks</label>
													<textarea class="form-control" name="remarks" rows="5"><?=$payment->remarks?></textarea>
												</div>
											</div>
                                            <div class="col-md-6"></div>
                                            <div class="col box-footer mt-4">
                                                <button type="submit" class="btn btn-info mr-2">Update payment</button>
                                                <a  href="javascript:;" onclick="window.history.back()" class="btn btn-secondary">Cancel</a>
                                            </div>
								</form>
                            </div>
                        </div>
                    </div>
                </div>
<?php $this->load->view('backend/footer'); ?>

<script>

	$('#example1').DataTable();
	$('.select2').select2({
		theme: "bootstrap4"
	});
	$('.datepicker').datepicker({
		format: 'yyyy-mm-dd',
	});


	$('input[name="payment_type"]').change(function () {
		invoicesPopulate('0');
	});

	$('#client_id').change(function () {
		invoicesPopulate('0');
	});


	function invoicesPopulate(inv_id){
        if($('input[name="payment_type"]:checked').val()=='invoice_payment'){
            $('.invoice_selector').fadeIn();
            $('.invoice_selector input').attr('required','true');
            $.ajax({
                url : "<?=base_url()?>payment/getProformaByClient",
                type:'POST',
                data: {'cid': $('#client_id').find(":selected").val()},
                cache: false,
                dataType: 'json',
                before: function(){
                    console.log('before');
                },
                success: function(response) {
                    $("#invoice_selector_main option").remove();
					// console.log(response.main);
                    if(response.main){
                        $("#invoice_selector_main option").remove();
                        $.each(response.main,function(k, v){
							if(v.id==inv_id){
                           	 	$("#invoice_selector_main").append('<option value=' + v.id + ' selected> #' + v.inv_no +' (Due: ₹'+v.total_due+'/-)</option>');
							}
							else{
                            	$("#invoice_selector_main").append('<option value=' + v.id + '> #' + v.inv_no +' (Due: ₹'+v.total_due+'/-)</option>');
							}
                        });
                    }
                    else{
                        $("#invoice_selector_main option").remove();
                        $('#invoice_selector_main').append('<option value="none" disabled> No due invoice found for this client. Select "Advance Payment" option instead.</option>');
                    }
                    
                },
                error: function(){
                    console.log('error');
                }
            });
        }
        else{
            $('.invoice_selector').fadeOut();
            $('.invoice_selector input').removeAttr('required','false');
        }
	}

</script>
