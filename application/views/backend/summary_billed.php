<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-list" aria-hidden="true"></i> Service summary</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?=base_url()?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?=base_url('summary')?>"> Summary (Select clients)</a></li>
                        <li class="breadcrumb-item active"> Summary of services</li>
                    </ol>
                </div>
            </div>
            <div class="message"></div>
            <div class="container-fluid">
                <div class="row mt-3">
					<div class="col-sm-12 mt-3 mb-4">
						<a href="<?=base_url('summary/summary_serv/').$client->id?>" class="btn btn-default"><i class="fa fa-circle fa-sm text-warning" style="transform:scale(0.6)"></i> See un-billed services</a>
					</div>
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header d-flex align-items-center">
								<h4 class="m-b-0 text-white"><small><i class="fa fa-circle fa-sm text-success" style="transform:scale(0.6)"></i> Billed service summary for : <?=$client->name?></small></h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive ">
                                    <table id="employees123" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <!-- <th>Id</th> -->
                                                <th>Date</th>
                                                <th>Service Name</th>
                                                <th>Descr.</th>
                                                <th>Qty</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <?php foreach($summary as $s): ?>
                                            <tr>
                                                <!-- <td><?= $s->id ?></td> -->
                                                <td><?= date('d-m-Y',strtotime($s->date)) ?></td>
                                                <td><?= $s->service_name ?></td>
                                                <td><?= $s->descr ?></td>
                                                <td><?= $s->qty ?></td>
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
		aoColumnDefs: [
			{
				bSortable: false,
				aTargets: [ 0 ]
			}
		]
    });
	
	$(function () {
		// All select/deselect button
		$(document).on('click', '.allSelector', function() {
			if ($(this).is(':checked')) {
				$('.rowSelector').prop( "checked", true );
				getSelected();
			}
			else{
				$('.rowSelector').prop( "checked", false );
				getSelected();
			}
		});

		// Individual select/deselect button
		$(document).on('click', '.rowSelector', function() {
			getSelected();
		});

		function getSelected(){
			items= [];
			$("input:checkbox[class=rowSelector]:checked").each(function () {
				val= $(this).data("id");
				items.push(val);
			});
			if(items.length==0){
				$('.btn-bulk').hide();
			}
			else{
				$('.btn-bulk').show();
			}
		}
	});
</script>
