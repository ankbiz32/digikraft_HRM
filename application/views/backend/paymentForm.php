
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
                        <li class="breadcrumb-item"><a href="<?=base_url('quotation')?>">Payments</a></li>
                        <li class="breadcrumb-item active"> Add new payment</li>
                    </ol>
                </div>
            </div>
            <div class="message"></div>
            <div class="container-fluid">
               <div class="row mt-3">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"> Add new Payment<span class="pull-right " ></span></h4>
                            </div>
                            <?php echo validation_errors(); ?>
                               <?php echo $this->upload->display_errors(); ?>
                               
                               <?php echo $this->session->flashdata('formdata'); ?>
                               <?php echo $this->session->flashdata('feedback'); ?>
                            <div class="card-body">
								<form role="form" action="<?= $path ?>" method="post"
									enctype="multipart/form-data" id="noScript">

										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label for="exampleInputPassword1"># Receipt No. <span class="req">*</span></label>
													<input type="text" class="form-control" name="receipt_no" value="<?= 'PDS'.date('dmy').rand(01,99) ?>"
														placeholder="Enter quotation no" required>
												</div>
											</div>
											<div class="col-md-5">
												<div class="form-group">
													<label for="exampleInputPassword1">Payment date <span class="req">*</span></label>
													<input type="text" class="form-control datepicker pl-3" value="<?=date('Y-m-d')?>" name="payment_date" placeholder="Enter payment date" required>
												</div>
											</div>
											<div class="col-md-5">
												<div class="form-group">
													<label>Select client <span class="req">*</span></label>
													<select class="form-control select2" name="client_id" data-placeholder="Select a client" id="client_id" required>
														<option value="">-- Select --</option>
														<?php foreach ($clients as $client): ?>
                                                            <?php if(isset($_GET['client']) && $_GET['client']==$client->id){ ?>
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
													<label for="exampleInputPassword1">Payment amount <span class="req">*</span></label>
													<input type="number" class="form-control" name="amount" value="0"
														placeholder="Enter amount" required>
												</div>
											</div>
											<div class="col-md-5">
												<div class="form-group">
													<label for="exampleInputPassword1">Personal remarks</label>
													<textarea class="form-control" name="remarks" rows="5"></textarea>
												</div>
											</div>
											<div class="col-md-7">
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<input type="radio" name="payment_type" id="invoice_payment" value="invoice_payment" required checked>
													<label for="invoice_payment">Add payment to invoice</label>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<input type="radio" name="payment_type" id="advance" value="advance" >
													<label for="advance">Advance Payment</label>
												</div>
											</div>
											<div class="col-md-5 invoice_selector">
												<div class="form-group">
													<label>Select invoice <span class="req">*</span></label>
													<select class="form-control select2" name="invoice_id" data-placeholder="Select an invoice" id="invoice_selector_main" required>
														<option value="">-- Select --</option>
													</select>
												</div>
											</div>
										</div>
										<div class="box-footer mt-4">
											<button type="submit" class="btn btn-info mr-2">+ Add Payment</button>
											<a href="<?=base_url('payment')?>" class="btn btn-secondary">Cancel</a>
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

	<?php  if(isset($_GET['client'])){ ?>
			invoicesPopulate('0');
	<?php }?>
	<?php  if(isset($_GET['invoice'])){ ?>
			invoicesPopulate("<?=$_GET['invoice']?>");
	<?php }?>

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
