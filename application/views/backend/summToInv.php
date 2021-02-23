
<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<style>
	td{
		vertical-align: middle !important;
	}
	textarea.description{
		font-size:12px !important;
		width:320px !important;
	}
</style>
      <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-list" aria-hidden="true"></i> Generate Invoice</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:history.back()">Summary</a></li>
                        <li class="breadcrumb-item active"> Save invoice</li>
                    </ol>
                </div>
            </div>
            <div class="message"></div>
      		<?php echo $this->session->flashdata('message'); ?>
            <div class="message2"></div>
            <div class="container-fluid">
               <div class="row mt-3">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"> 
									Generate invoice
									<a class="float-right" href="javascript:history.back()"><i class="fa fa-times"></i> cancel</a>
								</h4>
                            </div>
                            <?php echo validation_errors(); ?>
                               <?php echo $this->upload->display_errors(); ?>
                               
                               <?php echo $this->session->flashdata('formdata'); ?>
                               <?php echo $this->session->flashdata('feedback'); ?>
                            <div class="card-body">
								<form role="form" action="<?= $path ?>" method="post"
									enctype="multipart/form-data" id="noScript">

										<div class="row">
											<div class="col-md-12 d-none">
												<div class="form-group">
													<input type="text" name="ids" value="<?=implode(',', $ids)?>" class="form-control col-sm-6">
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label>Select Client <span class="req">*</span></label>
													<select class="form-control bg-light" name="client_id" id="client_id" data-placeholder="Select a client" style="pointer-events:none" readonly required >
														<option value="">-- Select --</option>
														<?php foreach ($clients as $client): ?>
															<option data-bal="<?=$client->balance?>" value="<?= $client->id; ?>" <?=$cid==$client->id?' selected':''?> ><?= $client->name.' ('.$client->person.')'  ?></option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="exampleInputPassword1"># Invoice No. <span class="req">*</span></label>
													<input type="text" class="form-control" name="invoice_no" value="<?= 'DS'.date('dmy').rand(01,99) ?>"
														placeholder="Enter Invoice No" required>
												</div>
											</div>
											<div class="col-md-1"></div>
											<div class="col-md-2">
												<div class="form-group">
													<label for="exampleInputPassword1">Invoice date <span class="req">*</span></label>
													<input type="text" class="form-control datepicker pl-3" value="<?=date('Y-m-d')?>" name="date" placeholder="Enter Invoice Date" required>
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group">
													<label for="exampleInputPassword1">Due date <span class="req">*</span></label>
													<input type="text" class="form-control datepicker pl-3" value="<?=Date('Y-m-d', strtotime('+10 days'))?>" name="due_date" placeholder="Enter Invoice due Date" required>
												</div>
											</div>
										</div>

										<hr>

										<div class="row">
											<div class="col-md-12 mb-3 text-uppercase">
												Add Services to invoice:
											</div>
											<div class="col-md-12 table-responsive">
												<table class="table table-bordered select-invoice">
													<thead>
													<tr class="">
														<th>Service</th>
														<th>Description</th>
														<th>Price</th>
														<th>Qty</th>
														<th>Total</th>
													</tr>
													</thead>
													<tbody id="tBody">
													<?php foreach($inv_items as $itm){?>
														<tr>
															<td>
																<select class="select2 item form-control" name="item_id[]" required>
																	<option value="admin">--Select--</option>
																	<?php foreach ($items as $item): ?>
																		<option value="<?= $item->id; ?>" <?=$itm->service_id==$item->id?' selected':''?>><?= $item->name; ?></option>
																	<?php endforeach; ?>
																</select>
															</td>
															<td>
																<textarea type="text" class="form-control description"
																		name="description[]"><?=$itm->descr?></textarea>
															</td>
															<td>
																<input type="text" class="price1 price form-control digits" name="price[]"
																	 value="<?=$itm->price?>" required>
															</td>
															<td>
																<input type="text" class="calTotal qty form-control" name="qty[]"
																	 value="<?=$itm->qty?>" required>
															</td>
															<td>
																<label id="output1" class="rowTotal"><?=$itm->price * $itm->qty?></label>
															</td>
														</tr>
													<?php }?>
													<tr id="addertr" class="bg-white">
														<td colspan=5 class="text-right">
															<button type="button" name="add" id="add" class="btn btn-success btn-custom-invoice float-right btn-sm"><i class="fa fa-plus"></i> 
																Add more item
															</button>
														</td>
													</tr>
													</tbody>
													
												</table>
											</div>
										</div>

										<div class="row mt-2">
											<div class="col-md-6">
												<label>Personal remarks:</label>
												<textarea class="form-control" name="remarks" rows="8" placeholder="This will not be shown in the final invoice print. Use this for personal remarks about the invoice."></textarea>
											</div>
											<div class="col-md-6 text-right" >
												<table class="table ">
													<tr class="text-right" style="display:none">
														<td colspan="4">Subtotal :</td>
														<td>₹ <label id="subTotal">0.00</label></td>
													</tr>
													<tr class="text-right" style="display:none">
														<td colspan="4">GST (%) :</td>
														<td><input style="width: 80px" type="text" class="form-control" name="vat"
																id="vat" value="0">
														</td>
													</tr>
													<tr class="text-right">
														<td colspan="4">Total:</td>
														<td>₹ <label id="totalAmount">0.00</label></td>
													</tr>
													<tr class="text-right">
														<td colspan="4">Amt. Paid :</td>
														<td>
															<input type="checkbox" class="form-control" name="paid_in_advance" id="paid_in_advance">
															<label for="paid_in_advance">
																Paid in advance
															</label>
															<span id="paid_input" style="display:none">
																₹ <input style="width: 120px" type="number" class="form-control" value="0" name="paid"
																	id="paid" required>
															</span>
														</td>
													</tr>
													<tr class="text-right">
														<td colspan="4">Amt. Due :</td>
														<td>₹ <label id="totalDue">0.00</label></td>
													</tr>
												</table>
											</div>
										</div>

										<div class="box-footer mt-4">
											<button type="submit" class="btn btn-info mr-2">Save Invoice</button>
											<a href="javascript:history.back()" class="btn btn-secondary">Cancel</a>
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

	var count = 1;

	$(document).ready(function () {
		
		max=$("#client_id").find(':selected').data('bal');
		$("#paid_input input").attr('max',max);

		$('#add').click(function () {
			count++;

			$(
				'<tr class="yTr' + count + '">\n' +	
				'<td>\n' +
					'<select class="select2 item form-control" name="item_id[]" id="item' + count + '" required>\n' +
					'<option value="admin">--Select--</option>\n' +
					'<?php foreach ($items as $item): ?>\n' +
					'<option\n' +
					'value="<?= $item->id; ?>"><?= $item->name; ?></option>\n' +
					'<?php endforeach; ?>\n' +
					'</select>\n' +
				'</td>\n' +
				'<td>\n' +
					'<textarea type="text"  class="form-control description"\n' +
					'name="description[]"\n' +
					'id="description' + count + '"></textarea>\n' +
				'</td>\n' +
				'<td>\n' +
					'<input type="text" class="price' + count + ' form-control price" name="price[]"\n' +
					'id="price' + count + '" required>\n' +
				'</td>\n' +
				'<td>\n' +
					'<input type="text" class="calTotal' + count + ' form-control qty" name="qty[]"\n' +
					'id="qty' + count + '" value="1" required>\n' +
				'</td>\n' +
				'<td style="position:relative">\n' +
					'<label id="output' + count + '" class="rowTotal">0</label>\n' +
					'<button type="button" style="position:absolute;top:5px;right:5px" name="add" id="' + count + '"\n' +
					'class="btn btn-danger btn_remove btn-xs">X\n' +
					'</button>\n' +
				'</td>\n' +
			
				'</tr>'
			).insertBefore('#addertr');

			$('.select2').select2();

	
			$('.item').change(function () {
				var y = $(this);
				var item = $(this).val();
				var base_url = "<?=base_url()?>";
				$.ajax({
					url: base_url + 'invoice/serviceInfo',
					type: "POST",
					data: {'svc_id': item},
					cache: false,
					success: function (msg) {
						var data = JSON.parse(msg);
						y.parent().siblings().find(".description").val(data.short_descr);
						y.parent().siblings().find(".price").val(data.price);
						calAll();
					},
					error: function (e) {
						alert(e);
					}
				});
				
			});
		});	

		$("#paid_in_advance").change(function() {
			if(this.checked) {
				$("#paid_input").show();
				$("#paid_input").css('margin-left','30px');
				$("#paid_input input").val(parseInt($('#totalAmount').text()));
				calAll();
			}
			else{
				$("#paid_input").hide();
				$("#paid_input").css('margin-left','0px');
				$("#paid_input input").val(0);
				calAll();
			}
		});

		calAll();
	});

	
	$(document).on('change keyup click', 'body', function () {
		calAll();
		// console.log($('#subTotal').text());
	});

	$(document).on('click', '.btn_remove', function () {
		var button_id = $(this).attr("id");
		count--;
		$('.yTr' + button_id + '').remove();
		calAll();
	});

	
	$('.item').change(function () {
		var y = $(this);
		var item = $(this).val();
		var base_url = "<?=base_url()?>";
		$.ajax({
			url: base_url + 'invoice/serviceInfo',
			type: "POST",
			data: {'svc_id': item},
			cache: false,
			success: function (msg) {
				var data = JSON.parse(msg);
				y.parent().siblings().find(".description").val(data.short_descr);
				y.parent().siblings().find(".price").val(data.price);
				calAll();
			},
			error: function (e) {
				alert(e);
			}
		});
		
	});

	function calAll(){
		var stotal=0;
		var tot=0;
		var paid = $("#paid").val();
		var gst = $("#vat");
		var qtys = $(".qty");
		var prices = $(".price");
		var rowTotal = $(".rowTotal");
		for(var i = 0; i < qtys.length; i++){
			rt=$(qtys[i]).val() * $(prices[i]).val();
			$(rowTotal[i]).text(rt);
			stotal+=parseFloat(rt);
		}
		$('#totalAmount').text(stotal);
		$('#totalDue').text(stotal - paid);
	} 
	

</script>
