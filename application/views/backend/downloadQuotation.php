

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Digikraft Social - Ankur">
    <link rel="icon" type="image/ico" sizes="16x16" href="<?php echo base_url(); ?>assets/images/favicon.png">
    <title>Quotation</title>
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
						<div class="card card-outline-none">
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
										<div class="col-sm-6">
											<h1 class="page-header font-weight-bold" style="border:0px;">QUOTATION</h1>
										</div>
										<div class="col-sm-6">
											<div class="invoice-col d-flex justify-content-end" style="">
												<address class="mb-0 text-dark mr-5">
													<h5 class="text-muted">Quotation by:</h5>
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
											<h5 class="text-muted">Quotation for:</h5>
											<address class="mb-0 mt-2 text-dark">
											
												<h5 class="text-uppercase"><?= $client->name?></h5>
												<span>Contact : <?= strlen($client->contact_no)==10?'+91-'.$client->contact_no:$client->contact_no; ?></span>
												<br>
												<span>E-mail : <?= $client->email; ?></span>
											</address>
										</div>
										<div class="col-sm-4 ml-3 pl-3">
											<h5 class="text-muted">Quotation details:</h5>
											<address class=" mt-2 text-dark">
													<div class="row">
														<div class="col-5">Reference no.</div>
														<div class="col">: #<?= $quotation->quote_no; ?></div>
													</div>
												<div class="row">
													<div class="col-5">Date</div>
													<div class="col">: <?= date('d-m-Y', strtotime($quotation->quote_date)); ?></div>
												</div>
												<div class="row">
													<div class="col-5">Valid till</div>
													<div class="col">: <?= date('d-m-Y', strtotime($quotation->valid_till)); ?></div>
												</div>
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
													<th>Price &nbsp; x &nbsp; Qty</th>
													<th width="100px" class="text-right">Subtotal</th>
												</tr>
												</thead>
												<tbody>
												<?php
												$z=1;
												foreach ($quotation_items as $item):
													?>
													<tr>
														<td class=""><?= $z?>.</td>
														<td class="">
															<h6><?= $item->name; ?></h6>
															<?= nl2br($item->descr) ?>
														</td>
														<td class=""><?=$settings->symbol.$item->price.'&emsp; x &emsp;'.$item->qty; ?></td>
														<td class="text-right"><?= $settings->symbol . ' '; ?><?php echo $item->price * $item->qty; ?>/-</td>
													</tr>
												<?php $z++; endforeach; ?>

												<!-- <tr>
													<th colspan="3" class="text-right">Subtotal:</th>
													<td class="text-right"><strong><?= $settings->symbol . ' '; ?><?= $quotation->sub_total; ?>/-</strong></td>
												</tr> -->
												<!-- <tr>
													<th colspan="3" class="text-right">GST (<?= $quotation->gst; ?>%)</th>
													<td class="text-right"><?= $settings->symbol . ' '; ?><?php echo $quotation->sub_total * (($quotation->gst) / 100); ?>/-</td>
												</tr> -->
												<?php if($quotation->discount!=0){?>
												<tr>
													<th colspan="3" class="text-right">Sub Total:</th>
													<td class="text-right"><strong><?= $settings->symbol . ' '; ?><?= $quotation->sub_total?>/-</strong></td>
												</tr>
												<tr>
													<th colspan="3" class="text-right">Discount:</th>
													<td class="text-right"><strong>- <?= $settings->symbol . ' '; ?><?= $quotation->discount?>/-</strong></td>
												</tr>
												<?php }?>
												<tr class="">
													<th colspan="3" class="text-right ">Estimated Amount:</th>
													<td class="text-right h6"><?= $settings->symbol . ' '; ?><?= $quotation->total?>/-</td>
												</tr>
												</tbody>
											</table>
										</div>
										<!-- /.col -->
									</div>
									<!-- /.row -->
									<hr>

									<div class="row mt-4">
										<div class="col-sm-6 ">
											<h6 class="">T&C -</h6>
											<address class=" mt-2 text-dark">
												<div class="row">
													<div class="col">
														- Cost estimate exclude applicable taxes.
														<br>
														- Any changes in above specifications require a written change order for work to be completed.
														<br>
														- Cost may increase due to additional, unexpected work.
													</div>
												</div>
											</address>
										</div>
										<div class="col-sm-1"></div>
										<div class="col-sm-5">
											<h6 class="text-right h6">Happy to serve you.</h6>
										</div>
                                        
                                        <style>
                                            .custom-footer {
                                                position: fixed;
                                                left: 0;
                                                bottom: 0;
                                                width: 100%;
                                                color: BLACK;
                                                text-align: center;
                                                background:transparent;
                                            }
                                        </style>
                                        <div class="custom-footer">
                                            <p class="mb-0">www.digikraftsocial.com</p>
                                        </div>
										<!-- /.col -->
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

    


<script>
	function printDiv(divName) {
		var printContents = document.getElementById(divName).innerHTML;
		var originalContents = document.body.innerHTML;

		document.body.innerHTML = printContents;

        document.title='Quotation #<?=$quotation->quote_no?>';
		window.print();

		document.body.innerHTML = originalContents;
	}
</script>


</body>

</html>


