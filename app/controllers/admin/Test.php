<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends MY_Controller {

	public function index()
	{
		 $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('purchases'), 'page' => lang('purchases')), array('link' => '#', 'page' => lang('add_purchase_by_csv')));
        $meta = array('page_title' => lang('add_purchase_by_csv'), 'bc' => $bc);
        $this->page_construct('test/index', $meta, $this->data);
	}

}

/* End of file Test.php */
/* Location: .//C/xampp/htdocs/atelier/app/controllers/admin/Test.php */