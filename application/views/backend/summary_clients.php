<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-list" aria-hidden="true"></i> Service summary</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"> Summary (Select clients)</li>
                    </ol>
                </div>
            </div>
            <div class="message"></div>
      		<?php echo $this->session->flashdata('message'); ?>
            <div class="container-fluid">
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header d-flex">
								<h4 class="m-b-0 text-white"><i class="fa fa-user-o" aria-hidden="true"></i> Client List &nbsp; <small>(Select any client to see its service summary)</small></h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive ">
                                    <table id="employees123" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Client</th>
                                                <th>Person Name</th>
                                                <th>Contact</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <?php foreach($clients as $c): ?>
                                            <tr>
                                                <td><?= $c->name ?></td>
                                                <td><?= $c->person ?></td>
                                                <td>
													<?= 
														'<i class="fa fa-phone fa-sm"></i> '.$c->contact_no.
														'<br> <i class="fa fa-envelope fa-sm"></i> '.$c->email.
														'<br> <i class="fa fa-map-marker "></i> '.$c->address
													?>
												</td>
                                                <td class="jsgrid-align-center ">
													<a href="<?php echo base_url();?>summary/summary_serv/<?php echo $c->id;?>" class="btn btn-sm btn-primary waves-effect waves-light"><i class="fa fa-eye"></i>&nbsp; See summary</a>
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
        "aaSorting": [[1,'asc']]
    });
</script>
