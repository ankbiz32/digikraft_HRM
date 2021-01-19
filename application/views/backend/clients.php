<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
         <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-briefcase" aria-hidden="true"></i> Clients</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Clients</li>
                    </ol>
                </div>
            </div>
            <div class="message"></div>
            <div class="container-fluid">
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header d-flex">
								<h4 class="m-b-0 text-white"><i class="fa fa-user-o" aria-hidden="true"></i> Client List</h4>
								<a href="<?php echo base_url(); ?>organization/addClient" class="text-white btn btn-sm btn-success ml-auto float-right"><i class="fa fa-plus"></i> Add New Client</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive ">
                                    <table id="employees123" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Organisation</th>
                                                <th>Person</th>
                                                <th>Contact</th>
                                                <th>GST no. </th>
                                                <th>Remarks </th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <?php foreach($clients as $c): ?>
                                            <tr>
                                                <td><?= wordwrap($c->name,30,"<br>\n") ?></td>
                                                <td><?= wordwrap($c->person,30,"<br>\n") ?></td>
                                                <td>
													<?= 
														'<i class="fa fa-phone fa-sm"></i> '.$c->contact_no.
														'<br> <i class="fa fa-envelope fa-sm"></i> '.$c->email.
														'<br> <i class="fa fa-map-marker "></i> '.$c->address
													?>
												</td>
                                                <td><?= $c->gst_no ?></td>
                                                <td><?= nl2br($c->remarks) ?></td>
                                                <td class="jsgrid-align-center ">
													<a href="<?php echo base_url();?>organization/editClient/<?php echo $c->id?>" title="Edit" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-pencil-square-o"></i></a>
													<a onclick="return confirm('Are you sure to delete this data?')"  href="<?php echo base_url();?>organization/deleteClient/<?php echo $c->id;?>" title="Delete" class="btn btn-sm btn-danger waves-effect waves-light"><i class="fa fa-trash-o"></i></a>
													<span class="dropdown d-inline-block">
														<a class="nav-link dropdown-toggle btn btn-sm btn-dark" data-toggle="dropdown" href="javascript:;" role="button" aria-haspopup="true" aria-expanded="false">See</a>
														<div class="dropdown-menu">
														<a class="dropdown-item" href='<?php echo base_url();?>proposals?client=<?php echo $c->name?>'>See Proposals</a>
														<a class="dropdown-item" href='<?php echo base_url();?>quotation?client=<?php echo $c->name?>'>See Quotations</a>
														<a class="dropdown-item" href='<?php echo base_url('summary/summary_serv/').$c->id?>'>See Summary</a>
														<a class="dropdown-item" href='<?php echo base_url();?>invoice?client=<?php echo $c->name?>'>See Invoices</a>
														</div>
													</span>
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
        "aaSorting": [[1,'asc']],
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
</script>
