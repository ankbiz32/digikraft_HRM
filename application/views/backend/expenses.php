<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="mdi mdi-arrow-up-bold-circle-outline"></i>  Expenses</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Expenses</li>
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
								<h4 class="m-b-0 text-white">Expenses List</h4>
								<a href="<?php echo base_url(); ?>expenses/addExpense" class="text-white btn btn-sm btn-success ml-auto float-right"><i class="fa fa-plus"></i> Add Expense</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive ">
                                    <table id="employees123" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Descr.</th>
                                                <th>Amount</th>
                                                <th>File</th>
                                                <th>Entered by</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <?php foreach($expenses as $c): ?>
                                            <tr>
                                                <td><?= date('d-m-Y',strtotime($c->created_at)) ?></td>
                                                <td><?= $c->descr ?></td>
                                                <td>₹<?= $c->amount ?>/-</td>
                                                <td>
													<?php if($c->file_src){?>
													<a href="<?=base_url('assets/expenses/').$c->file_src?>"><i class="fa fa-file"></i> <?=$c->file_src?></a>
													<?php }?>
												</td>
                                                <td><?= $c->first_name.' '.$c->last_name ?></td>
                                                <td class="jsgrid-align-center ">

													<a href="<?php echo base_url();?>expenses/editExpense/<?php echo $c->id?>" title="Edit" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-pencil-square-o"></i></a>

													<a onclick="return confirm('Are you sure to delete this data?')"  href="<?php echo base_url();?>expenses/deleteExpense/<?php echo $c->id;?>" title="Delete" class="btn btn-sm btn-danger waves-effect waves-light"><i class="fa fa-trash-o"></i></a>
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
        "aaSorting": [],
		dom: 'Bflrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
</script>
