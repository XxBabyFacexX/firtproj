<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fail_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

	public function input($filename,$id){

		
		$comp=$this->get_user_name();
		$data = array(
			'user_name' => $comp[0]->id,
			'group_id' => $this->session->userdata['group_id'],
			'code' => $this->input->post('code'),
			'type' => $this->input->post('type'),
			'name' => $this->input->post('name'),
			'quantity' => $this->input->post('quantity'),
			'file_name' =>$filename,
			'comment' => strip_tags($this->input->post('comments')),
			'datetime' => date('Y-m-d H:i:s', time()),
			'shop' => $comp['0']->company
			 );

		if($id){
			$this->db->where('id', $id);
			$this->db->update('fail', $data);
		}else{
			
			$this->db->insert('fail', $data);
		}	
	}	

	public function get_by_id($id){
		$this->db->where('id', $id);
		$res = $this->db->get('fail', 1);
		return $res->result_array();
	}

//para mawara
	public function get($seek,$find){
		
		$comp=$this->get_user_name();
		if($find){
			$this->db->where('id', $find);
			$this->db->where('shop', $comp['0']->company);
			$s=$this->db->get('fail');
			return $s->result();

		}else{
	
			
			$this->db->select('*');
			$this->db->where('shop', $comp['0']->company);
			if($seek!="")
			{
				$this->db->group_start();
				$this->db->like('user_name', $seek);
				$this->db->or_like('code', $seek);
				$this->db->or_like('type', $seek);
				$this->db->or_like('name', $seek);
				$this->db->or_like('quantity', $seek);
				$this->db->or_like('datetime', $seek);
				// $this->db->or_like('comment', $seek);
				// $this->db->or_like('file_name', $seek);
				$this->db->group_end();
			}
			
			$s=$this->db->get('fail');
			return $s->result();
		}

	}

	public function delete($id,$file){
		if($file!=''){
			unlink('./assets/uploads/'.$file);
		}
		$this->db->where('id', $id);
		if($this->db->delete('fail')){
			return true;
		}
		return false;
	}

	public function get_user_name(){
		$this->db->where('id', $this->session->userdata('user_id'));
		$res=$this->db->get('users');
		return $res->result();
	}
	public function get_shop($id)
	{	
		$this->db->select('company');
		$this->db->where('id', $id);
		$res = $this->db->get('users', 1);
		return  $res->result_array();
	}
	public function get_file($id){
		$this->db->where('id', $id);
		$res=$this->db->get('fail');
		return $res->result()[0]->file_name;
	}

}

/* End of file Fail_model.php */
/* Location: .//C/xampp/htdocs/atelier/app/models/admin/Fail_model.php */