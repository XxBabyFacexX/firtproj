
    <div class="box-header">
        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon fa fa-tasks tip" data-placement="left" title="<?=lang("actions")?>"></i></a>
                    <ul class="dropdown-menu pull-right tasks-menus" role="menu" aria-labelledby="dLabel">
                        <li>
                            <a href="<?=admin_url('purchases/add')?>">
                                <i class="fa fa-plus-circle"></i> <?=lang('add_purchase')?>
                            </a>
                        </li>
                        <li>
                            <a href="#" id="excel" data-action="export_excel">
                                <i class="fa fa-file-excel-o"></i> <?=lang('export_to_excel')?>
                            </a>
                        </li>
                        <li>
                            <a href="#" id="combine" data-action="combine">
                                <i class="fa fa-file-pdf-o"></i> <?=lang('combine_to_pdf')?>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#" class="bpo" title="<b><?=lang("delete_purchases")?></b>"
                                data-content="<p><?=lang('r_u_sure')?></p><button type='button' class='btn btn-danger' id='delete' data-action='delete'><?=lang('i_m_sure')?></a> <button class='btn bpo-close'><?=lang('no')?></button>"
                                data-html="true" data-placement="left">
                                <i class="fa fa-trash-o"></i> <?=lang('delete_purchases')?>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <div class="box-content">
                <div class="row">
                    <div class="col-lg-12">

                        <p class="introtext"><?=lang('list_results');?></p>

                        <div class="table-responsive">
                            <table id="linkTable" cellpadding="0" cellspacing="0" border="0"
                                   class="table table-bordered table-hover table-striped">
                                <thead>
                                <tr class="active">
                                    <!-- <th style="min-width:30px; width: 30px; text-align: center;">
                                        <input class="checkbox checkft" type="checkbox" name="check"/>
                                    </th> -->

                                    <th><?= lang("title"); ?></th>
                                    <th><?= lang("link"); ?></th>
                                    <th><?= lang("active"); ?></th>


                                    <!-- <th><?= lang("purchase_status"); ?></th>
                                    <th><?= lang("grand_total"); ?></th>
                                    <th><?= lang("paid"); ?></th>
                                    <th><?= lang("balance"); ?></th>
                                    <th><?= lang("payment_status"); ?></th> -->
                                    <!-- <th style="min-width:30px; width: 30px; text-align: center;"><i class="fa fa-chain"></i></th>
                                    <th style="width:100px;"><?= lang("actions"); ?></th> -->
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td colspan="11" class="dataTables_empty"><?=lang('loading_data_from_server');?></td>
                                </tr>
                                </tbody>
                                <tfoot class="dtFilter">
                                <tr class="active">
                                  <!--   <th style="min-width:30px; width: 30px; text-align: center;">
                                        <input class="checkbox checkft" type="checkbox" name="check"/>
                                    </th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th> -->
                                    <th><!-- <?= lang("title"); ?> --></th>
                                    <th><!-- <?= lang("link"); ?> --></th>
                                    <th><!-- <?= lang("active"); ?> --></th>

                                    <!-- <th></th>
                                    <th style="min-width:30px; width: 30px; text-align: center;"><i class="fa fa-chain"></i></th>
                                    <th style="width:100px; text-align: center;"><?= lang("actions"); ?></th> -->
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
    $(document).ready(function () {
        var cTable = $('#linkTable').dataTable({
            "aaSorting": [[1, "asc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= admin_url('customers/getCustomers') ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            'fnRowCallback': function (nRow, aData, iDisplayIndex) {
                nRow.id = aData[0];
                nRow.className = "customer_details_link";
                return nRow;
            },
            "aoColumns": [{
                "bSortable": false,
                "mRender": checkbox
            }, {"bSortable": true}, null, null/*, null, null, null, null, null, {"mRender": currencyFormat}, null, {"bSortable": false}*/]
        }).dtFilter([
            {column_number: 0, filter_default_label: "[<?= lang("title"); ?>]", filter_type: "text", data: []},
            {column_number: 1, filter_default_label: "[<?=lang('link');?>]", filter_type: "text", data: []},
            {column_number: 2, filter_default_label: "[<?=lang('active');?>]", filter_type: "text", data: []},
            /*{column_number: 4, filter_default_label: "[<?=lang('phone');?>]", filter_type: "text", data: []},
            {column_number: 5, filter_default_label: "[<?=lang('price_group');?>]", filter_type: "text", data: []},
            {column_number: 6, filter_default_label: "[<?=lang('customer_group');?>]", filter_type: "text", data: []},
            {column_number: 7, filter_default_label: "[<?=lang('vat_no');?>]", filter_type: "text", data: []},
            {column_number: 8, filter_default_label: "[<?=lang('gst_no');?>]", filter_type: "text", data: []},
            {column_number: 9, filter_default_label: "[<?=lang('deposit');?>]", filter_type: "text", data: []},
            {column_number: 10, filter_default_label: "[<?=lang('award_points');?>]", filter_type: "text", data: []},*/
        ], "footer");
        $('#myModal').on('hidden.bs.modal', function () {
            cTable.fnDraw( false );
        });
    });
</script>