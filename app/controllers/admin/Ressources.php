<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ressources extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->admin_model('ressources_model');
		$this->load->library('form_validation');
	}
	//calling the views
	public function index()
	{
		$bc = array(array('link' => base_url(), 'page' => lang('ressources')), array('link' => '#', 'page' => lang('ressources')));
        $meta = array('page_title' => lang('manage_links'), 'bc' => $bc);
       	$this->data['shops']=$this->get_shops();
        
		$this->page_construct('ressources/index', $meta, $this->data);

	}


	public function add($id=0){
		$bc = array(array('link' => base_url(), 'page' => lang('ressources')), array('link' => '#', 'page' => lang('add')));
        $meta = array('page_title' => lang('add_links'), 'bc' => $bc);
		$this->page_construct('ressources/add', $meta, $this->data);
	}

	

	public function edit($id=NULL){
		$res=$this->ressources_model->get('',$id);
		$this->data['rec'] = $res;
		$bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('fail')));
        $meta = array('page_title' => lang('add'), 'bc' => $bc);
        $this->page_construct('ressources/add', $meta, $this->data);
	}

	//manipulation functions

	public function insert($id=NULL){

		$id=$this->input->get('id');
		$data=array();
		if ($this->data['Admin']) {
			$shop=null;
			if ($this->input->get('shop')=='all') {
				$shop=0;
			}
			else{
				$shop=$this->ressources_model->get_shop_id($this->input->get('shop'))[0]['id'];
			}
		 		$data = array(
				'title' =>$this->input->get('title'),
				'link' =>$this->input->get('link'),
				'active' =>$this->input->get('active'),
				'shop_id'=>$shop
				);
       	}
       	else{
       		$shop=$this->ressources_model->get_shop_id_by_user()[0]['company'];
		
			$sid=$this->ressources_model->get_shop_id($shop)[0]['id'];
			$data = array(
				'title' =>$this->input->get('title'),
				'link' =>$this->input->get('link'),
				'active' =>$this->input->get('active'),
				'shop_id'=>$sid
				);
			
			
       	}

		if ($this->ressources_model->save($id,$data)){
			$res = array('error' => 0, 'msg' => lang('event_added'));
            echo json_encode($res);
		}else{
			$res = array('error' => 1, 'msg' => lang('action_failed'));
            echo json_encode($res);
		}
	}

	public function get(){
		$res=$this->ressources_model->get('',$this->input->get('id'));
		echo json_encode($res);
	}
	public function get_by_shop(){
		$res=$this->ressources_model->get_by_shop();
		echo json_encode($res);
	}

	public function sort(){
		$id = $this->input->get('idlist');
		$count=1;
		foreach ($id as $key => $value) {
			$this->ressources_model->updateOrder($value,$count);
			$count+=1;
		}
	}

	public function get_shops($id=NULL){
		$res=$this->ressources_model->get_shops($id);
		return $res;
	}


	public function delete(){
		if($this->ressources_model->delete($this->input->get('id'))){
            echo lang('event_deleted');
        }
        else{
            echo lang('error_while_deleting');
        }
		/*$res=$this->ressources_model->delete($id);
		$sus=true;
		echo $sus;*/
	}

	/*public function get_nav(){
		$data['dn'] = $this->ressources_model->get();
		//echo $this->load->view('default/admin/views/ressources/resnav', $dn);
	}*/

	public function delete_all(){
		if($this->input->get("cbox_value")!=array()){
			$id=$this->input->get("cbox_value");
			for($count=0;$count<count($id);$count++){
				$this->ressources_model->delete($id[$count]);

				echo $id[$count];
			}
		}
	}

	public function getTable(){
		$this->sma->checkPermissions('index', TRUE);
		$shop=$this->ressources_model->get_shop_id_by_user()[0]['company'];
		
		$sid=$this->ressources_model->get_shop_id($shop)[0]['id'];
        //$supplier = $this->input->get('supplier') ? $this->input->get('supplier') : NULL;

       
       // $detail_link = anchor('admin/products/view/$1', '<i class="fa fa-file-text-o"></i> ' . lang('product_details'));
        $delete_link = "<a href='#' class='tip po' title='<b>" . $this->lang->line("delete_event") . "</b>' data-content=\"<p>". lang('r_u_sure') . "</p><a class='btn btn-danger  delete' >"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> "
            . lang('delete_event') . "</a>";
        $action = '<div class="text-center"><div class="btn-group text-left">'
            . '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'
            . lang('actions') . ' <span class="caret"></span></button>
        <ul class="dropdown-menu pull-right" role="menu">
            
            <li>
                            <a href="'.admin_url('ressources/add').'">
                                <i class="fa fa-plus-circle"></i>'. lang('add_record').'
                            </a>
                        </li>
                       <li>
                            <a class="edit">
                                <i class="fa fa-edit"></i>'. lang("edit_record").'
                            </a>
                        </li>';
        
        $action .= '<li class="divider"></li>
            <li>' . $delete_link . '</li>
            </ul>
        </div></div>';
        $this->load->library('datatables');

        $this->datatables->select ('id, title, link ,active')
        ->where('shop_id',$sid)
        ->or_where('shop_id',0)
        ->from('ressources_links');
        $this->datatables->add_column("Actions", $action);
       
        echo $this->datatables->generate();
	}

}

/* End of file ressources.php 
/* Location: .//C/xampp1/htdocs/atelier/app/controllers/admin/ressources.php */