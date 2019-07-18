<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<link href='<?= $assets ?>fullcalendar/css/fullcalendar.min.css' rel='stylesheet' />
<link href='<?= $assets ?>fullcalendar/css/fullcalendar.print.css' rel='stylesheet' media='print' />
<link href="<?= $assets ?>fullcalendar/css/bootstrap-colorpicker.min.css" rel="stylesheet" />

<style>
    .fc th {
        padding: 10px 0px;
        vertical-align: middle;
        background:#F2F2F2;
        width: 14.285%;
    }
    .fc-content {
        cursor: pointer;
    }
    .fc-day-grid-event>.fc-content {
        padding: 4px;
    }

    .fc .fc-center {
        margin-top: 5px;
    }
    .error {
        color: #ac2925;
        margin-bottom: 15px;
    }
    .event-tooltip {
        width:150px;
        background: rgba(0, 0, 0, 0.85);
        color:#FFF;
        padding:10px;
        position:absolute;
        z-index:10001;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 11px;
    }
</style>
<script>
    var oTable;
    $(document).ready(function () {
        oTable = $('#tableData').dataTable({
            "aaSorting": [[3, "asc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= admin_url('calendar/get_all_events/'.$ownShop[0]->company ) ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            'fnRowCallback': function (nRow, aData, iDisplayIndex) {
               
                nRow.id = aData[0];
               
                //if(aData[7] > aData[9]){ nRow.className = "product_link warning"; } else { nRow.className = "product_link"; }
                return nRow;
            },
            "aoColumns": [
                {"bSortable": false, "mRender": checkbox},
                  null, null, null, null,
                  
                /* {"bSortable": false, "mRender": formatQuantity}, */
                 null,null,null,null]
                 
         }).fnSetFilteringDelay().dtFilter([
            {column_number: 1, filter_default_label: "[<?=lang('title');?>]", filter_type: "text", data: []},
            {column_number: 2, filter_default_label: "[<?=lang('description');?>]", filter_type: "text", data: []},
            {column_number: 3, filter_default_label: "[<?=lang('start');?>]", filter_type: "text", data: []},
            {column_number: 4, filter_default_label: "[<?=lang('end');?>]", filter_type: "text", data: []},
            {column_number: 5, filter_default_label: "[<?=lang('user');?>]", filter_type: "text", data: []},
            {column_number: 6, filter_default_label: "[<?=lang('user_type');?>]", filter_type: "text", data: []},
            {column_number: 7, filter_default_label: "[<?=lang('shop');?>]", filter_type: "text", data: []},
            ],"footer");
       
    });
</script>

<div class="box">
    <div class="box-header">
        <h2 class="blue"><i
                class="fa-fw fa fa-barcode"></i><?= lang('events')  ?>
        </h2>

        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <i class="icon fa fa-tasks tip" data-placement="left" title="<?= lang("actions") ?>"></i>
                    </a>
                    <ul class="dropdown-menu pull-right tasks-menus" role="menu" aria-labelledby="dLabel">
                        <li>
                            <li><a class="add">
                                <i class="fa fa-plus-circle"></i> <?=  lang('add_event')  ?>
                                </a>
                            </li>
                        </li>
                      
                        <!-- <li>
                            <a href="#" id="labelProducts" data-action="labels">
                                <i class="fa fa-print"></i> <?= lang('print_barcode_label') ?>
                            </a>
                        </li>
                        <li>
                            <a href="#" id="sync_quantity" data-action="sync_quantity">
                                <i class="fa fa-arrows-v"></i> <?= lang('sync_quantity') ?>
                            </a>
                        </li>
                        <li>
                            <a href="#" id="excel" data-action="export_excel">
                                <i class="fa fa-file-excel-o"></i> <?= lang('export_to_excel') ?>
                            </a>
                        </li> -->
                        <li class="divider"></li>
                        <li>
                            <a href="#" class="tip po" title="<b><?= $this->lang->line("delete_event") ?></b>"
                                data-content="<p><?= lang('r_u_sure') ?></p>
                                <a type='button' class='btn btn-danger delete_all' ><?= lang('i_m_sure') ?></a> <button class='btn bpo-close'><?= lang('no') ?></button>"
                                data-html="true" data-placement="left">
                            <i class="fa fa-trash-o"></i> <?= lang('delete_event') ?>
                             </a>
                         </li>
                    </ul>
                </li>
            </ul>     
        </div>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                <p class="introtext"><?= lang('list_results'); ?></p>

                <div class="table-responsive">
                    <table id="tableData" class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr class="primary">
                            <th style="min-width:30px; width: 30px; text-align: center;">
                                <input class="checkbox checkth" type="checkbox" name="check"/>
                            </th>
                            <th><?= lang("title") ?></th>
                            <th><?= lang("description") ?></th>
                            <th><?= lang("start") ?></th>
                            <th><?= lang("end") ?></th>
                            <th><?= lang("user") ?></th>
                            <th><?= lang("user_type") ?></th>
                            <th><?= lang("shop") ?></th>
                            <th style="min-width:65px; text-align:center;"><?= lang("actions") ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="11" class="dataTables_empty"><?= lang('loading_data_from_server'); ?></td>
                        </tr>
                        </tbody>

                        <tfoot class="dtFilter">
                        <tr class="active">
                            <th style="min-width:30px; width: 30px; text-align: center;">
                                <input class="checkbox checkft" type="checkbox" name="check"/>
                            </th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th style="width:65px; text-align:center;"><?= lang("actions") ?></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade cal_modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                    <i class="fa fa-2x">&times;</i>
                                </button>
                                <h4 class="modal-title"></h4>
                            </div>
                            <div class="modal-body">
                                <div class="error"></div>
                                <form>
                                    <input type="hidden" value="" name="eid" id="eid">
                                    <div class="form-group">
                                        <?= lang('title', 'title'); ?>
                                        <?= form_input('title', set_value('title'), 'class="form-control tip" id="title" required="required"'); ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <?= lang('start', 'start'); ?>
                                                <?= form_input('start', set_value('start'), 'class="form-control datetime" id="start" required="required"'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <?= lang('end', 'end'); ?>
                                                <?php echo form_input('end', set_value('end'), 'class="form-control datetime" id="end"'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <?= lang('event_color', 'color'); ?>
                                                <div class="input-group">
                                                    <span class="input-group-addon" id="event-color-addon" style="width:2em;"></span>
                                                    <input id="color" name="color" type="text" class="form-control input-md" readonly="readonly" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <?= lang('description', 'description'); ?>
                                        <textarea class="form-control skip" id="description" name="description"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <?= lang('shops', 'shops'); ?>
                                     
                                            <?php if ($Owner||$Admin): ?>
                                                <?php foreach ($shops as $key => $value): ?>
                                                    <?php $opts[$value->company]=$value->company ?>
                                                <?php endforeach ?>
                                            <?php else: ?>

                                                <?php $opts[$ownShop->company]=$ownShop->company ?>
                                                
                                            <?php endif ?>
                                            <?php $opts['all']=lang('all_shops') ?>
                                            <?php /*$select = array('type' => (isset($rec['0']->type)?$rec['0']->type:''));*/ ?>
                                            <?= form_dropdown('shop', $opts,'', 'class="form-control" id="type_user" required="required"'); ?> 
                                            

                                       
                                    </div>
                                    <div class="form-group">
                                        <?= lang('user_types', 'user_types'); ?>
                                    
                                            <?php foreach ($groups as $key => $value): ?>
                                                    <?php $opt[$value->name]=$value->name ?>
                                                <?php endforeach ?>
                                           <!--  <?php/*$select = array('type' => (isset($rec['0']->type)?$rec['0']->type:''));*/ ?> -->
                                            <?= form_dropdown('group_name', $opt,'', 'class="form-control" id="type_group" required="required"'); ?>
                                       
                                    </div>

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="add-event btn btn-primary submit">save</button>
                            </div>
                        </div>
                    </div>
                </div>
</div>

<script type="text/javascript">
    var currentLangCode = '<?= $cal_lang; ?>', moment_df = '<?= strtoupper($dateFormats['js_sdate']); ?> HH:mm', cal_lang = {},
    tkname = "<?=$this->security->get_csrf_token_name()?>", tkvalue = "<?=$this->security->get_csrf_hash()?>";
    cal_lang['add_event'] = '<?= lang('add_event'); ?>';
    cal_lang['edit_event'] = '<?= lang('edit_event'); ?>';
    cal_lang['delete'] = '<?= lang('delete'); ?>';
    cal_lang['event_error'] = '<?= lang('event_error'); ?>';

    console.log('<?= $assets ?>');
</script>
<script src='<?= $assets ?>fullcalendar/js/moment.min.js'></script>
<script src="<?= $assets ?>fullcalendar/js/fullcalendar.min.js"></script>
<script src="<?= $assets ?>fullcalendar/js/lang-all.js"></script>
<script src='<?= $assets ?>fullcalendar/js/bootstrap-colorpicker.min.js'></script>
<script src='<?= $assets ?>fullcalendar/js/main.js'></script>
<script>
    $(document).ready(function($) {
        $(document).on('click','.delete',function(event) {
            event.preventDefault();
            ss=$('.delete').closest('tr').attr('id');
            a=this;
            $.ajax({
                url:"<?=admin_url('calendar/delete')?>",
                type:'get',
                data:{
                    id:$('.delete').closest('tr').attr('id'),
                },
                success:function(data){
                    alert(data);
                    $(a).slideUp('slow', function() {$('#'+ss).remove();});
                }
            })
         }); 
          $(document).on('click','.delete_all',function(){
                var s =this;
                var del=$(".multi-select:checked");

                if (del.length>0){
                    var cbox_value=[];
                    $(del).each(function(){
                        cbox_value.push($(this).val());
                    }); 
                    $.ajax({
                        url:'<?= admin_url('calendar/delete_all') ?>',
                        mothod:'get',
                        data:{cbox_value:cbox_value},
                        success:function(){
                            $(this).remove();
                            $.each(cbox_value,function(index, value){
                                
                                
                            });
                             oTable.fnDraw();
                            alert("<?=lang('records_deleted')?>")
                        }
                    })
                }else{
                    alert('<?=lang("no_record_selected")?>');
                }

                $('.product_link').off('click');
/*
                $(document).on('click', '#tableData', function(event) {
                     
                    alert();
                });*/
            });

        $(document).click(function(){
            $('.popover').removeClass('in');
        });

         /*$(document).on('click','.edit',function(event) {
           modal({
                    buttons: {
                        delete: {
                            id: 'delete-event',
                            css: 'btn-danger pull-left',
                            label: cal_lang.delete
                        },
                        update: {
                            id: 'update-event',
                            css: 'btn-primary submit',
                            label: cal_lang.edit_event
                        }
                    },
                    title: cal_lang.edit_event+' "' + calEvent.title + '"',
                    event: calEvent
                    });         
         }); */
    });


</script>

<!-- <?php if ($Owner || $GP['bulk_actions']) { ?>
    <div style="display: none;">
        <input type="hidden" name="form_action" value="" id="form_action"/>
        <?= form_submit('performAction', 'performAction', 'id="action-form-submit"') ?>
    </div>
    <?= form_close() ?>
<?php } ?> -->
