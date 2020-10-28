
<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
      <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-sticky-note" aria-hidden="true"></i> Proposals</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?=base_url('proposals')?>">Proposals</a></li>
                        <li class="breadcrumb-item active"> <?=isset($proposal)?'Edit':'Add new'?> Proposal</li>
                    </ol>
                </div>
            </div>
            <div class="message"></div>
            <div class="container-fluid">
               <div class="row mt-3">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"> <?=isset($proposal)?'Edit':'Add new'?>  proposal<span class="pull-right " ></span></h4>
                            </div>
                            <?php echo validation_errors(); ?>
                               <?php echo $this->upload->display_errors(); ?>
                               
                               <?php echo $this->session->flashdata('formdata'); ?>
                               <?php echo $this->session->flashdata('feedback'); ?>
                            <div class="card-body">

                                <form class="row" method="post" action="<?=$path?>" enctype="multipart/form-data">
									<p class="col-md-12  mb-2 text-muted"> ENTER DETAILS OF PROPOSAL:</p>
                                    <div class="form-group col-md-6 m-t-20">
                                        <label>Client <span class="req">*</span></label>
										<select name="client_id" class="select2 form-control" data-placeholder="-- Select a client --" required>
											<option value="" ></option>
											<?php foreach($clients as $c){?>
												<option value="<?=$c->id?>" <?=isset($proposal)?($proposal->client_id==$c->id?' selected':''):''?>><?=$c->name?></option>
											<?php }?>
										</select>
                                    </div>
									<div class="form-group col-md-6 m-t-20">
											<label>Upload proposal file <?php if(!isset($proposal)){?><span class="req">*</span><?php }?> </label>
                                        <input type="file" name="file" class="form-control" <?=isset($proposal)?'':'required'?>> 
                                    </div>
									<div class="form-group col-md-6 m-t-20">
                                        <label>Follow up date  <span class="req">*</span></label>
                                        <input type="text" name="follow_up_date" class="form-control datepicker" value="<?=isset($proposal)?date('d-m-Y',strtotime($proposal->follow_up_date)):date('d-m-Y')?>" required>
                                    </div>
                                    <div class="form-group col-md-6 m-t-20">
                                        <label>Status <span class="req">*</span></label>
										<select name="status" class="form-control" required>
											<?php if(isset($proposal)){?>
												<option value="<?=$proposal->status?>" hidden><?=$proposal->status?></option>
											<?php }?>
											<option value="SENT" >SENT</option>
											<option value="REVISED_&_SENT" >REVISED & SENT</option>
											<option value="APPROVED" >APPROVED</option>
											<option value="REJECTED" >REJECTED</option>
										</select>
                                    </div>
									<div class="form-group col-md-6 m-t-20">
                                        <label>Short descr. <small>(optional)</small> </label>
										<textarea name="descr" maxlength="300" rows="4" class="form-control"><?=isset($proposal)?$proposal->descr:null?></textarea>
										<small>* Max. 300 characters</small>
                                    </div>
                                    <div class="form-actions mt-2 col-md-12">
                                        <button type="submit" class="btn btn-info mr-1"> <i class="fa fa-check"></i> <?=isset($proposal)?'Update':'Save'?></button>
                                        <a href="<?php echo base_url(); ?>proposals" class="btn btn-secondary">Cancel</a>
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
