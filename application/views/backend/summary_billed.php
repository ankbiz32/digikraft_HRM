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
      		<?php echo $this->session->flashdata('message'); ?>
            <div class="container-fluid">
                <div class="row mt-3">
					<div class="col-sm-12 mt-3 mb-4">
						<a href="<?=base_url('summary/summary_serv/').$client->id?>" class="btn btn-default"><i class="fa fa-circle fa-sm text-warning" style="transform:scale(0.6)"></i> See un-billed services</a>
						<div class="pull-right">
							<form action="<?=base_url('summary/dateFilterBilled/').$client->id?>" id="noScript" method="POST" class="d-flex">
								<div class="input-group input-daterange mr-2">
									<input type="text" class="form-control" name="from" placeholder="From">
									<div class="input-group-addon">-</div>
									<input type="text" class="form-control" name="to" placeholder="To">
								</div>
								<button type="submit" class="btn btn-default border border-secondary">Filter</button>
							</form>
						</div>
					</div>
					
					<?php 
						if(isset($_SESSION['dates'])){
							echo $_SESSION['dates']; 
							unset($_SESSION['dates']);
						}
			  		?>
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header d-flex align-items-center">
								<h4 class="m-b-0 text-white"><small><i class="fa fa-circle fa-sm text-success" style="transform:scale(0.6)"></i> Billed service summary for : <?=$client->name.' ('.$client->person.')' ?></small></h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive ">
                                    <table id="employees123" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Service Name</th>
                                                <th>Descr.</th>
                                                <th>Qty</th>
                                                <th>Billed on</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <?php foreach($summary as $s): ?>
                                            <tr>
                                                <td><?= date('d-m-Y',strtotime($s->date)) ?></td>
                                                <td><?= $s->service_name ?></td>
                                                <td><?= $s->descr ?></td>
                                                <td><?= $s->qty ?></td>
                                                <td><?= date('d-m-Y',strtotime($s->updated_at)) ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="col-12 d-none">
						<form id="noScript" action="<?=base_url('summary/toInvoice')?>" method="POST" class="">
							<input type="text" name="ids" class="form-control col-4 mr-2" id="idsInput">
							<input type="text" name="cid" class="form-control col-4" value="<?=$client->id?>">
						</form>
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
		],
		dom: 'Bflrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
	
	$(function () {
		items= [];
		
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
				$('#idsInput').val(items);
				console.log($('#idsInput').val());
			});
			if(items.length==0){
				$('.btn-bulk').hide();
			}
			else{
				$('.btn-bulk').show();
			}
		}

		// Generate invoice button
		$(document).on('click', '#invBtn', function() {
			if (items.length==0) {
				alert('Please select atleast one service to generate invoice.');
			}else{
				$('.invForm').submit();
			}
		});
	});
</script>
