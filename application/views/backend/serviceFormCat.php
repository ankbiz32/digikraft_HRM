
<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
      <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-list" aria-hidden="true"></i> Category services</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?=base_url('organization/ServicesCat')?>">Category services</a></li>
                        <li class="breadcrumb-item active"> <?=isset($cat)?'Edit':'Add new'?> category</li>
                    </ol>
                </div>
            </div>
            <div class="message"></div>
            <div class="container-fluid">
               <div class="row mt-3">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"> <?=isset($cat)?'Edit':'Add new'?>  category<span class="pull-right " ></span></h4>
                            </div>
                            <?php echo validation_errors(); ?>
                               <?php echo $this->upload->display_errors(); ?>
                            <div class="card-body">

                                <form class="row" method="post" action="<?=$path?>" enctype="multipart/form-data">
                                    <div class="form-group col-md-8 m-t-20">
                                        <label>Name <span class="req">*</span></label>
                                        <input type="text" name="cname" value="<?=isset($cat)?$cat->cname:''?>" class="form-control form-control-line" placeholder="Category name" minlength="2" required > 
                                    </div>

                                    <div class="form-actions mt-2 col-md-12">
                                        <button type="submit" class="btn btn-info mr-1"> <i class="fa fa-check"></i> <?=isset($cat)?'Update':'Save'?></button>
                                        <a href="<?php echo base_url(); ?>organization/ServicesCat" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
<?php $this->load->view('backend/footer'); ?>
