
<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
      <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="mdi mdi-arrow-up-bold-circle-outline"></i> Expenses</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?=base_url('expenses')?>">Expenses</a></li>
                        <li class="breadcrumb-item active"> <?=isset($expense)?'Edit':'+ Add new'?> expense</li>
                    </ol>
                </div>
            </div>
            <div class="message"></div>
            <div class="container-fluid">
               <div class="row mt-3">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"> <?=isset($expense)?'Edit':'+ Add new'?>  expense<span class="pull-right " ></span></h4>
                            </div>
                            <?php echo validation_errors(); ?>
                               <?php echo $this->upload->display_errors(); ?>
                               
                               <?php echo $this->session->flashdata('formdata'); ?>
                            <div class="card-body">

                                <form class="row" method="post" action="<?=$path?>" id="noScript" enctype="multipart/form-data">
									<div class="form-group col-sm-3 m-t-20">
                                        <label>Amount (in Rs.) <span class="req">*</span></label>
                                        <input type="text" name="amount" class="form-control digits" value="<?=isset($expense)?$expense->amount:''?>" required>
                                    </div>
									<div class="form-group col-sm-3 m-t-20">
                                        <label>Date  <span class="req">*</span></label>
                                        <input type="text" name="created_at" class="form-control datepicker" value="<?=isset($expense)?date('d-m-Y',strtotime($expense->created_at)):date('d-m-Y')?>" required>
                                    </div>
									<div class="col-md-6">
									</div>
									<div class="form-group col-md-6 m-t-20">
                                        <label>Description <span class="req">*</span></label>
										<textarea name="descr" maxlength="300" rows="4" class="form-control" required><?=isset($expense)?$expense->descr:null?></textarea>
										<small class="text-muted pull-right">* Max. 300 characters</small>
                                    </div>
									<div class="col-md-6">
									</div>
									<div class="form-group col-md-6">
										<label>Upload file (optional) </label>
                                        <input type="file" name="file" class="form-control"> 
                                    </div>
									
									<?php if(isset($expense) && $expense->file_src){?>
									<div class="form-group col-md-12">
										<a target="_blank" href="<?=base_url()?>assets/expenses/<?=$expense->file_src?>"><img src="<?=base_url()?>assets/expenses/<?=$expense->file_src?>" alt="img" height="50"> </a>
										<br>
										<a class="text-danger small" href="<?=base_url('expenses/removeFile/').$expense->id?>"><strong>&times; </strong>Remove file</a>
                                    </div>
									<?php }?>
									
                                    <div class="form-actions mt-2 col-md-12">
                                        <button type="submit" class="btn btn-info mr-1"> <i class="fa fa-check"></i> <?=isset($expense)?'Update':'Save'?></button>
                                        <a href="<?php echo base_url(); ?>expenses" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
<?php $this->load->view('backend/footer'); ?>
<script>
$(".datepicker").datepicker({ 
        autoclose: true, 
        todayHighlight: true,
		format: 'dd-mm-yyyy',
  });
</script>
