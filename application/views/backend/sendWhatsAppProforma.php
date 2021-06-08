
<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
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
										<button id="print" class="btn btn-primary" type="button"><span><i class="fa fa-print"></i> Send message</span></button>
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
                                    
									</div>

                                    <form action="">
										<?php
											$msg='Hello  Mr. ABC, /\r?\n/g Here is your quotation with an estimated amount of Rs.15000/- for the below stated services. Please reply so we can take things forward with the project for Client Name.
											Following are the services with proposed pricing:
											
											Standard website
											(2 to 4 pages with Admin panel for uploading gallery images)
											Price: Rs.9000/-';
										?>
                                        <textarea name="" id="msg" cols="30" rows="10" class="form-control"><?=$msg?></textarea>
										<button type="button" class="btn btn-default" onclick="generateLink()">Generate Link</button>
										<a target="_blank" class="btn btn-success" id="whatsappLink" href="">Send msg</a>
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
	function generateLink() {
		msg = encodeURI($("#msg").val());
		console.log(msg)
		link= `https://wa.me/918871192502?text=${msg}`;
		$("#whatsappLink").attr("href", link);
	}
</script>
