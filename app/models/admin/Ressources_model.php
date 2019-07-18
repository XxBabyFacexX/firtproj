<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ressources_model  extends CI_Model {

	/*public function input(){
		$id=$this->input->get('id');
		$data = array(
			'title' => $this->input->get('title'), 
			'link' => $this->input->get('link'),
			);
		if($this->input->post('active')=='yes'){
			$data['active']=1;
		}
		else{
			$data['active']=0;
		}
		if($id){
			echo('here');
			$this->db->where('id', $id);
			if($this->db->update('ressources_links', $data))
			{
				return true;
			}
			return false;
		}else{
			if($this->db->insert('ressources_links', $data)){
				return true;
			}
			return false;
		}	
	}	*/

	public function save($id,$data){
		
		//echo $data['active'];
		if ($data['active']=='yes'){
			$data['active']=1;
		}
		else{
			$data['active']=0;
		}
		if($id!=NULL){
			
			$this->db->where('id', $id);
			if($this->db->update('ressources_links', $data))
			{
				return true;
			}
			return false;
		}else{
			
			if($this->db->insert('ressources_links', $data)){
				return true;
			}
			return false;
		}	
	}

	public function get($seek='',$find=0){
		
		if($find){
			$this->db->where('id', $find);
			$s=$this->db->get('ressources_links',1);
			return $s->result();

		}else{
			$this->db->select('*');
			$this->db->order_by('order', 'asc');
			$this->db->where('active', 1);
			if($seek!="")
			{
				$this->db->group_start();
				$this->db->like('id', $seek);
				$this->db->or_like('title', $seek);
				$this->db->or_like('link', $seek);
				$this->db->group_end();
			}
			$s=$this->db->get('ressources_links');
			return $s->result_array();
		}

	}

	public function get_by_shop(){
		$shop=$this->get_shop_id_by_user()[0]['company'];
		
		$sid=$this->get_shop_id($shop)[0]['id'];
		
		
		$this->db->select('*');
		$this->db->order_by('order', 'asc');
		$this->db->where('active', 1);
		$this->db->where('shop_id', $sid);
		$this->db->or_where('shop_id',0);
		

		$s=$this->db->get('ressources_links');
		return $s->result_array();
	}

	public function get_shop_id_by_user(){
		$this->db->select('company');
		$this->db->where('id', $_SESSION['user_id']);
		$res= $this->db->get('users', 1);
		return $res->result_array();
	}

	public function get_shop_id($company){
		$this->db->select('id');
		$this->db->where('company',$company);
		$this->db->where('group_id',1 );
		$res=$this->db->get('users', 1);
		return $res->result_array();
	}



	public function get_shops(){
		
		$this->db->select('company');
		$res=$this->db->get('users');
		return $res->result_array();
	
	}

	public function delete($id=0){
		$this->db->where('id', $id);

		if($this->db->delete('ressources_links'))
		{
			return true;
		}
		return false;
	}

	public function updateOrder($id,$place){
		$this->db->where('id', $id);
		$data = array('order' => $place, );
		$this->db->update('ressources_links', $data);
	}
}

/* End of file Ressources_model */
/* Location: .//C/xampp1/htdocs/atelier/app/models/admin/Ressources_model */