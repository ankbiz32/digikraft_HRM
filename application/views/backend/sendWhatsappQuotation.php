<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor"><i class="fa fa-list" aria-hidden="true"></i> Quotation #<?= $quotation->quote_no ?></h3>
		</div>
		<div class="col-md-7 align-self-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
				<li class="breadcrumb-item"><a href="<?= base_url('quotation') ?>">Quotations</a></li>
				<li class="breadcrumb-item active">Quotation #<?= $quotation->quote_no ?></li>
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
							<span class="">
							</span>
							<a href="#" onclick="window.close();" class="float-right"><i class="fa fa-times"></i> close</a>
						</h4>
					</div>
					<div class="card-body">
						<section class="invoice">
							<div id="printableArea">
								<!-- title row -->
								<style>
									h1,
									h2,
									h3,
									h4,
									h5,
									h6,
									.h6,
									th,
									td,
									span,
									div .col {
										color: #222;
									}

									button span {
										color: white;
									}
								</style>

								<form action="">
									<?php
									$msg = "QUOTATION *" . $quotation->quote_no . "*\r\n";
									$msg .= "For *" . $client->name . "* (Mob - " . $client->contact_no . "), \r\n \r\n";
									$msg .= "Here is your quotation for the estimated amount of *Rs." . $quotation->total . "/-* for the below stated services.\r\n";
									$msg .= "Following are the services with respective pricing:\r\n \r\n";

									$z = 1;
									foreach ($quotation_items as $item) {
										$msg .= "--------------------------------\r\n";
										$msg .= "*" . $item->name . "*\r\n";
										$msg .= "".$item->descr ."\r\n\r\n";
										// if($item->descr!=''){
										// $msg.="".$item->name."\r\n";
										// $msg.="(".$item->descr.")\r\n";
										// } 
										// else{
										// 	$msg.="".$item->name."\r\n";
										// }
										$msg .= $settings->symbol . $item->price . ' x ' . $item->qty . " = " . $settings->symbol . $item->price * $item->qty . "\r\n";
									}
									$msg .= "\r\n=======================\r\n";
									$msg .= "*Estimated amount = Rs. " . $quotation->total . "/-*\r\n";
									$msg .= "=======================\r\n\r\n";
									$msg .= "Feel free to contact us for any queries.\r\n\r\n";
									$msg .= "*" . $settings->company_name . "*\r\n";
									$msg .= $settings->address . "\r\n" . $settings->address2 . "\r\n";
									$msg .= $settings->contact . "\r\n\r\n";
									$msg .= "_Note: This quotation is only for " . $client->name . " and is valid till ".date('d-m-Y', strtotime($quotation->valid_till))."_";

									?>
									<textarea name="" id="msg" cols="10" rows="20" class="form-control mb-3"><?= $msg ?></textarea>
									<button type="button" id="saveMsg" class="btn btn-success" onclick="sendUpdatedMsg()"><i class="fa fa-whatsapp"></i> Send updated whatsapp message</button>
									<button onclick="sendMsg()" type="button" class="btn btn-success" id="whatsappLinkDummy"><i class="fa fa-whatsapp"></i> Send whatsapp message</button>
									<a target="_blank" class="btn btn-success" id="whatsappLink" href="" hidden>Send message</a>
									<a href="#" onclick="window.close();" class="btn btn-default ml-3"><i class="fa fa-times"></i> cancel</a>
								</form>
								<hr>
							</div>

						</section>
					</div>
				</div>
			</div>
		</div>
		<?php $this->load->view('backend/footer'); ?>

		<script>
			$(function() {
				generateLink();
				$('#saveMsg').hide();
				$('#whatsappLink').hide();
				// sendMsg();
				$('#msg').bind('input propertychange', function() {
					$("#whatsappLinkDummy").hide();
					$('#saveMsg').show();
				});
			});

			function generateLink() {
				msg = encodeURIComponent($("#msg").val());
				link = `https://wa.me/91<?=$client->contact_no?>?text=${msg}`;
				$("#whatsappLink").attr("href", link);
				
			}
			function sendMsg(){
				document.getElementById('whatsappLink').click();
				window.top.close();
			}
			function sendUpdatedMsg(){
				generateLink();
				sendMsg();
			}
		</script>