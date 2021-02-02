
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
                    <h3 class="text-themecolor"><i class="fa fa-list" aria-hidden="true"></i> Invoice #<?=$invoice->inv_no?></h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?=base_url('invoice')?>">Invoice</a></li>
                        <li class="breadcrumb-item active">Invoice #<?=$invoice->inv_no?></li>
                    </ol>
                </div>
            </div>
            <div class="message"></div>
            <div class="container-fluid">
				<div class="row mt-3">
					<div class="col-12">
						<div class="card card-outline-info">
							<div class="card-header">
								<h4 class="m-b-0 text-white">
									<span class="" >
										<button id="print" onclick="printDiv('printableArea')" class="btn btn-primary" type="button"><span><i class="fa fa-print"></i> Print</span></button>
									</span>
									<a href="#" onclick="window.close();" class="float-right"><i class="fa fa-times"></i> close</a>
								</h4>
							</div>
							<div class="card-body">
							<section class="invoice">
								<div id="printableArea">
									<!-- title row -->
									<style>
										h1,h2,h3,h4,h5,h6,.h6,th,td,span,div .col {
											color: #222;
										}
										button span{
											color:white;
										}
									</style>
									<div class="row bg-light p-3 align-items-center">
										<div class="col-sm-8">
											<h2 class="page-header" style="border:0px;">
												<img src="<?= base_url("assets/images/$settings->sitelogo"); ?>" height="80px">

											</h2>
										</div>
										<div class="col-sm-4">
											<div class="invoice-col" style="">
												<address class="mb-0 text-dark">
													<h5 class="text-uppercase"><strong><?= $settings->company_name?></strong></h5>
													<span class="mb-1 d-block"><i class="fa fa-phone"></i>&nbsp; <?= strlen($settings->contact)==10?'+91-'.$settings->contact:$settings->contact; ?></span>
													<span class="mb-1 d-block"><i class="fa fa-envelope"></i>&nbsp; <?= $settings->system_email; ?></span>
													<span class="mb-1 d-block"><i class="fa fa-globe"></i>&nbsp; www.digikraftsocial.com</span>
												</address>
											</div>
										</div>
									</div>

									<div class="row mt-4">
										<div class="col-sm-8">
											<h6 class="">INVOICE TO -</h6>
											<address class="mb-0 mt-2 text-dark">
												<span><?= $client->name; ?></span>
												<br>
												<span>Contact : <?= strlen($client->contact_no)==10?'+91-'.$client->contact_no:$client->contact_no; ?></span>
												<br>
												<span>E-mail : <?= $client->email; ?></span>
											</address>
										</div>
										<div class="col-sm-4 ">
											<h6 class="">INVOICE DETAILS -</h6>
											<address class=" mt-2 text-dark">
												<div class="row">
													<div class="col-4">Invoice no.</div>
													<div class="col">: #<?= $invoice->inv_no; ?></div>
												</div>
												<div class="row">
													<div class="col-4">Date</div>
													<div class="col">: <?= date('d-m-Y', strtotime($invoice->inv_date)); ?></div>
												</div>
												<?php if(isset($_GET['final'])) { ?>
													<div class="row">
														<div class="col-4">Amount Paid</div>
														<div class="col">: <?= $settings->symbol; ?><?= $invoice->total_paid; ?>/-</div>
													</div>
												<?php } else { ?>
													<div class="row">
														<div class="col-4">Amount due</div>
														<div class="col">: <?= $settings->symbol; ?><?= $invoice->total_due; ?>/-</div>
													</div>
												<?php } ?>
											</address>
										</div>
										<!-- /.col -->
									</div>

									<!-- Table row -->
									<div class="row mt-5 px-3">
										<div class="col-xs-12 table-responsive">
											<table class="table table- table-full">
												<thead class="bg-light">
												<tr>
													<th>S. No.</th>
													<th>Service</th>
													<th>Qty</th>
													<th width="100px" class="text-right">Subtotal</th>
												</tr>
												</thead>
												<tbody>
												<?php
												$z=1;
												foreach ($cat as $c):?>
													<tr>
														<td class=""><?= $z?>.</td>
														<td class="">
															<h6><?= $c->cname; ?></h6>
												<?php
													$st=0;
													$qty=0;
													foreach ($inv_items as $item):
														if($c->cname==$item->cname){
															$st+=$item->price * $item->qty;
															$qty+= $item->qty;
															echo '- '.$item->name.'<br>';
													 	} 
													endforeach;?>
													
													</td>
														<td class=""><?=$qty?></td>
														<td class="text-right"><?= $settings->symbol . ' '; ?><?= $st?>/-</td>
													</tr>
													<?php  $z++; endforeach; ?>

												<!-- <tr>
													<th colspan="3" class="text-right">Subtotal:</th>
													<td class="text-right"><strong><?= $settings->symbol . ' '; ?><?= $invoice->sub_total; ?>/-</strong></td>
												</tr> -->
												<!-- <tr>
													<th colspan="3" class="text-right">GST (<?= $invoice->gst; ?>%)</th>
													<td class="text-right"><?= $settings->symbol . ' '; ?><?php echo $invoice->sub_total * (($invoice->gst) / 100); ?>/-</td>
												</tr> -->
												<tr>
													<th colspan="3" class="text-right">Total:</th>
													<td class="text-right"><strong><?= $settings->symbol . ' '; ?><?= $invoice->total; ?>/-</strong></td>
												</tr>
												
												<?php if(isset($_GET['final'])) { ?>
													<tr>
														<th colspan="3" class="text-right">Status:</th>
														<td class="text-right h6">PAID	</td>
													</tr>
												<?php } else { ?>
													<tr>
														<th colspan="3" class="text-right">Amount Paid:</th>
														<td class="text-right"><?= $settings->symbol . ' '; ?><?= $invoice->total_paid; ?>/-</td>
													</tr>
													<tr class="">
														<th colspan="3" class="text-right ">Amount Due:</th>
														<td class="text-right h6"><?= $settings->symbol . ' '; ?><?= $invoice->total_due; ?>/-</td>
													</tr>
												<?php } ?>
												</tbody>
											</table>
										</div>
										<!-- /.col -->
									</div>
									<!-- /.row -->
									<hr>

									<div class="row mt-4">
										<div class="col-sm-8">
											<h6 class="">BANK DETAILS -</h6>
											<address class=" mt-2 text-dark">
												<div class="row">
													<div class="col-3">Bank</div>
													<div class="col">: <?= $settings->bank_name; ?></div>
												</div>
												<div class="row">
													<div class="col-3">Account name</div>
													<div class="col">: <?= $settings->bank_acc_name; ?></div>
												</div>
												<div class="row">
													<div class="col-3">Account no.</div>
													<div class="col">: <?= $settings->bank_acc_no; ?></div>
												</div>
												<div class="row">
													<div class="col-3">IFSC</div>
													<div class="col">: <?= $settings->bank_ifsc; ?></div>
												</div>
												<div class="row">
													<div class="col-3">UPI ID</div>
													<div class="col">: <?= $settings->bank_upi; ?></div>
												</div>
											</address>
										</div>
										<?php if(isset($_GET['final'])) { ?>
											<div class="col-sm-4 ">
												<h6 class=""></h6>
											</div>
										<?php } else { ?>
											<div class="col-sm-4 ">
												<h6 class="">T&C -</h6>
												<address class=" mt-2 text-dark">
													<div class="row">
														<div class="col">- Please pay your deposit upon receipt of the invoice.</div>
													</div>
												</address>
											</div>
										<?php } ?>
										<!-- /.col -->
									</div>

									<div class="row mt-3">
										<h5 class="col">Thank you for your business.</h5>
									</div>
								</div>
								

								<!-- this row will not appear when printing -->
								<div class="row mt-4 no-print">
									<div class="col ">
										<button id="print" onclick="printDiv('printableArea')" class="btn btn-primary" type="button"><span><i class="fa fa-print"></i> Print</span></button>
									</div>
								</div>
							</section>
							</div>
						</div>
					</div>
				</div>



<!-- Main content -->


<!-- /.content -->

<?php $this->load->view('backend/footer'); ?>

<script>
	function printDiv(divName) {
		var printContents = document.getElementById(divName).innerHTML;
		var originalContents = document.body.innerHTML;

		document.body.innerHTML = printContents;

        document.title='Invoice #<?=isset($_GET['final']) ? $invoice->inv_no." (PAID)": $invoice->inv_no." (DUE)"?>';

		window.print();

		document.body.innerHTML = originalContents;
	}
</script>
