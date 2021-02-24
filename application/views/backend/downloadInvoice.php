<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Digikraft Social - Ankur">
    <link rel="icon" type="image/ico" sizes="16x16" href="<?php echo base_url(); ?>assets/images/favicon.png">
    <title>Invoice</title>
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url(); ?>assets/css/print.css" rel="stylesheet" media='print'>
	<style>
		.container-fluid{
			padding-left:15px !important;
			padding-right:10px !important;
		}
	</style>
</head>

<body class="card-no-border">
    <div id="main-wrapper">
            <div class="container-fluid">

				<div class="row mt-3">
					<div class="col-12">
						<div class="card ">
							<div class="card-header">
								<h4 class="m-b-0 text-white">
									<span class="" >
										<button id="print" onclick="printDiv('printableArea')" class="btn btn-primary" type="button"><span><i class="fa fa-print"></i> Print</span></button>
									</span>
								</h4>
							</div>
							<div class="card-body">
							<section class="invoice">
								<div id="printableArea">
									<style>
										h1,h2,h3,h4,h5,h6,.h6,th,td,span,div .col {
											color: #222;
										}
										button span{
											color:white;
										}
									</style>
									<div class="row bg-light p-3 align-items-center">
										<div class="col-sm-6">
											<h1 class="page-header font-weight-bold" style="border:0px;">INVOICE</h1>
											<?php if(isset($_GET['final'])) { ?>
											<span class=""><img src="<?=base_url('assets/images/paid.png')?>" alt="" height="30"></span>
											<?php } else { ?>
											<span class=""><img src="<?=base_url('assets/images/unpaid.png')?>" alt="" height="30"></span>
											<?php } ?>
										</div>
										<div class="col-sm-6">
											<div class="invoice-col d-flex justify-content-end" style="">
												<address class="mb-0 text-dark mr-5">
													<h5 class="text-muted">Billed by:</h5>
													<h5 class="text-uppercase"><?= $settings->company_name?></h5>
													<span class="d-block"><?= $settings->address.' '.$settings->address2; ?></span>
													<span class="d-block"><?= strlen($settings->contact)==10?'+91-'.$settings->contact:$settings->contact; ?></span>
													<span class="d-block"><?= $settings->system_email; ?></span>
												</address>
												<img src="<?= base_url("assets/images/$settings->sitelogo"); ?>" height="80px">
											</div>
										</div>
									</div>

									<div class="row mt-4">
										<div class="col-sm-7 pl-4">
											<h5 class="text-muted">Billed to:</h5>
											<address class="mb-0 mt-2 text-dark">
											
												<h5 class="text-uppercase"><?= $client->name?></h5>
												<span>Contact : <?= strlen($client->contact_no)==10?'+91-'.$client->contact_no:$client->contact_no; ?></span>
												<br>
												<span>E-mail : <?= $client->email; ?></span>
											</address>
										</div>
										<div class="col-sm-4 ml-4 pl-3">
											<h5 class="text-muted">Invoice details:</h5>
											<address class=" mt-2 text-dark">
												<?php if(isset($_GET['final'])) { ?>
													<div class="row">
														<div class="col-5">Invoice no.</div>
														<div class="col">: #<?= $invoice->inv_no; ?></div>
													</div>
												<?php } ?>
												<div class="row">
													<div class="col-5">Invoice date</div>
													<div class="col">: <?= date('d-m-Y', strtotime($invoice->inv_date)); ?></div>
												</div>
												<?php if(isset($_GET['final'])) { ?>
													<div class="row">
														<div class="col-5">Amount Paid</div>
														<div class="col">: <?= $settings->symbol; ?><?= $invoice->total_paid; ?>/-</div>
													</div>
												<?php } else { ?>
													<div class="row">
														<div class="col-5">Amount Paid</div>
														<div class="col-7">: <?= $settings->symbol; ?><?= $invoice->total_paid; ?>/-</div>
														<div class="col-5">Amount due</div>
														<div class="col-7">: <?= $settings->symbol; ?><?= $invoice->total_due; ?>/-</div>
														<div class="col-5">Due date</div>
														<div class="col-7">: <?= date('d-m-Y',strtotime($invoice->due_date)) ?></div>
													</div>
												<?php } ?>
											</address>
										</div>
									</div>

									<div class="row mt-5 px-3">
										<div class="col-xs-12 table-responsive">
											<table class="table table- table-full">
												<thead class="bg-light">
												<tr>
													<th>S. No.</th>
													<th>Service</th>
													<th>Price &nbsp; x &nbsp; Qty</th>
													<th width="100px" class="text-right">Subtotal</th>
												</tr>
												</thead>
												<tbody>
													<?php $z=1;foreach ($inv_items as $item):?>
														<tr>
															<td class="" style="width:100px"><?= $z?>.</td>
															<td class="">
																<h6><?= $item->cname; ?></h6>
																<?php if($item->descr!=''){?>
																	<?='- '.$item->name.'<br> <p class="pl-2 mb-0 w-50"> ('.$item->descr.')</p>';?>
																<?php } else{?>
																	<?='- '.$item->name.'<br>';?>
																<?php }?>
															</td>
															
															<td class=""><?=$settings->symbol.$item->price.'&emsp; x &emsp;'.$item->qty; ?></td>
															<td class="text-right"><?= $settings->symbol; ?><?= $item->price*$item->qty?>/-</td>
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
													<?php if(isset($_GET['final'])) { ?>
														<td colspan="2" class=" py-1 border-0">Total amount in words:</td>
														<th  class="text-right py-1">Total:</th>
														<td class="text-right py-1"><strong><?= $settings->symbol . ' '; ?><?= $invoice->total; ?>/-</strong></td>
													<?php } else { ?>
														<th colspan="3"  class="text-right py-1">Total:</th>
														<td class="text-right py-1"><strong><?= $settings->symbol . ' '; ?><?= $invoice->total; ?>/-</strong></td>
													<?php } ?>
												</tr>
												
												<?php if(isset($_GET['final'])) { ?>
													<tr>
														<th colspan="2" class=" py-1"><?=$amtWords?></th>
														<th class="text-right">Status:</th>
														<td class="text-right h6">PAID	</td>
													</tr>
												<?php } else { ?>
													<tr>
														<td colspan="2" class=" py-1 border-0">Total amount in words:</td>
														<th class="text-right py-1">Amount Paid:</th>
														<td class="text-right py-1"><?= $settings->symbol . ' '; ?><?= $invoice->total_paid; ?>/-</td>
													</tr>
													<tr class="">
														<th colspan="2" class=" py-1"><?=$amtWords?></th>
														<th class="text-right py-1">Amount Due:</th>
														<td class="text-right h6 py-1"><?= $settings->symbol . ' '; ?><?= $invoice->total_due; ?>/-</td>
													</tr>
												<?php } ?>
												</tbody>
											</table>
										</div>
									</div>
									<hr>

									<div class="row mt-4">
										<div class="col-sm-8 bankQr" style="display:flex;">
											<div class="" style="flex-basis:65%">
												<h6 class="">BANK DETAILS -</h6>
												<address class=" mt-2 text-dark">
													<div class="row">
														<div class="col-4">Bank</div>
														<div class="">: <?= $settings->bank_name; ?></div>
													</div>
													<div class="row">
														<div class="col-4 nowrap">Account name</div>
														<div class="">: <?= $settings->bank_acc_name; ?></div>
													</div>
													<div class="row">
														<div class="col-4">Account no.</div>
														<div class="">: <?= $settings->bank_acc_no; ?></div>
													</div>
													<div class="row">
														<div class="col-4">IFSC</div>
														<div class="">: <?= $settings->bank_ifsc; ?></div>
													</div>
													<div class="row">
														<div class="col-4">UPI ID</div>
														<div class="">: <?= $settings->bank_upi; ?></div>
													</div>
												</address>
											</div>
											<div class="qr">
												<h6 class="">UPI SCAN & PAY</h6>
												<img src="<?=base_url('assets/images/qr.png')?>" height="100" alt="">
											</div>
										</div>
										<?php if(isset($_GET['final'])) { ?>
											<div class="col-sm-4 ">
												<h6>Additional notes -</h6>
												<address class=" mt-2 text-dark">
													<div class="row">
														<div class="col">- Please quote invoice no. when remitting funds.</div>
													</div>
												</address>
											</div>
										<?php } else { ?>
											<div class="col-sm-4 ">
												<h6 class="">T&C -</h6>
												<address class=" mt-2 text-dark">
													<div class="row">
														<div class="col">- Please pay within 10 days upon receipt of the invoice.</div>
													</div>
												</address>
												<h6 class="mt-4">Additional notes -</h6>
												<address class=" mt-2 text-dark">
													<div class="row">
														<div class="col">- Please quote invoice no. when remitting funds.</div>
													</div>
												</address>
											</div>
										<?php } ?>
									</div>

									<div class="row mt-3">
										<h5 class="col">Thank you for your business.</h5>
									</div>
								</div>
								

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

            </div>

    </div>


</body>

</html>

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
