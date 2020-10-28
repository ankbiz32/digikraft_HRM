<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
         <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-quote-right"></i>  Quotations</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Quotations</li>
                    </ol>
                </div>
            </div>
            <div class="message"></div>
            <div class="container-fluid">
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header d-flex">
								<h4 class="m-b-0 text-white"><i class="mdi mdi-note-text"></i>  Quotations list</h4>
								<a href="<?php echo base_url(); ?>invoice/addInvoice" class="text-white btn btn-sm btn-success ml-auto float-right"><i class="fa fa-plus"></i> Make new quotation</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive ">
                                    <table id="employees123" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Quotation no.</th>
                                                <th>Client</th>
                                                <th>Date</th>
                                                <th>Valid till</th>
                                                <th>Quote Amt.</th>
                                                <th>Remarks</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <?php foreach($quotations as $c): ?>
                                            <tr>
                                                <td><?= $c->inv_no ?></td>
                                                <td><?= date('d-m-Y',strtotime($c->inv_date)) ?></td>
                                                <!-- <td>₹ <?= $c->sub_total ?></td> -->
                                                <!-- <td> <?= $c->gst ?>%</td> -->
                                                <td>₹ <?= $c->total ?></td>
                                                <td>₹ <?= $c->total_paid ?></td>
                                                <td>₹ <?= $c->total_due ?></td>
                                                <td><?= $c->remarks?></td>
                                                <td class="jsgrid-align-center ">
													<a class="btn btn-success btn-edit mr-1 btn-sm" target="_blank"
													href="<?php echo base_url("invoice/showInvoice/$c->id"); ?>"><i class="fa fa-eye"></i></a>

													<a href="<?php echo base_url();?>invoice/editInvoice/<?php echo $c->id?>" title="Edit" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-pencil-square-o"></i></a>

													<a onclick="return confirm('Are you sure to delete this data?')"  href="<?php echo base_url();?>invoice/deleteInvoice/<?php echo $c->id;?>" title="Reject invoice" class="btn btn-sm btn-danger waves-effect waves-light"><i class="fa fa-ban"></i></a>
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
		sorting: false,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
</script>
