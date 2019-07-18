<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends MY_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->admin_model('order_model');
    }

	public function index()
	{
		$bc = array(array('link' => base_url(), 'page' => lang('order')), array('link' => '#', 'page' => lang('form')));
        $meta = array('page_title' => lang('order'), 'bc' => $bc);
        $this->page_construct('order/index', $meta, $this->data);
	}

	public function get_customer_details(){
		$res=$this->order_model->get_customer_details();
		echo json_encode($res);
	}

}

/* End of file Order.php */
/* Location: .//C/xampp/htdocs/atelier/app/controllers/admin/Order.php */