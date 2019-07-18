<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-star"></i><?= lang('gérer_les_liens'); ?></h2>
        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <i class="icon fa fa-tasks tip" data-placement="left" title="<?= lang("actions") ?>"></i>
                    </a>
                    <ul class="dropdown-menu pull-right tasks-menus" role="menu" aria-labelledby="dLabel">
                       <!--  <li>
                            <a href="<?= admin_url('fail/add') ?>">
                                <i class="fa fa-plus-circle"></i> <?= lang('add_link') ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= admin_url('fail/edit') ?>">
                                <i class="fa fa-edit"></i> <?= lang('edit_link') ?>
                            </a>
                        </li> -->
                        <!-- <li class="divider"></li> -->
                        <li>
                            <a href="#" class="bpo tip po" title="<b><?= $this->lang->line("delete_events") ?></b>"
                                data-content="<p><?= lang('r_u_sure') ?></p><button type='button' class='btn btn-danger' id='delete_all' data-action='delete'><?= lang('i_m_sure') ?></a> <button class='btn bpo-close'><?= lang('no') ?></button>"
                                data-html="true" data-placement="left">
                            <i class="fa fa-trash-o"></i> <?= lang('delete_link') ?>
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

                <div class="row">
                    <!-- form -->
                  <form id="frm">
                      
                      <input type="hidden" name="eid" value='' id='eid'>
                  
                    <!-- <?php echo form_hidden('eid','','id="eid"'); ?> -->
                        <div class="col-md-12">
                                
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <?= lang("title", "title") ?>
                                    <?= form_input('title', '','class="form-control gen_slug" id="title" required="required"'); ?>
                                </div>
                                <div class="form-group all col-md-6">
                                    <span id="llabel"><?= lang("link", "link") ?></span>
                                   <!--  <?= form_input('link', '','class="form-control gen_slug" id="link" required="required"'); ?> -->
                                   <input type="url" name="link" class="form-control gen_slug" id="link" required="required">
                                </div>

                                <div class="form-group all col-md-6">
                                    <?= lang("active", "active") ?>
                                    <?php
                                        $opts = array('yes' => lang('yes'), 'no' => lang('no'));
                                        //$select = array('type' => (isset($rec['0']->type)?$rec['0']->type:''));
                                        echo form_dropdown('active', $opts,'', 'class="form-control" id="type" required="required"');
                                    ?>
                                </div>
                                <?php if ($Admin): ?> 
                                    <div class="form-group all col-md-6">

                                        <?= lang("shops", "shops") ?>

                                        <?php $opts=array('all'=>lang('all_shops'))?>

                                        <?php foreach ($shops as $key => $value): ?>
                                            <?php $opts[$value['company']] =$value['company']?>
                                        <?php endforeach ?>

                                        <?php echo form_dropdown('shop', $opts,'', 'class="form-control" id="shop" required="required"'); ?>
                                    </div>
                                <?php endif ?> 
                            </div>
                            <div class="row">
                                <div class="form-group all col-md-6" style="margin-top:5px">
                                    <?php echo form_submit('add',lang('add_link'), 'class="btn btn-primary" id="save"'); ?>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>

<!-- list -->


