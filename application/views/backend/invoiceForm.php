
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
                    <h3 class="text-themecolor"><i class="fa fa-list" aria-hidden="true"></i> Invoice</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?=base_url('invoice')?>">Invoice</a></li>
                        <li class="breadcrumb-item active"> <?=isset($service)?'Edit':'Add new'?> Add invoice</li>
                    </ol>
                </div>
            </div>
            <div class="message"></div>
            <div class="container-fluid">
               <div class="row mt-3">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"> <?=$invoice!=''?'Edit':'Generate new'?> invoice<span class="pull-right " ></span></h4>
                            </div>
                            <?php echo validation_errors(); ?>
                               <?php echo $this->upload->display_errors(); ?>
                               
                               <?php echo $this->session->flashdata('formdata'); ?>
                               <?php echo $this->session->flashdata('feedback'); ?>
                            <div class="card-body">
								<form role="form" action="<?= $path ?>" method="post"
									enctype="multipart/form-data">

										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
													<label>Select Client <span class="req">*</span></label>
													<select class="form-control select2" name="client_id" data-placeholder="Select a client" required>
														<option value="">-- Select --</option>
														<?php foreach ($clients as $client): ?>
															<option value="<?= $client->id; ?>"><?= $client->name; ?></option>
														<?php endforeach; ?>
													</select>
													<small class="text-muted">Client not found? <a href="<?php echo base_url(); ?>organization/addClient">Add client</a></small>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label for="exampleInputPassword1"># Invoice No. <span class="req">*</span></label>
													<input type="text" class="form-control" name="invoice_no" value="<?= 'DS'.date('dmy').rand(01,99) ?>"
														placeholder="Enter Invoice No" required>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label for="exampleInputPassword1">Invoice date <span class="req">*</span></label>
													<input type="text" class="form-control datepicker pl-3" value="<?=date('Y-m-d')?>" name="date" placeholder="Enter Invoice Date" required>
												</div>
											</div>
										</div>

										<hr>

										<div class="row">
											<div class="col-md-12 mb-3 text-uppercase">
												Add items to invoice:
											</div>
											<div class="col-md-12 table-responsive">
												<table class="table table-bordered table-striped select-invoice">
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
													<tr>
														<td>
															<select class="select2 item form-control" name="item_id[]" id="item1" required>
																<option value="admin">--Select--</option>
																<?php foreach ($items as $item): ?>
																	<option
																		value="<?= $item->id; ?>"><?= $item->name; ?></option>
																<?php endforeach; ?>
															</select>
														</td>
														<td>
															<textarea type="text" class="form-control"
																	name="description[]"
																	id="description1"></textarea>
														</td>
														<td>
															<input type="text" class="price1 form-control" name="price[]"
																id="price1" required>
														</td>
														<td>
															<input type="text" class="calTotal form-control" name="qty[]"
																id="qty1" required>
														</td>
														<td>
															<label id="output1">0</label>
														</td>
													</tr>
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
														<td>₹ <input style="width: 80px" type="text" class="form-control" name="paid"
																id="paid" required></td>
													</tr>
													<tr class="text-right">
														<td colspan="4">Amt. Due :</td>
														<td>₹ <label id="totalDue">0.00</label></td>
													</tr>
												</table>
											</div>
										</div>

										<div class="box-footer mt-4">
											<button type="submit" class="btn btn-info mr-2">+ Generate Invoice</button>
											<a href="<?=base_url('invoice')?>" class="btn btn-secondary">Cancel</a>
										</div>
								</form>
                            </div>
                        </div>
                    </div>
                </div>
<?php $this->load->view('backend/footer'); ?>


