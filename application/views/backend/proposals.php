<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
         <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-sticky-note"></i>  Proposals</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Proposals</li>
                    </ol>
                </div>
            </div>
            <div class="message"></div>
            <div class="container-fluid">
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header d-flex">
								<h4 class="m-b-0 text-white"><i class="mdi mdi-note-text"></i>  Proposal List</h4>
								<a href="<?php echo base_url(); ?>proposals/addProposal" class="text-white btn btn-sm btn-success ml-auto float-right"><i class="fa fa-plus"></i> Add Proposal</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive ">
                                    <table id="employees123" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>For client</th>
                                                <th>Descr.</th>
                                                <th>Proposed on</th>
                                                <th>Follow up on</th>
                                                <th>File</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <?php foreach($proposals as $c): ?>
                                            <tr>
                                                <td><?= $c->id ?></td>
                                                <td><?= $c->name ?> <br> (<?=$c->person?>)</td>
                                                <td class="min-width:200px">
                                                    <div class="readmore">
                                                        <?php if(strlen($c->descr)>100){?>
                                                            <?= nl2br(substr($c->descr,0,100))?>
                                                            <span class="ellipsis">...</span>
                                                            <span class="moreText"><?= nl2br(substr($c->descr,100))?></span> <br>
                                                            <a class="more" href="javascript:;">Show more +</a>
                                                        <?php } else{?>
                                                            <?= nl2br($c->descr)?>
                                                        <?php }?>
                                                    </div>
                                                </td>
                                                <td><?= date('d-m-Y',strtotime($c->created_at)) ?></td>
                                                <td><?= date('d-m-Y',strtotime($c->follow_up_date)) ?></td>
                                                <td><a href="<?=base_url('assets/proposals/').$c->file_src?>"><i class="fa fa-file"></i> <?=$c->file_src?></a></td>
                                                <td><?= $c->status ?></td>
                                                <td class="jsgrid-align-center nowrap">

													<a href="<?php echo base_url();?>proposals/editProposal/<?php echo $c->id?>" title="Edit" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-pencil-square-o"></i></a>

													<a onclick="return confirm('Are you sure to delete this data?')"  href="<?php echo base_url();?>proposals/deleteProposal/<?php echo $c->id;?>" title="Delete" class="btn btn-sm btn-danger waves-effect waves-light"><i class="fa fa-trash-o"></i></a>
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

    $(document).ready(function(){
		<?php if(isset($_GET['client'])){
			$cl=urldecode($_GET['client']) ?>
    		$('#employees123').DataTable().search('<?=$cl?>').draw();
		<?php }?>
	});
</script>