<script>
    var oTable;
    var c="<i class='fa fa-chain'>";
    $(document).ready(function () {
        oTable = $('#tableData').dataTable({
            "aaSorting": [[3, "asc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= admin_url('ressources/getTable')?>',
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
                  null, {"bSortable": true, "mRender": link_h}, {"bSearchable":false,"bSortable": false, "mRender": yes_no},
                  
                /* {"bSortable": false, "mRender": formatQuantity}, */
                 {"bSortable": false},]
                 
         }).fnSetFilteringDelay().dtFilter([
            {column_number: 1, filter_default_label: "[<?=lang('title');?>]", filter_type: "text", data: []},
            {column_number: 2, filter_default_label: "[<?=lang('description');?>]", filter_type: "text", data: []},
            {column_number: 3, filter_default_label: "[<?=lang('start');?>]", filter_type: "text", data: []},
            ],"footer");
       
    });
</script>

                <div class="table-responsive">
                    <table id="tableData" class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr class="primary">

                            <th style="min-width:30px; width: 30px; text-align: center;">
                                <input class="checkbox checkth" type="checkbox" name="check"/>
                            </th>
                            <th style="width: 20%"><?= lang("title") ?></th>
                            <th style="width: 30%"><?= lang("link") ?></th>
                            <th style="width: 20%"><?= lang("active") ?></th>
                            <th style="min-width:65px; text-align:center;"><?= lang("actions") ?></th>
                        </tr>
                        </thead>
                        <tbody id="sortable">
                        <tr>
                            <td colspan="6" class="dataTables_empty"><?= lang('loading_data_from_server'); ?></td>
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
                            <th style="width:65px; text-align:center;"><?= lang("actions") ?></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

  <script> 
        $(document).ready(function(){

            $('#sortable').sortable({
                axis: "y",
                scroll: false,
                
                helper: fixWidthSortingHelper,
                containment: '#tableData',

                update: function(event, ui) {
                      $.ajax({
                          url: '<?= admin_url('ressources/sort') ?>',
                          type: 'GET',
                          data: {
                           idlist: $(this).sortable('toArray'),
                       },
                      })
                      .always(function() {
                          nav()
                      });


                  
               }
               
    
                
             }).disableSelection();
                    function fixWidthSortingHelper(e, ui) {
                    ui.children().each(function(){ 
                        $(this).width($(this).width()+50);
                    });
                    return ui;
                }



            $(document).on('click','#delete_all',function(){
                var s =this;
                var del=$(".multi-select:checked");

                if (del.length>0){
                    var cbox_value=[];
                    $(del).each(function(){
                        cbox_value.push($(this).val());
                    }); 
                    $.ajax({
                        url:'<?= admin_url('ressources/delete_all/') ?>',
                        mothod:'get',
                        data:{cbox_value:cbox_value},
                        success:function(){
                            oTable.fnDraw();
                            alert("<?=lang('records_deleted')?>");
                            nav();
                        }
                    })
                }else{
                    alert('<?=lang("no_record_selected")?>');
                }
            });

            $(document).click(function(){
                $('.popover').removeClass('in');
            });

            $(document).on('click','.delete',function(){
                var a= this;
                event.preventDefault();
                ss=$('.delete').closest('tr').attr('id');
                a=this;
                $.ajax({
                    url:"<?=admin_url('ressources/delete/')?>",
                    type:'get',
                    data:{
                        id:$('.delete').closest('tr').attr('id'),
                    },
                    success:function(data){
                        alert(data);
                        oTable.fnDraw();
                        nav();
                    }
                })
            });

            //EDIT
            $(document).on('click', '.edit', function(event) {
                event.preventDefault();
                $.ajax({
                    url:'<?=admin_url('ressources/get')?>',
                    method:'get',
                    data:{
                        id:$('.edit').closest('tr').attr('id'),
                    },
                    success:function(data){
                        res=$.parseJSON(data);

                        $('#eid').val(res[0].id);
                        $('#title').val(res[0].title);
                        $('#link').val(res[0].link);
                        $('#save').val('<?=lang("save")?>');
                    }
                });
            });

            $(document).on('submit', '#frm', function(event) {
                event.preventDefault();
                if($('#title').val()!=''&&$('#link').val()!=''){
                  /*  var aa=false
                    $.ajax({
                        url: '<?=admin_url('ressources/validate')?>',
                        type: 'GETPOST',
                        data: {
                            url:  $('#link').val(),
                        },
                    })
                    .done(function(data) {
                        aa=data;
                        console.log(data);
                    })*/
                    
                    // if (aa=='true') {
                        $.ajax({
                        url: '<?=admin_url('ressources/insert')?>',
                        type: 'get',
                        data: {
                            id: $("#eid").val(),
                            title:$('#title').val(),
                            link:$('#link').val(),
                            shop:$('#shop').val(),
                            active:$('#type').val(),
                        },
                        })
                        .done(function(data) {
                            /*if (data=='title or url fields requred') {
                                alert(data);
                            }
                            else{*/
                                $('#eid').val('');
                                $('#title').val('');
                                $('#link').val('');
                                $('#shop').val('');
                                $('#save').val('<?=lang("add_link")?>');
                            // }
                        })
                        .fail(function() {
                            console.log("error");
                        })
                        .always(function() {
                             oTable.fnDraw();
                             nav();
                        });
                    /*} 

                     else{
                            $('#llabel').html('<?php echo lang('invalid_link',"link") ?>');
                            $('#llabel').css('color','red');
                            $('#link').css('color','red');
                        }*/
                    }
                else{
                    alert('title and liks fields are required');
                } 
             });

                //refresh links
            function nav(){
                $.ajax({
                url: '<?=admin_url('ressources/get_by_shop')?>',
                })
                .done(function(data) {
                    links = $.parseJSON(data);
                    html='';
                    html+='<?php if  ($Owner || $Admin) { ?>';
                    html+='<li id="ressources_index">';
                    html+='<a class="submenu" href="<?= admin_url('ressources'); ?>">';
                    html+='<i class="fa fa-wrench"></i><span class="text"> <?= lang('gérer_les_liens'); ?></span>';
                    html+='</a>';
                    html+='</li>';
                    html+='<?php } ?>';
                    $.each(links, function(index, val) {
                        html+='<li class="links">';
                        html+='<a class="submenu" href="'+val.link+'" target="_blank">';
                        html+='<i class="fa fa-external-link">';
                        html+='</i><span class="text">'+val.title+'</span></a></li>';
                    });
                    $('#dynamicNav').html(html);
                    
                })
                .fail(function() {
                    console.log("error");
                });
            }
        });
    </script>
</div>