<?php
	if ($invoice != '') {
		$invoice_items = $this->MInvoice->get_all_items_by_invoice($invoice->id);
		$i = 1;
		echo '<script>';
		$total_item = count($invoice_items);
		echo "var total_item = $total_item;";
		foreach ($invoice_items as $invoice_item):
			echo '
					$("#eitem' . $i . '").change(function() {
						var item = $(this).val();
						var base_url = location.protocol + \'//\' + location.host + \'/invoiceMaker/\';
						$.ajax({
						url: base_url + \'item/get_price_by_item\',
						type: "POST",
						data: {\'item\': item},
						cache: false,
						success: function (msg) {
							var data = $.parseJSON(msg);
							$(".eprice' . $i . '").val(data);
						},
						error: function () {
							alert(\'Error Occur...\');
						}
					});
					});
						
					$("#eqty' . $i . '").keyup(function () {
						var result = 0;
						$("#eqty' . $i . '").each(function () {
						result = parseFloat($(".eprice' . $i . '").val()) * parseFloat($(this).val());
						});
					$("#eoutput' . $i . '").text(result);
					});
				';
			if ($i != 1) {
				echo '
					$(".cal' . $i . '").change(function() {
						calculate_count();	   
					});
				';
			}
			$i++;
		endforeach;
		echo '
				$(".cal1").change(function() {
					calculate_count();	   
				});
				
				function calculate_count() {
					var total = 0;
					for(var i = 1; i <= total_item; i++) {
						total += (parseFloat($(\'.eprice\' + i + \'\').val()) * parseFloat($(\'#eqty\' + i + \'\').val()));
					}
					$(\'#sub\').text(total);
				}
		';
		echo '</script>';
	}
?>

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
					'<textarea type="text"  class="form-control"\n' +
					'name="description[]"\n' +
					'id="description' + count + '"></textarea>\n' +
				'</td>\n' +
				'<td>\n' +
					'<input type="text" class="price' + count + ' form-control" name="price[]"\n' +
					'id="price' + count + '" required>\n' +
				'</td>\n' +
				'<td>\n' +
					'<input type="text" class="calTotal' + count + ' form-control" name="qty[]"\n' +
					'id="qty' + count + '" required>\n' +
				'</td>\n' +
				'<td style="position:relative">\n' +
					'<label id="output' + count + '">0</label>\n' +
					'<button type="button" style="position:absolute;top:5px;right:5px" name="add" id="' + count + '"\n' +
					'class="btn btn-danger btn_remove btn-xs">X\n' +
					'</button>\n' +
				'</td>\n' +
			
				'</tr>'
			).insertBefore('#addertr');

			$('.select2').select2();

	
			$('#item' + count + '').change(function () {
				var item = $(this).val();
				var base_url = "<?=base_url()?>";
				$.ajax({
					url: base_url + 'invoice/serviceInfo',
					type: "POST",
					data: {'svc_id': item},
					cache: false,
					success: function (msg) {
						var data = JSON.parse(msg);
						$('#price'+count).val(data.price);
						$('#description'+count).val(data.short_descr);
					},
					error: function (e) {
						alert(e);
					}
				});
				
			});

			$('#qty' + count + '').keyup(function () {
				var result = 0;
				$('#qty' + count + '').each(function () {
					result = parseFloat($('.price' + count + '').val()) * parseFloat($(this).val());
				});
				$('#output' + count + '').text(result);
			});

			$('.calTotal' + count + '').change(function () {
				cal_count();
			});
		});

		$('#item1').change(function () {
			var item = $(this).val();
			var base_url = "<?=base_url()?>";
			$.ajax({
				url: base_url + 'invoice/serviceInfo',
				type: "POST",
				data: {'svc_id': item},
				cache: false,
				success: function (msg) {
					var data = JSON.parse(msg);
					$('#price1').val(data.price);
					$('#description1').val(data.short_descr);
				},
				error: function (e) {
					alert(e);
				}
			});
			
		});

		$('#qty1').keyup(function () {
			var result = 0;
			$('#qty1').each(function () {
				result = parseFloat($('.price1').val()) * parseFloat($(this).val());
			});
			$('#output1').text(result);
		});

		$('.calTotal').change(function () {
			cal_count();
		});

		$('#vat').keyup(function () {
			var sub_total = $('#subTotal').text();
			var vat = $('#vat').val();
			var price = parseFloat(sub_total) * (vat / 100);
			var amount = parseFloat(sub_total) + price;
			$('#totalAmount').text(amount);
		});

		$('#paid').keyup(function () {
			var total_amount = $('#totalAmount').text();
			var paid = $('#paid').val();
			var amount = parseFloat(total_amount) - parseFloat(paid);
			$('#totalDue').text(amount);
		});

		function cal_count() {
			var total_price = 0;
			for (var i = 1; i <= count; i++) {
				total_price += (parseFloat($('.price' + i + '').val()) * parseFloat($('#qty' + i + '').val()));
			}
			$('#subTotal').text(total_price);
			$('#totalAmount').text(total_price);
		}

		$('#evat').change(function () {
			var sub_total = $('#sub').text();
			var vat = $('#evat').val();
			var price = parseFloat(sub_total) * (vat / 100);
			var amount = parseFloat(sub_total) + price;
			$('#etotalAmount').text(amount);
		});

		$('#epaid').change(function () {
			var total_amount = $('#etotalAmount').text();
			var paid = $('#epaid').val();
			var amount = parseFloat(total_amount) - parseFloat(paid);
			$('#etotalDue').text(amount);
		});
	});

	$(document).on('click', '.btn_remove', function () {
		var button_id = $(this).attr("id");
		var price = parseFloat($('.price' + button_id + '').val()) * parseFloat($('#qty' + button_id + '').val());
		var final_amount = $('#subTotal').text();
		var result = parseFloat(final_amount) - price;
		$('#subTotal').text(result);
		$('#totalAmount').text(result);
		count--;
		$('.yTr' + button_id + '').remove();
	});
	

</script>
