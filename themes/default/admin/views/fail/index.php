
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- <div class=" ekko-lightbox modal fade" id="imgmodal" style="min-width: 100px;">
    <div class="modal-dialog" id="c">
        <div class="modal-body" align="center">
            <img id="myImage" class="img-responsive" src="" alt="" style="min-width: 300px; min-height: 300px" >
        </div>
    </div>
</div> -->

<script>
    var oTable;
    $(document).ready(function () {
        oTable = $('#PRData').dataTable({
            "aaSorting": [[3, "asc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?=admin_url('fail/getTable')?>',
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
                {"bSearchable": false,"bSortable": false,"mRender": img_h},
                 null, null, null,
                  
                /* {"bSortable": false, "mRender": formatQuantity}, */
                 null,null,null,null,null,{"bSortable": false}]
                 
         }).fnSetFilteringDelay().dtFilter([
            {column_number: 1, filter_default_label: "[<?=lang('image');?>]", filter_type: "text", data: []},
            {column_number: 2, filter_default_label: "[<?=lang('employee_name');?>]", filter_type: "text", data: []},
            {column_number: 3, filter_default_label: "[<?=lang('shop');?>]", filter_type: "text", data: []},
            {column_number: 4, filter_default_label: "[<?=lang('code');?>]", filter_type: "text", data: []},
            {column_number: 5, filter_default_label: "[<?=lang('type');?>]", filter_type: "text", data: []},
            {column_number: 6, filter_default_label: "[<?=lang('name');?>]", filter_type: "text", data: []},
            {column_number: 7, filter_default_label: "[<?=lang('quantity');?>]", filter_type: "text", data: []},
            {column_number: 8, filter_default_label: "[<?=lang('date_time');?>]", filter_type: "text", data: []},
            {column_number: 9, filter_default_label: "[<?=lang('comment');?>]", filter_type: "text", data: []},
            ],"footer");
       
    });
</script>


<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-star"></i><?= lang('list_loupés/erreurs'); ?></h2>
        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <i class="icon fa fa-tasks tip" data-placement="left" title="<?= lang("actions") ?>"></i>
                    </a>
                    <ul class="dropdown-menu pull-right tasks-menus" role="menu" aria-labelledby="dLabel">
                        <li>
                            <a class='add'>
                                <i class="fa fa-plus-circle"></i> <?= lang('add_record') ?>
                            </a>
                        </li>
                        <!-- <li>
                            <a href="<?= admin_url('fail/edit') ?>">
                                <i class="fa fa-edit"></i> <?= lang('edit_record') ?>
                            </a>
                        </li> -->
                        <li class="divider"></li>
                        <li>
                            <a href="#" class="bpo" title="<b><?= $this->lang->line("delete_records") ?></b>"
                                data-content="<p><?= lang('r_u_sure') ?></p><button type='button' class='btn btn-danger' id='delete_all' data-action='delete'><?= lang('i_m_sure') ?></a> <button class='btn bpo-close'><?= lang('no') ?></button>"
                                data-html="true" data-placement="left">
                            <i class="fa fa-trash-o"></i> <?= lang('delete_records') ?>
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
                    <table id="PRData" class="table table-bordered table-condensed table-hover table-striped">
                        <thead>
                        <tr class="primary">

                            <th style="min-width:30px; width: 30px; text-align: center;">
                                <input class="checkbox checkth" type="checkbox" name="check"/>
                            </th>
                            <th style="min-width:40px; width: 40px; text-align: center;"><?php echo $this->lang->line("image"); ?></th>
                            <th><?= lang("employee_name") ?></th>
                            <th><?= lang("shop") ?></th>
                            <th><?= lang("code") ?></th>
                            <th><?= lang("type") ?></th>
                            <th><?= lang("name") ?></th>
                            <th><?= lang("quantity") ?></th>
                            <th><?= lang("date_time") ?></th>
                            <th><?= lang("comment") ?></th>
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
                                 
                                <?php
                                    $attrib = array('data-toggle' => 'validator', 'role' => 'form', 'id'=>'frm');?>
                                <?= admin_form_open_multipart("", $attrib)?>
                                    <input type="hidden" name="eid" value='' id='eid'>
                                    <div class="row">
                                        <div class="col-md-12">

                                            <div class="form-group all">
                                                <?= lang("code", "code") ?>
                                                <?= form_input('code', '','class="form-control gen_slug" id="code" required="required" '); ?>
                                            </div>

                                            <div class="form-group">
                                                <?= lang("product_type", "type") ?>
                                                <?php
                                                    $opts = array('standard' => lang('standard'), 'combo' => lang('combo'), 'digital' => lang('digital'), 'service' => lang('service'));
                                                   
                                                    echo form_dropdown('type', $opts, '', 'class="form-control" id="type" required="required"');
                                                ?>
                                            </div>
                                            <div class="form-group all">
                                                <?= lang("product_name", "name") ?>
                                                <?= form_input('name', '', 'class="form-control gen_slug" id="name" required="required"'); ?>
                                            </div>

                                            <div class="form-group all">
                                                <?= lang("quantity", "quantity") ?>
                                                <?= form_input('quantity', '','class="form-control gen_slug" id="quantity" required="required"'); ?>
                                            </div>
                                            
                                              <div class="form-group all">
                                                <?= lang("image", "image") ?>
                                                <input id="image" type="file" data-browse-label="<?= lang('browse'); ?>" name="userfile" data-show-upload="false"
                                                       data-show-preview="false" accept="image/*" class="form-control file" >
                                            </div>
                                        </div>
                                    </div>
                                

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <?= lang("comment", "comment") ?>
                                         
                                            <?= form_textarea('comments', '', 'class="form-control" id="details"'); ?>
                                          
                                            <div class="form-group" style="margin-top:5px">
                                                <?php echo form_submit('add', $this->lang->line("save"), 'class="btn btn-primary pull-right"'); ?>
                                            </div>
                                       </div>
                                    </div>
                                </form>
                            <div class="modal-footer"></div>
                        </div>
                    </div>
                </div>

  <script> 
        $(document).ready(function(){

            $(document).on('click','#delete_all',function(){
                var s =this;
                var del=$(".multi-select:checked");

                if (del.length>0){
                    var cbox_value=[];
                    $(del).each(function(){
                        cbox_value.push($(this).val());
                    }); 
                    $.ajax({
                        url:'<?= admin_url('fail/delete_all/') ?>',
                        mothod:'get',
                        data:{cbox_value:cbox_value},
                        success:function(){
                            $(this).remove();
                            $.each(cbox_value,function(index, value){
                                
                            });
                            oTable.fnDraw();
                            alert("<?=lang('records_deleted')?>");
                        }
                        
                    })
                }else{
                    alert('<?=lang("no_record_selected")?>');
                }
            });
            $(document).click(function(){
                $('.popover').removeClass('in');
            });

            $(document).on('click','#delete',function(){
                event.preventDefault();
                ss=$('#delete').closest('tr').attr('id');
                a=this;
                $.ajax({
                    url:"<?=admin_url('fail/delete')?>",
                    type:'get',
                    data:{
                        id:$('#delete').closest('tr').attr('id'),
                    },
                    success:function(data){
                        alert(data);
                         oTable.fnDraw();
                    }
                })
               
            });

//modals
            $(document).on('click','.edit', function(calEvent, jsEvent, view) {
                currentEvent = calEvent;
               
                    s=this;
                
                    modal2({
                        buttons: {
                            update: {
                                id: 'update-event',
                                css: 'btn-primary submit',
                                label: 'save'
                            }
                        },
                        title: 'edit_record',
                        event: 'edit_record',
                        s: s,
                    });
            });

            $(document).on('click','.add', function(calEvent, jsEvent, view) {
                currentEvent = calEvent;
                     $('#frm').attr('');
                        $('#eid').val('');
                        $('#code').val('');
                        $('#type').val('standard');
                        $('#name').val('');
                        $('#quantity').val('');
                    s=this;
                
                    modal3({
                        buttons: {
                            update: {
                                id: 'update-event',
                                css: 'btn-primary submit',
                                label: 'save'
                            }
                        },
                        title: 'edit_record',
                        event: 'edit_record',
                        s: s,
                    });
            });

            //tigaman
            function modal3(data) {

                //show titile and footer of the modals
                $('.modal-title').html(data.title);
                $('.modal-footer button:not(".btn-default")').remove();
                $('#title').val(data.event ? data.event.title : '');

                $('.cal_modal').modal('show');
                
                $('#frm').attr('action', '<?=admin_url('fail/upload')?>');
            }

            function modal2(data) {

                //show titile and footer of the modals
                $('.modal-title').html(data.title);
                $('.modal-footer button:not(".btn-default")').remove();
                $('#title').val(data.event ? data.event.title : '');

                $('.cal_modal').modal('show');
                
                a= site.base_url+'fail/get_by_id'; 
                
                $.ajax({
                    method:'get',
                    url:a,
                    data:{
                        id:$(data.s).closest('tr').attr('id'),
                    },
                    success:function(data)
                    {
                        res=$.parseJSON(data);
                        console.log(res);
                        $('#frm').attr('action', "<?=admin_url('fail/upload/')?>"+res[0].id+'/'+res[0].file_name);
                        $('#eid').val(res[0].id);
                        $('#code').val(res[0].code);
                        $('#type').val(res[0].type);
                        $('#name').val(res[0].name);
                        $('#quantity').val(res[0].quantity);
                    },
                   
                })
            }
        });



    </script>
   
</div>