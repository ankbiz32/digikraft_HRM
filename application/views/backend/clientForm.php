
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
                        <li class="breadcrumb-item"><a href="<?=base_url('organization/Clients')?>">Clients</a></li>
                        <li class="breadcrumb-item active"> <?=isset($client)?'Edit':'Add new'?> client</li>
                    </ol>
                </div>
            </div>
            <div class="message"></div>
            <div class="container-fluid">
               <div class="row mt-3">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"><i class="fa fa-user-o" aria-hidden="true"></i> <?=isset($client)?'Edit':'Add new'?>  client<span class="pull-right " ></span></h4>
                            </div>
                            <?php echo validation_errors(); ?>
                               <?php echo $this->upload->display_errors(); ?>
                               
                               <?php echo $this->session->flashdata('formdata'); ?>
                               <?php echo $this->session->flashdata('feedback'); ?>
                            <div class="card-body">

                                <form class="row" method="post" action="<?=$path?>" enctype="multipart/form-data">
									<p class="col-md-12  mb-2 text-muted"> DETAILS :</p>
                                    <div class="form-group col-md-4 m-t-20">
                                        <label>Name <span class="req">*</span></label>
                                        <input type="text" name="name" value="<?=isset($client)?$client->name:''?>" class="form-control form-control-line" placeholder="Client name" minlength="2" required > 
                                    </div>
									<div class="form-group col-md-4 m-t-20">
                                        <label>Contact Number  <span class="req">*</span></label>
                                        <input type="text" name="contact_no" class="form-control digits" value="<?=isset($client)?$client->contact_no:''?>" placeholder="10 digit contact no." minlength="10" maxlength="10" required> 
                                    </div>
									<div class="col-md-4"></div>
                                    <div class="form-group col-md-4 m-t-20">
                                        <label>Email <small>(optional)</small></label>
                                        <input type="email" id="example-email2" value="<?=isset($client)?$client->email:''?>" name="email" class="form-control email" placeholder="email@mail.com" minlength="5"> 
                                    </div>
									<div class="form-group col-md-4 m-t-20">
                                        <label>GST Number <small>(optional)</small> </label>
                                        <input type="text" name="gst_no" class="form-control" value="<?=isset($client)?$client->gst_no:''?>" placeholder="15 digit GST no." minlength="15" maxlength="15"> 
                                    </div>
									<div class="col-md-4"></div>
									<div class="form-group col-md-4 m-t-20">
                                        <label>Address <small>(optional)</small> </label>
										<textarea name="address" rows="4" class="form-control"><?=isset($client)?$client->address:null?></textarea>
                                    </div>
									<div class="form-group col-md-4 m-t-20">
                                        <label>Remarks <small>(optional)</small> </label>
										<textarea name="remarks" maxlength="300" rows="4" class="form-control"><?=isset($client)?$client->remarks:null?></textarea>
										<small>* Max. 300 characters</small>
                                    </div>

                                    <div class="form-actions mt-2 col-md-12">
                                        <button type="submit" class="btn btn-info mr-1"> <i class="fa fa-check"></i> <?=isset($client)?'Update':'Save'?></button>
                                        <a href="<?php echo base_url(); ?>organization/Clients" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
<?php $this->load->view('backend/footer'); ?>
