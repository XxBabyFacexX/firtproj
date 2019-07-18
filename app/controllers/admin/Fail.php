<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fail extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->admin_model('fail_model');
	}

	public function index()
	{
		$bc = array(array('link' => base_url(), 'page' => lang('fail')), array('link' => '#', 'page' => lang('fail')));
        $meta = array('page_title' => lang('list_loupés/erreurs'), 'bc' => $bc);
        $this->page_construct('fail/index', $meta, $this->data);
	}

	public function add()
	{
		$bc = array(array('link' => base_url(), 'page' => lang('fail')), array('link' => '#', 'page' => lang('add')));
        $meta = array('page_title' => lang('add'), 'bc' => $bc);
        $this->page_construct('fail/add', $meta, $this->data);
	}

	public function edit($id=null){
		$res=$this->fail_model->get('',$id);
		$this->data['rec'] = $res;
		$bc = array(array('link' => base_url(), 'page' => lang('fail')), array('link' => '#', 'page' => lang('edit')));
        $meta = array('page_title' => lang('add'), 'bc' => $bc);
        $this->page_construct('fail/add', $meta, $this->data);
	}



	public function upload($id=null,$file=''){


		
		$config['upload_path']          = "./assets/uploads";
		$config['allowed_types']        = 'gif|jpg|png|jpeg';
		
		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('userfile'))
		{
		    echo( $this->upload->display_errors());
		}
		else
		{
		    $data = array('upload_data' => $this->upload->data());
		  
		}

		if(!isset($data['upload_data']['file_name']) && $file!=''){
			$this->add_record($file,$id);
		}
		else{
			if($file!=''){
				unlink('./assets/uploads/'.$file);
			}
			$this->add_record($data['upload_data']['file_name'],$id);
		}
	}

	public function add_record($filename='',$id=NULL){	
		$this->fail_model->input($filename,$id);
		redirect(base_url('admin/fail'),'auto');
	}

	public function getTable(){
		$this->sma->checkPermissions('index', TRUE);
		$shop=$this->fail_model->get_shop($this->session->userdata('user_id'));
        //$supplier = $this->input->get('supplier') ? $this->input->get('supplier') : NULL;

       
       // $detail_link = anchor('admin/products/view/$1', '<i class="fa fa-file-text-o"></i> ' . lang('product_details'));
        $delete_link = "<a href='#' class='tip po' title='<b>" . $this->lang->line("delete_record") . "</b>' data-content=\"<p>". lang('r_u_sure') . "</p><a class='btn btn-danger'  id='delete' >"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> "
            . lang('delete_product') . "</a>";
        $action = '<div class="text-center"><div class="btn-group text-left">'
            . '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'
            . lang('actions') . ' <span class="caret"></span></button>
        <ul class="dropdown-menu pull-right" role="menu">
            
            <li>
                            <a class="add">
                                <i class="fa fa-plus-circle"></i>'. lang('add_record').'
                            </a>
                        </li>
                       <li>
                            <a class="edit">
                                <i class="fa fa-edit"></i>'. lang("edit_record").'
                            </a>
                        </li>
                        <li>'.
                            /*<a  data-id="./assets/uploads/<?=$value->file_name?>" class="viewmodal" >
                                <i class="fa fa-file-photo-o"></i>'. lang("view_image").'
                            </a>*/
                        '</li>';
        
        $action .= '<li class="divider"></li>
            <li>' . $delete_link . '</li>
            </ul>
        </div></div>';
        $this->load->library('datatables');

        $this->datatables
        ->select ( 'sma_fail.id,sma_fail.file_name as image,sma_users.username,sma_fail.shop,sma_fail.code,sma_fail.type,sma_fail.name,sma_fail.quantity,sma_fail.datetime,sma_fail.comment')
        ->where('sma_fail.shop',$shop[0]['company'])
        ->from('fail')
        ->join('users','users.id=fail.user_name','left');
        $this->datatables->add_column("Actions", $action);
       
        echo $this->datatables->generate();
	}



	public function get_by_id(){
		$id= $this->input->get('id');

		$res= $this->fail_model->get_by_id($id);

		echo json_encode($res);
		
	}

	public function delete(){
		$id=$this->input->get('id');
		if($this->fail_model->delete($id,$this->fail_model->get_file($id))){
            echo lang('event_deleted');
        }
        else{
            echo lang('error_while_deleting');
        }
	}


	public function delete_all(){
		if($this->input->get("cbox_value")!=array()){
			$id=$this->input->get("cbox_value");
			for($count=0;$count<count($id);$count++){
				$this->fail_model->delete($id[$count],$this->fail_model->get_file($id[$count]));
			}
		}
		
	}



}

/* End of file Fail.php */
/* Location: .//C/xampp1/htdocs/atelier/app/controllers/admin/Fail.php */