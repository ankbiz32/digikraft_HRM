<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
         <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="mdi mdi-note-text"></i>  Proforma</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Proforma</li>
                    </ol>
                </div>
            </div>
            <?php if($this->session->flashdata('feedback')){?>
                <div class="message d-block"><?=$this->session->flashdata('feedback')?> </div>
            <?php }?>
            <?php if($this->session->flashdata('error')){?>
                <div class="message d-block bg-danger"><?=$this->session->flashdata('error')?>  </div>
            <?php }?>
            <div class="container-fluid">
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header d-flex">
								<h4 class="m-b-0 text-white"><i class="mdi mdi-note-text"></i>  Proforma List</h4>
								<a href="<?php echo base_url(); ?>invoice/addInvoice" class="text-white btn btn-sm btn-success ml-auto float-right"><i class="fa fa-plus"></i> Generate Proforma</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive ">
                                    <table id="employees123" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Proforma Invoice no.</th>
                                                <th>Client</th>
                                                <th>Date</th>
                                                <!-- <th>Sub total</th> -->
                                                <!-- <th>GST</th> -->
                                                <th>Total</th>
                                                <th>Paid</th>
                                                <th>Due Amt.</th>
                                                <th>Due date</th>
                                                <th>Remarks</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <?php foreach($invoices as $c): ?>
                                            <tr>
                                                <td><?= $c->inv_no ?></td>
                                                <td><?= $c->name ?> <br> (<?=$c->person?>)</td>
                                                <td class="nowrap"><?= date('d-m-Y',strtotime($c->inv_date)) ?></td>
                                                <!-- <td>₹ <?= $c->sub_total ?></td> -->
                                                <!-- <td> <?= $c->gst ?>%</td> -->
                                                <td class="nowrap">₹ <?= $c->total ?></td>
                                                <td class="nowrap">₹ <?= $c->total_paid ?></td>
                                                <td class="nowrap">₹ <?= $c->total_due ?></td>
                                                <td class="nowrap"><?= date('d-m-Y',strtotime($c->due_date)) ?></td>
                                                <td style="min-width:200px">
                                                    <div class="readmore">
                                                    <?php if(strlen($c->remarks)>100){?>
                                                        <?= nl2br(substr($c->remarks,0,100))?>
                                                        <span class="ellipsis">...</span>
                                                        <span class="moreText"><?= nl2br(substr($c->remarks,100))?></span> <br>
                                                        <a class="more"  href="javascript:;">Show more +</a>
                                                    <?php } else{?>
                                                        <?= nl2br($c->remarks)?>
                                                    <?php }?>
                                                    </div>
                                                </td>
                                                <td class="jsgrid-align-center nowrap">
													<a href="<?=base_url('payment/addPayment?client=').$c->client_id.'&invoice='.$c->id?>" title="Add payment" class="btn btn-sm btn-warning waves-effect waves-light"><i class="fa fa-money"></i></a>
													
                                                    <a class="btn btn-success btn-edit mr-1 btn-sm" target="_blank"
													href="<?php echo base_url("invoice/showInvoice/$c->id"); ?>"><i class="fa fa-eye"></i></a>

													<a href="<?php echo base_url();?>invoice/editInvoice/<?php echo $c->id?>" title="Edit" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-pencil-square-o"></i></a>

													<a onclick="return confirm('Are you sure to delete this data?')"  href="<?php echo base_url();?>invoice/deleteInvoice/<?php echo $c->id;?>" title="Reject invoice" class="btn btn-sm btn-danger waves-effect waves-light"><i class="fa fa-ban"></i></a>

                                                    <a  href="<?php echo base_url();?>invoice/sendInvoice/<?php echo $c->id;?>/proforma" title="Send unpaid invoice by mail" class="btn btn-sm btn-primary waves-effect waves-light"><i class="fa fa-envelope"></i></a>

                                                    <a target="_blank" href="<?php echo base_url("invoice/sendWhatsAppProforma/$c->id"); ?>" title="Send invoice by whatsapp" style="background:#41BF52" class="btn btn-sm btn-dark waves-effect waves-light"><i class="fa fa-whatsapp"></i></a>
                                                    

                                                    <?php if($c->ref_quotation_id){?>
                                                        <br>
                                                        <small><a target="_blank" class="btn btn-default btn-sm mt-2" href="<?= base_url("quotation/showQuotation/$c->ref_quotation_id")?>">See ref. quotation</a></small>
                                                    <?php }?>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<?php $this->load->view('backend/footer'); ?>
<script>
    $('#employees123').DataTable({
        "order": [],
		// sorting: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
	$(document).ready(function(){
		<?php if(isset($_GET['client'])){
			$cl=urldecode($_GET['client']) ?>
    		$('#employees123').DataTable().search('<?=$cl?>').draw();
		<?php }?>
	});
</script>
