
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
                        <li class="breadcrumb-item"><a href="<?=base_url('organization/Services')?>">Services</a></li>
                        <li class="breadcrumb-item active"> <?=isset($service)?'Edit':'Add new'?> Service</li>
                    </ol>
                </div>
            </div>
            <div class="message"></div>
            <div class="container-fluid">
               <div class="row mt-3">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"><i class="fa fa-user-o" aria-hidden="true"></i> <?=isset($service)?'Edit':'Add new'?>  service<span class="pull-right " ></span></h4>
                            </div>
                            <?php echo validation_errors(); ?>
                               <?php echo $this->upload->display_errors(); ?>
                               
                               <?php echo $this->session->flashdata('formdata'); ?>
                               <?php echo $this->session->flashdata('feedback'); ?>
                            <div class="card-body">

                                <form class="row" method="post" action="<?=$path?>" enctype="multipart/form-data">
                                    <div class="form-group col-md-8 m-t-20">
                                        <label>Name <span class="req">*</span></label>
                                        <input type="text" name="name" value="<?=isset($service)?$service->name:''?>" class="form-control form-control-line" placeholder="Service name" minlength="2" required > 
                                    </div>
									<div class="col-md-4"></div>
									<div class="form-group col-md-8 m-t-20">
                                        <label>Short description <small>(optional)</small> </label>
										<textarea name="short_descr" rows="6" class="form-control"><?=isset($service)?$service->short_descr:null?></textarea>
                                    </div>
									<div class="col-md-4"></div>
									<div class="form-group col-md-4 m-t-20">
                                        <label>Price  <span class="req">*</span></label>
                                        <input type="text" name="price" class="form-control digits" value="<?=isset($service)?$service->price:''?>" placeholder="Price for this service" required> 
                                    </div>
									<div class="form-group col-md-4 m-t-20">
                                        <label for="">Status</label>
										<select name="is_active" id="" class="form-control">
											<option value="1" <?=isset($service)?($service->is_active==1?' selected':''):''?>>ACTIVE</option>
											<option value="0" <?=isset($service)?($service->is_active==0?' selected':''):''?>>INACTIVE</option>
										</select>
                                    </div>

                                    <div class="form-actions mt-2 col-md-12">
                                        <button type="submit" class="btn btn-info mr-1"> <i class="fa fa-check"></i> <?=isset($service)?'Update':'Save'?></button>
                                        <a href="<?php echo base_url(); ?>organization/Services" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
<?php $this->load->view('backend/footer'); ?>
