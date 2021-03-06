<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
      <div class="page-wrapper">
            <div class="message"></div>
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">Notice Board</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Notice Board</li>
                    </ol>
                </div>
            </div>
        <div class="container-fluid">
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header d-flex">
                                    <h4 class="m-b-0 text-white"> Notice</h4>
									<a data-toggle="modal" data-target="#noticemodel" data-whatever="@getbootstrap" class="text-white btn btn-success ml-auto btn-sm"><i class="fa fa-plus"></i> Add Notice </a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive ">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Sl</th>
                                                <th>Title</th>
                                                <th>File</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <?php foreach($notice as $value): ?>
                                            <tr>
                                                <td><?php echo $value->id; ?></td>
                                                <td><?php echo $value->title; ?></td>
                                                <td><a href="<?php echo base_url(); ?>assets/images/notice/<?php echo $value->file_url; ?>" target="_blank"><?php echo $value->file_url; ?></a></td>
                                                <td><?php echo $value->date; ?></td>
                                                <td>
													<a onclick="confirm('Are you sure want to delet this Value?')" href="<?=base_url('Notice/noticeDelete/').$value->id?>" title="Delete" <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> hidden <?php } ?> class="btn btn-sm btn-danger waves-effect waves-light"><i class="fa fa-trash-o"></i></a>
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
                        <!-- sample modal content -->
                        <div class="modal fade" id="noticemodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content ">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="exampleModalLabel1">Notice Board</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <form role="form" method="post" action="Published_Notice" id="btnSubmit" enctype="multipart/form-data">
                                    <div class="modal-body">
                                            <div class="form-group">
                                                <label for="message-text" class="control-label">Notice Title</label>
                                                <textarea class="form-control" name="title" id="message-text1" required minlength="25" maxlength="150"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Document</label>
                                                <label for="recipient-name1" class="control-label">Title</label>
                                                <input type="file" name="file_url" class="form-control" id="recipient-name1" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="message-text" class="control-label">Published Date</label>
                                                <input type="date" name="nodate" class="form-control" id="recipient-name1" required>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-info">Submit</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /.modal --> 
  
<?php $this->load->view('backend/footer'); ?>
