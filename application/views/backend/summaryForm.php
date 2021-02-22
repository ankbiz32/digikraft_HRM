
<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
      <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-list" aria-hidden="true"></i> Add/Edit service to client</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?=base_url()?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?=base_url('summary')?>"> Summary (Select clients)</a></li>
                        <li class="breadcrumb-item"><a href="<?=base_url('summary/summary_serv/').$client->id?>"><?=$client->name.' ('.$client->person.')' ?></a></li>
                        <li class="breadcrumb-item active"> <?=isset($service)?'Edit':'Add '?> Service</li>
                    </ol>
                </div>
            </div>
            <div class="message"></div>
            <div class="container-fluid">
               <div class="row mt-3">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"> <?=isset($service)?'Edit':'Add new'?>  service<span class="pull-right " ></span></h4>
                            </div>
                            <?php echo validation_errors(); ?>
                               <?php echo $this->upload->display_errors(); ?>
                               
                               <?php echo $this->session->flashdata('formdata'); ?>
                               <?php echo $this->session->flashdata('feedback'); ?>
                            <div class="card-body">

                                <form class="row" method="post" action="<?=$path?>" enctype="multipart/form-data">
                                    <div class="form-group col-md-12 m-t-20">
                                        <label>Client Name: <strong><?=$client->name.' ('.$client->person.')' ?></strong></label>
                                        <!-- <select name="client_id" class="form-control disabled" disabled required>
											<option value="<?=$client->id?>"><?=$client->name?></option>
										</select> -->
                                    </div>

                                    <div class="form-group col-sm-4">
                                        <label>Service <span class="req">*</span></label>
                                        <select name="service_id" class="form-control select2" data-placeholder="Select a service" required>
											<option value="">-- Select a service --</option>
											<?php foreach($services as $s) {?>
												<option value="<?=$s->id?>" <?=isset($service)?($service->service_id==$s->id?' selected':''):''?>><?=$s->name?></option>
											<?php }?>
										</select>
                                    </div>

									<div class="form-group col-sm-4">
                                        <label>Qty <span class="req">*</span></label>
                                        <input type="text" name="qty" class="form-control digits" value="<?=isset($service)?$service->qty:'1'?>" required> 
                                    </div>
									
									<div class="col-md-4"></div>

									<div class="form-group col-md-4 m-t-20">
                                        <label for="">Date <span class="req">*</span></label>
                                        <input type="text" name="date" class="form-control" id="datepickerSumm" value="<?=isset($service)?date('d-m-Y',strtotime($service->date)):date('d-m-Y')?>" required>
                                    </div>
					
									<div class="form-group col-md-4 m-t-20">
                                        <label for="">Billed ? <span class="req">*</span></label>
										<select name="is_billed" id="" class="form-control">
											<option value="1" <?=isset($service)?($service->is_billed==1?' selected':''):''?>>BILLED</option>
											<option value="0" <?=isset($service)?($service->is_billed==0?' selected':''):' selected'?>>NOT BILLED</option>
										</select>
                                    </div>

									<div class="col-md-4"></div>
									<div class="form-group col-md-8 m-t-20">
                                        <label>Short description <small>(optional)</small> </label>
										<textarea name="descr" rows="3" class="form-control"><?=isset($service)?$service->descr:null?></textarea>
                                    </div>

                                    <div class="form-actions mt-2 col-md-12">
                                        <button type="submit" class="btn btn-info mr-1"> <i class="fa fa-check"></i> <?=isset($service)?'Update':'Save'?></button>
                                        <a href="<?=base_url('summary/summary_serv/').$client->id?>" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
<?php $this->load->view('backend/footer'); ?>
