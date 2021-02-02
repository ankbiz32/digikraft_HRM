
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
                    <h3 class="text-themecolor"><i class="fa fa-list" aria-hidden="true"></i> Payment receipt #<?=$rcpt->receipt_no?></h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?=base_url('payment')?>">Payments</a></li>
                        <li class="breadcrumb-item active">Receipt #<?=$rcpt->receipt_no?></li>
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
									<div class="row bg-light p-3">
										<div class="col-sm-8">
											<!-- <h2 class="page-header" style="border:0px;"> -->
												<div class="row align-items-center">
													<img src="<?= base_url("assets/images/$settings->sitelogo"); ?>" height="100px">
													<div class="invoice-col ml-4" style="">
														<address class="mb-0 text-dark">
															<h5 class="text-uppercase"><strong><?= $settings->company_name?></strong></h5>
															<span class="mb-1 d-block"><i class="fa fa-phone"></i>&nbsp; <?= strlen($settings->contact)==10?'+91-'.$settings->contact:$settings->contact; ?></span>
															<span class="mb-1 d-block"><i class="fa fa-envelope"></i>&nbsp; <?= $settings->system_email; ?></span>
															<span class="mb-1 d-block"><i class="fa fa-globe"></i>&nbsp; www.digikraftsocial.com</span>
														</address>
													</div>
												</div>

											<!-- </h2> -->
										</div>
										<div class="col-sm-4">
											<div class="invoice-col" style="">
												<address class="mb-0 text-dark">
													<h5 class="text-uppercase h4">PAYMENT RECEIPT</h5>
													<div class="row">
														<div class="col-4">Receipt no.</div>
														<div class="col">: #<?= $rcpt->receipt_no; ?></div>
													</div>
													<div class="row">
														<div class="col-4">Payment Date</div>
														<div class="col">: <?= date('d-m-Y', strtotime($rcpt->payment_date)); ?></div>
													</div>
												</address>
											</div>
										</div>
									</div>

									<div class="row mt-4">
										<div class="col-sm-4">
											<h6 class="">RECEIPT FOR -</h6>
											<address class="mb-0 mt-2 text-dark">
												<span><?= $client->name; ?></span>
												<br>
												<span>Contact : <?= strlen($client->contact_no)==10?'+91-'.$client->contact_no:$client->contact_no; ?></span>
												<br>
												<span>E-mail : <?= $client->email; ?></span>
											</address>
										</div>
										<div class="col-sm-8">
                                            <div class="row">
                                                <div class="col-xs-12 table-responsive">
                                                    <table class="table table- table-full">
                                                        <tbody>
                                                            <tr>
                                                                <td>Description</td>
                                                                <td width="190px" class="text-right">Payment Amount</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="">
                                                                    <h4><?= $rcpt->invoice_id?'Payment for invoice #'.$inv_no:'Advance payment'?></h4>
                                                                </td>
                                                                <td class="text-right">
                                                                    <h5><?= $settings->symbol . ' '; ?><?= $rcpt->amount?>/-</h5>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- /.col -->
                                            </div>
										</div>
										<!-- /.col -->
									</div>

									<div class="row mt-3">
											<h6 class="col h6 text-right">Thank you for your business.</h6>
										<!-- /.col -->
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
        document.title='Receipt #<?=$rcpt->receipt_no?>';
		window.print();

		document.body.innerHTML = originalContents;
	}
</script>
