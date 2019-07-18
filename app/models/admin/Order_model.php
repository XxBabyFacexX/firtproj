<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {

	public function get_customer_details(){
		
			$this->db->where('id', $_SESSION['user_id']);
			$res=$this->db->get('users', 1);
			
			return $res->result_array();

	}

}

/* End of file Order_model.php */
/* Location: .//C/xampp/htdocs/atelier/app/models/admin/Order_model.php */