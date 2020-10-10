<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
      <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-users" aria-hidden="true"></i> Employees</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?=base_url('employee')?>">Employees</a></li>
                        <li class="breadcrumb-item active">Add new employee</li>
                    </ol>
                </div>
            </div>
            <div class="message"></div>
    <?php $degvalue = $this->employee_model->getdesignation(); ?>
    <?php $depvalue = $this->employee_model->getdepartment(); ?>
            <div class="container-fluid">
               <div class="row mt-3">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"><i class="fa fa-user-o" aria-hidden="true"></i> Add New Employee<span class="pull-right " ></span></h4>
                            </div>
                            <?php echo validation_errors(); ?>
                               <?php echo $this->upload->display_errors(); ?>
                               
                               <?php echo $this->session->flashdata('formdata'); ?>
                               <?php echo $this->session->flashdata('feedback'); ?>
                            <div class="card-body">

                                <form class="row" method="post" action="Save" enctype="multipart/form-data">
									<p class="col-md-12  mb-2 text-muted">PERSONAL DETAILS :</p>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>First Name </label>
                                        <input type="text" name="fname" class="form-control form-control-line" placeholder="Your first name" minlength="2" required > 
                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Last Name </label>
                                        <input type="text" id="" name="lname" class="form-control form-control-line" value="" placeholder="Your last name" minlength="2" required> 
                                    </div>
									<div class="form-group col-md-3 m-t-20">
                                        <label>Gender </label>
                                        <select name="gender" class="form-control custom-select" required>
                                            <option value="" hidden>Select Gender</option>
                                            <option value="MALE">Male</option>
                                            <option value="FEMALE">Female</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Blood Group  <small>(optional)</small></label>
                                        <select name="blood" class="form-control custom-select">
                                            <option value="" hidden>Select one</option>
                                            <option value="O+">O+</option>
                                            <option value="O-">O-</option>
                                            <option value="A+">A+</option>
                                            <option value="A-">A-</option>
                                            <option value="B+">B+</option>
                                            <option value="B-">B-</option>
                                            <option value="AB+">AB+</option>
                                        </select>
                                    </div>
									<div class="form-group col-md-3 m-t-20">
                                        <label>Contact Number </label>
                                        <input type="text" name="contact" class="form-control" value="" placeholder="10 digit contact no." minlength="10" maxlength="10" required> 
                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Email </label>
                                        <input type="email" id="example-email2" name="email" class="form-control" placeholder="email@mail.com" minlength="7" required > 
                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label for="dateUI">Date Of Birth </label>
                                        <input type="text" name="dob" id="dateUI" name="example-email" class="form-control date mydatetimepickerFull" placeholder="Select date of birth" required>
                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Image  <small>(optional)</small></label>
                                        <input type="file" name="image_url" class="form-control" value=""> 
                                    </div>

									<p class="col-md-12 mt-3 mb-2 text-muted">OFFICE DETAILS :</p>

                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Employee Code <small>(optional)</small></label>
                                        <input type="text" name="eid" class="form-control form-control-line" placeholder="ID"> 
                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Department</label>
                                        <select name="dept" value="" class="form-control custom-select" required>
                                            <option value="" hidden>Select Department</option>
                                            <?Php foreach($depvalue as $value): ?>
                                             <option value="<?php echo $value->id ?>"><?php echo $value->dep_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Designation </label>
                                        <select name="deg" class="form-control custom-select" required>
                                            <option value="" hidden>Select Designation</option>
                                            <?Php foreach($degvalue as $value): ?>
                                            <option value="<?php echo $value->id ?>"><?php echo $value->des_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Role </label>
                                        <select name="role" class="form-control" required>
                                            <option value="" hidden>Select Roll</option>
                                            <option value="ADMIN">ADMIN</option>
                                            <option value="EMPLOYEE" selected>EMPLOYEE</option>
                                            <!-- <option value="SUPER ADMIN">Super Admin</option> -->
                                        </select>
                                    </div>
                                   
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Date Of Joining </label>
                                        <input type="text" name="joindate" id="example-email2" name="example-email" class="form-control mydatetimepickerFull" placeholder="" > 
                                    </div>

                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Date Of Leaving </label>
                                        <input type="text" name="leavedate" id="example-email2" name="example-email" class="form-control mydatetimepickerFull" placeholder=""> 
                                    </div>
									
                                    <!--<div class="form-group col-md-3 m-t-20">
                                        <label>Password </label>
                                        <input type="text" name="password" class="form-control" value="" placeholder="**********"> 
                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Confirm Password </label>
                                        <input type="text" name="confirm" class="form-control" value="" placeholder="**********"> 
                                    </div>-->
                                    <div class="form-actions mt-2 col-md-12">
                                        <button type="submit" class="btn btn-info mr-1"> <i class="fa fa-check"></i> Save</button>
                                        <a href="<?php echo base_url(); ?>employee/Employees" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
<?php $this->load->view('backend/footer'); ?>
