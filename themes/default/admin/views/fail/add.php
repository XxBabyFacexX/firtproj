<?php if (isset($res->code)): ?>
    <pre>
        <?php print_r($res) ?>
    </pre>    
<?php endif ?>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-plus"></i><?= lang('add_fail'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?php echo lang('enter_info'); ?></p>

                <?php
                $attrib = array('data-toggle' => 'validator', 'role' => 'form', 'id'=>'frm');?>
                <?php if (isset($rec)) : ?>
                    <?= admin_form_open_multipart("fail/upload/".$rec['0']->id."/".$rec['0']->file_name, $attrib) ?>
                    <?php else: ?>
                        <?= admin_form_open_multipart("fail/upload", $attrib)?>
                <?php endif ?>
                
                <div class="row">
                    <div class="col-md-6">

                        <div class="form-group all">
                            <?= lang("code", "code") ?>
                            <?= form_input('code', (isset($rec['0']->code)?$rec['0']->code:''),'class="form-control gen_slug" id="code" required="required" '); ?>
                        </div>

                        <div class="form-group">
                            <?= lang("product_type", "type") ?>
                            <?php
                                $opts = array('standard' => lang('standard'), 'combo' => lang('combo'), 'digital' => lang('digital'), 'service' => lang('service'));
                                $select = array('type' => (isset($rec['0']->type)?$rec['0']->type:''));
                                echo form_dropdown('type', $opts, $select, 'class="form-control" id="type" required="required"');
                            ?>
                        </div>
                        <div class="form-group all">
                            <?= lang("product_name", "name") ?>
                            <?= form_input('name', (isset($rec['0']->name)?$rec['0']->name:''), 'class="form-control gen_slug" id="name" required="required"'); ?>
                        </div>

                        <div class="form-group all">
                            <?= lang("quantity", "quantity") ?>
                            <?= form_input('quantity', (isset($rec['0']->quantity)?$rec['0']->quantity:''),'class="form-control gen_slug" id="quantity" required="required"'); ?>
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
                     
                        <?= form_textarea('comments', (isset($rec['0']->comment)?$rec['0']->comment:''), 'class="form-control details" '); ?>
                      
                        <div class="form-group" style="margin-top:5px">
                            <?php echo form_submit('add', (isset($rec)?$this->lang->line("save"):$this->lang->line("add_record")), 'class="btn btn-primary" id="add"'); ?>
                        </div>
                   </div>
                </div>
                <?= form_close(); ?>
            </div>

       <!--      <script>
                $('#frm').submit(function(){
                    event.preventDefault();
                    $.post('<?=site_url('main/add_re')?>',
                    {
                      code=$('#code').val(),
                       type=$('#type').val(),
                       name=$('#name').val(),
                       comments=$('#comments').val()
                    },
                    function(data, status){
                        alert("Data: " + data );
                    });
                });
            </script> -->
        </div>
    </div>
</div>


