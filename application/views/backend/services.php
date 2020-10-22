<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
         <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-list" aria-hidden="true"></i> Services</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Services</li>
                    </ol>
                </div>
            </div>
            <div class="message"></div>
            <div class="container-fluid">
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header d-flex">
								<h4 class="m-b-0 text-white"><i class="fa fa-user-o" aria-hidden="true"></i> Services List</h4>
								<a href="<?php echo base_url(); ?>organization/addService" class="text-white btn btn-sm btn-success ml-auto float-right"><i class="fa fa-plus"></i> Add New Service</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive ">
                                    <table id="employees123" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Service Name</th>
                                                <th>Price</th>
                                                <th>Short descr</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <?php foreach($services as $c): ?>
                                            <tr>
                                                <td><?= $c->name ?></td>
                                                <td>₹ <?= $c->price ?></td>
                                                <td><?= $c->short_descr ?></td>
                                                <td class="jsgrid-align-center ">
													<a href="<?php echo base_url();?>organization/editService/<?php echo $c->id?>" title="Edit" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-pencil-square-o"></i></a>
													<a onclick="return confirm('Are you sure to delete this data?')"  href="<?php echo base_url();?>organization/deleteService/<?php echo $c->id;?>" title="Delete" class="btn btn-sm btn-danger waves-effect waves-light"><i class="fa fa-trash-o"></i></a>
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
