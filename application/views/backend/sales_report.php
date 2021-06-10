<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-list" aria-hidden="true"></i> Sales report</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('summary') ?>"> Sales</a></li>
                <li class="breadcrumb-item active"> Proforma sales report</li>
            </ol>
        </div>
    </div>
    <div class="message"></div>
    <?php echo $this->session->flashdata('message'); ?>
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-sm-12 mt-3 mb-4">
                <div class="pull-left">
                    <form action="<?= base_url('invoice/salesReportDateFilter/') ?>" id="noScript" method="POST" class="d-flex">
                        <div class="input-group input-daterange mr-2">
                            <input type="text" class="form-control" name="from" placeholder="From" required>
                            <div class="input-group-addon">-</div>
                            <input type="text" class="form-control" name="to" placeholder="To" required>
                        </div>
                        <button type="submit" class="btn btn-primary border border-secondary">Filter</button>
                        <a href="<?php echo base_url(); ?>invoice/sales_report" class="btn btn-default border ml-2">Reset</a>
                    </form>
                </div>
            </div>


            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header d-flex align-items-center">
                        <?php
                        if (isset($dates)) {
                            $dates = "Sales between " . $dates;
                        } else {
                            $dates = "Recent sales (Latest 20 sales from " . date('d-m-Y') . ")";
                        } ?>
                        <h4 class="m-b-0"><small> <?= $dates ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive ">
                            <table id="employees123" class="display nowrap table table-hover table-sm table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>S No</th>
                                        <th>Invoice no.</th>
                                        <th>Client name</th>
                                        <th>Invoice date</th>
                                        <th>Amount (in RS.)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $a = 1;
                                    $all_total = 0;
                                    foreach ($invoices as $i) : ?>
                                        <tr>
                                            <td><?= $a ?></td>
                                            <td><?= $i->inv_no ?></td>
                                            <td><?= $i->name ?></td>
                                            <td><?= date('d-m-Y', strtotime($i->inv_date)) ?></td>
                                            <td><?= $i->total ?></td>
                                        </tr>
                                    <?php $a++;
                                        $all_total += $i->total;
                                    endforeach; ?>
                                </tbody>
                                <tfoot class="">
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th><strong>TOTAL : </strong></th>
                                        <th><strong><?= $all_total ?></strong></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('backend/footer'); ?>
        <script>
            $('#employees123').DataTable({
                aLengthMenu: [
                    [10, 20, 100, -1],
                    [10, 20, 100, "All"]
                ],
                iDisplayLength: 20,
                "aaSorting": [],
                aoColumnDefs: [{
                    bSortable: false,
                    aTargets: [0]
                }],
                dom: 'Bflrtip',
                buttons: [{
                        extend: 'excel',
                        title: "<?= strip_tags($dates) ?>",
                        footer: true
                    },
                    {
                        extend: 'pdfHtml5',
                        title: "<?= strip_tags($dates) ?>",
                        customize: function(doc) {
                            doc.styles.title = {
                                    fontSize: '12'
                                },
                            doc.defaultStyle.alignment = 'left';
                            doc.styles.tableHeader.alignment = 'left';
                            doc.content[1].table.widths =
                                Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        },
                        footer: true
                    },
                    {
                        extend: 'print',
                        title: "<?= $dates ?>",
                        customize: function(doc) {
                            $(doc.document.body).find('h1').css('font-size', '12pt');
                            $(doc.document.body).find('h1').css('text-align', 'center');
                        },
                        footer: true
                    }
                ]
            });
        </script>