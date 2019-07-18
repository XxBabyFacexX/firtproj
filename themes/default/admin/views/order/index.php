<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-star"></i><?= lang('order_form'); ?></h2>
        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <i class="icon fa fa-tasks tip" data-placement="left" title="<?= lang("actions") ?>"></i>
                    </a>
                    <ul class="dropdown-menu pull-right tasks-menus" role="menu" aria-labelledby="dLabel">
                       <!--  <li>
                            <a class='add'>
                                <i class="fa fa-plus-circle"></i> <?= lang('add_record') ?>
                            </a>
                        </li> -->
                        <!-- <li>
                            <a href="<?= admin_url('fail/edit') ?>">
                                <i class="fa fa-edit"></i> <?= lang('edit_record') ?>
                            </a>
                        </li> -->
                        <!-- <li class="divider"></li>
                        <li>
                            <a href="#" class="bpo" title="<b><?= $this->lang->line("delete_records") ?></b>"
                                data-content="<p><?= lang('r_u_sure') ?></p><button type='button' class='btn btn-danger' id='delete_all' data-action='delete'><?= lang('i_m_sure') ?></a> <button class='btn bpo-close'><?= lang('no') ?></button>"
                                data-html="true" data-placement="left">
                            <i class="fa fa-trash-o"></i> <?= lang('delete_records') ?>
                             </a>
                         </li> -->
                    </ul>
                </li>
            </ul>
        </div>
    </div>

    <div class="box-content" >
        <div class="container">
            <div class="row" >
                <div class="col-md-12">
                    <div class="form-group col-sm-3" >
                        <!-- <?php $opts = array(
                            'tee_shirt' => lang('tee_shirt'),
                            'sweat_shirt' => lang('sweat_shirt'),
                            'mug' => lang('mug'),
                            'others' => lang('autres'),
                            ); ?>
                        <?= form_dropdown('type', $opts, 'tee_shirt','class="form-control",id="item"');?> -->
                         
                    <select name="type" class="form-control" id="item" >
                        <!-- <option value="" disabled selected>Select your option</option> -->
                        <option value="tee_shirt"><?= lang('tee_shirt') ?></option>
                        <option value="sweat_shirt"><?= lang('sweat_shirt') ?></option>
                        <option value="mug"><?= lang('mug') ?></option>
                        <option value="others"><?= lang('autres') ?></option>
                    </select>
                    </div>
                </div>
            </div>
            <div class="row" align=center>
                <picture >
                    <img src='./assets/images/t.jpg' alt="shirt" id="item_img" width=400 hight=600 class="img-responsive">
                </picture>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <?= lang("comment", "comments") ?>
                 
                    <?= form_textarea('comments', '', 'class="form-control" id="details"'); ?>
                  
                    <div class="form-group" style="margin-top:5px">
                        <button type="button"class="btn btn-primary pull-left" ><?=$this->lang->line("télécharger")?></button>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3" align=center>
                        <di class="row">
                            <!-- <input type="radio" class="custom-control-input face" id="customRadio1" name="example1" value="customEx"> -->
                            <button class="btn-danger face" id="f" style='width: 30px;height: 20px;width:20px;padding: 6px 0px;border-radius: 15px;text-align: center;font-size: 12px;line-height: 1.42857;' value="front"></button>
                        </di>
                            <?= lang("face_avant", "customRadio1") ?>
                    </div>
                    <div class="col-xs-3" align=center>
                        <di class="row">
                            <!-- <input type="radio" class="custom-control-input face" id="customRadio2" name="example1" value="customEx"> -->
                            <button class="btn-primary face" style='width: 30px;height: 20px;width:20px;padding: 6px 0px;border-radius: 15px;text-align: center;font-size: 12px;line-height: 1.42857;' value="back"></button>
                        </di>
                            <?= lang("face arrière", "customRadio2") ?>
                    </div>
                    <div class="col-xs-3" align=center>
                        <di class="row">
                            <!-- <input type="radio" class="custom-control-input face" id="customRadio3" name="example1" value="customEx"> -->
                            <button class="btn-primary face" style='width: 30px;height: 20px;width:20px;padding: 6px 0px;border-radius: 15px;text-align: center;font-size: 12px;line-height: 1.42857;' value="left"></button>
                        </di>
                            <?= lang("manche gauche", "customRadio3") ?>
                    </div>
                    <div class="col-xs-3" align=center>
                        <di class="row">
                            <!-- <input type="radio" class="custom-control-input face" id="customRadio4" name="example1" value="customEx"> -->
                            <button class="btn-primary face" style='width: 30px;height: 20px;width:20px;padding: 6px 0px;border-radius: 15px;text-align: center;font-size: 12px;line-height: 1.42857;' value="right"></button>
                        </di>
                            <?= lang("manche_droite", "customRadio4") ?>
                    </div>                
                </div>
            </div>
        </div>
    </div>

   

    <div class="modal fade cal_modal">
                    <div class="modal-dialog" >
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                    <i class="fa fa-2x">&times;</i>
                                </button>
                                <h4 class="modal-title"></h4>
                            </div>
                            <div class="modal-body" >
                                <div class="error"></div>
                                 
                                <!-- <?php
                                    $attrib = array('data-toggle' => 'validator', 'role' => 'form', 'id'=>'frm');?> -->
                                <form id='frm'>
                                    <input type="hidden" name="eid" value='' id='eid'>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="row">
                                                    <div class="col-md-5 col-sm-4 col-xs-4" >
                                                        <input type="radio" class="custom-control-input face" id="man" name="for" value="1" required>
                                                        <?= lang("homme", "man") ?>
                                                    </div>
                                                     <div class="col-md-5 col-sm-4 col-xs-4" >
                                                        <input type="radio" class="custom-control-input face" id="women" name="for" value="2" required>
                                                        <?= lang("femme", "women") ?>
                                                    </div>
                                                     <div class="col-md-5 col-sm-4 col-xs-4" >
                                                        <input type="radio" class="custom-control-input face" id="child" name="for" value="3" required>
                                                        <?= lang("enfant", "child") ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group all">
                                                        <?= form_input('mark', '','class="form-control gen_slug" id="mark" required="required" placeholder=" '. lang('marque') .' " '); ?>
                                                    </div>
                                                    <div class="form-group all">
                                                        <?= form_input('color', '', 'class="form-control gen_slug" id="color" required="required" placeholder="'. lang('couleur').' "'); ?>
                                                    </div>

                                                    <div class="form-group all">
                                                        <?= form_input('tialle', '','class="form-control gen_slug" id="tialle" required="required" placeholder=" '. lang('tialle') .' "'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=" col-md-6 col-sm-6 form-group" >
                                                <textarea class="form-control skip" id="description" name="description" style="height: 190px; resize: none;" placeholder=" <?= lang('commentaries') ?> "></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-4" align="center"></div>
                                        <div class="col-xs-4 form-group" align="center">
                                            <input type="text" class="form-control"  value="" readonly>
                                        </div>
                                        <div class="col-xs-4" align="center"></div>
                                    </div>
                                    <div class="row"style="margin-top: 10px">
                                        <div class="col-xs-3" align="center"></div>
                                        <div class="col-xs-6 form-group" align="center">
                                            <button type='button' id='tog' class='btn btn-primary form-control' style="white-space: normal;"><?=lang('add_a_new_product') ?></button>
                                        </div>
                                        <div class="col-xs-3" align="center"></div>
                                    </div>
                                    <div class="container" id="hide" style="display:none">
                                        asdasd
                                    </div>
                                    <div class="container">
                                        <div class="row"style="margin-top: 10px">
                                            <h2><?=lang('order_details') ?></h2>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="row">
                                                    <div class="form-group all">
                                                        <!-- <?= form_input('due_date', '','class="form-control gen_slug" id="code" required="required" placeholder=" '. lang('due_date') .' " '); ?> -->
                                                        <input type="date" class="form-control" name="date_out" id="due_date">
                                                    </div>
                                                    <div class="form-group all">
                                                        <?= form_input('name', '', 'class="form-control gen_slug" id="name" required="required" placeholder="'. lang('customer_name').' "'); ?>
                                                    </div>

                                                    <div class="form-group all">
                                                        <?= form_input('society', '','class="form-control gen_slug" id="society" required="required" placeholder=" '. lang('société') .' "'); ?>
                                                    </div>
                                                    <div class="form-group all">
                                                        <?= form_input('telephone', '','class="form-control gen_slug" id="telephone" required="required" placeholder=" '. lang('telephone') .' "'); ?>
                                                    </div>
                                                    <div class="form-group all">
                                                        <?= form_input('email', '','class="form-control gen_slug" id="email" required="required" placeholder=" '. lang('email') .' "'); ?>
                                                    </div>
                                                    <div class="row container">
                                                        <div class="col-md-5 col-sm-12 form-group pull-left" style="padding:0" >
                                                            <input type="text" class="form-control" value="" readonly>
                                                        </div>
                                                        <div class="col-md-5 col-sm-12 form-group pull-right" style="padding:0" >
                                                            <input type="text" class="form-control" value="" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row container" style="margin-bottom: 10px">
                                                        <div class="col-md-5 col-sm-12 pull-left form-group" style="padding:0">
                                                            <select name="type" class="form-control" id="item">
                                                               
                                                                <option value="to_be_printed" selected><?= lang('à_imprimer') ?></option>
                                                                <option value="quote_waiting"><?= lang('attente_de_devis') ?></option>
                                                                <option value="waiting_for_information"><?= lang('attente d`informations') ?></option>
                                                                <option value="waiting_for_payment"><?= lang('attente_du_paiement') ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                    
                                                
                                            </div>
                                            <div class=" col-sm-6 col-sm-6  form-group" >
                                                <textarea class="form-control skip" id="description" name="description" style="height: 250px; resize: none;" placeholder=" <?= lang('commentaries') ?> "></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-sm-6 col-xs-6 pull-right">
                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 pull-left">
                                                <?= form_submit('add', $this->lang->line("save"), 'class="btn btn-primary form-control"'); ?>
                                            </div>
                                            <div class="form-group col-md-8 col-sm-12 col-xs-12 pull-right">
                                                <?= form_submit('add', $this->lang->line("save_review_&_customer's_sign"), 'class="btn btn-primary form-control"'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            <div class="modal-footer"></div>
                        </div>
                    </div>
                </div>
            </div>
             

<script>
    $(document).ready(function() {
        $('#item').change(function(event) {
            img = {
                tee_shirt:'./assets/images/t.jpg',
                sweat_shirt:'./assets/images/male.png',
                mug:'./assets/images/female.png',
                others:'//',
            };
            $('.btn-danger').removeClass('btn-danger');
            $('.face').addClass('btn-primary');
            $('#f').removeClass('btn-primary');
            $('#f').addClass('btn-danger');
            //alert(img[$('#item').val()]);
            $('#item_img').attr('src', img[$(this).val()]);

        });

        $(document).on('click', '.face', function(e){

            img={
                tee_shirt:{
                    front:"./assets/images/t.jpg",
                    back:"./assets/images/back.png",
                    left:'./assets/images/male.png',
                    right:'./assets/images/female.png'
                },
                sweat_shirt:{
                    front:'./assets/images/male.png',
                    back:"./assets/images/back.png",
                    left:"./assets/images/t.jpg",
                    right:'./assets/images/female.png'
                },
                mug:{
                    front:'./assets/images/female.png',
                    back:"./assets/images/back.png",
                    left:'./assets/images/male.png',
                    right:"./assets/images/t.jpg"
                }
            }
                
            $('#item_img').attr('src', img[$('#item').val()][$(this).val()]);
            $('.btn-danger').removeClass('btn-danger');
            $('.face').addClass('btn-primary');
            $(this).removeClass('btn-primary');
            $(this).addClass('btn-danger');
            
        });
        let a=0;
        $('#tog').click(function(event) {
            if(a==0){
                $('#hide').removeAttr('style');
                a=1;
            }
            else{
                $('#hide').attr('style', 'display:none');
                a=0;
            }
        });

        $(document).on('submit', '#frm', function(event) {
            event.preventDefault();
            //alert($('#details').val());
            alert($('.face:checked').val());

        });

        $(document).on('click','#item_img', function(calEvent, jsEvent, view) {
            currentEvent = calEvent;
                /*if auto fill is not applicable 
                if ( !(<?=($Admin)?$Admin:0?>==1||<?=($Owner)?$Owner:0?>==1) ) {*/
                $.ajax({
                    url: "<?= admin_url('order/get_customer_details') ?>",
                })
                .done(function(data) {
                   res=$.parseJSON(data);

                   //console.log(res);
                   $('#name').val(res[0]['first_name']+' '+res[0]['last_name']);

                   $('#telephone').val(res[0]['phone']);
                   $('#email').val(res[0]['email']);

                })
           //}

                modal3({
                    buttons: {
                        update: {
                            id: 'update-event',
                            css: 'btn-primary submit',
                            label: 'save'
                        }
                    },
                    title: $('#item').val(),
                    firstT:'<?=lang('option_for_product') ?>'
                });
        });

        function modal3(data) {
            $('.modal-title').html( data.firstT+' ('+data.title+')');
            $('.cal_modal').modal('show');
            $('#frm').attr('action', '<?=admin_url('fail/upload')?>');
        }
    });
</script>