<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar_model extends CI_Model
{

    public function __construct() {
        parent::__construct();
    }

    public function getEvents($start, $end) {
        $myStore=$this->getUser();
        /*echo "<pre>";
        print_r ($myStore);
        echo "</pre>";*/
        $own=$this->get_shops($this->session->userdata['user_id']);
        $this->db->select('id, title, start, end, description, color');
        if (!$this->data['Admin']){
            $this->db->group_start();
            $this->db->where('shop', $own[0]->company);
            $this->db->or_where('shop', 'all');
            $this->db->group_end();
            $this->db->group_start();
            $this->db->where('group_name', $myStore[0]->name);
            $this->db->or_where('group_name', 'all');
            $this->db->group_end();
        }
        $this->db->where('start >=', $start)->where('start <=', $end);
        if ($this->Settings->restrict_calendar) {
            $this->db->where('user_id', $this->session->userdata('user_id'));
        }

        $q = $this->db->get('calendar');
        
        if ($q->num_rows() > 0) {
            foreach (($q->result_array()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;

    }

    public function getEventByID($id)
    {
        $q = $this->db->get_where('calendar', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function addEvent($data = array()) {
        if ($this->db->insert('calendar', $data)) {
            return true;
        }
        return false;
    }

    public function updateEvent($id, $data = array()) {
        if ($this->db->update('calendar', $data, array('id' => $id))) {
            return true;
        }
        return false;
    }

    public function deleteEvent($id) {
        if ($this->db->delete('calendar', array('id' => $id))) {
            return true;
        }
        return FALSE;
    }

    public function get_shops($id){
        $this->db->select('company');
        if ($id) {
            $this->db->where('id', $id, FALSE);
            //echo($this->db->get_compiled_select());
            $result=$this->db->get('users',1);
            return $result->result();
        }
        else{
            $result=$this->db->get('users');
            return $result->result();
        }
    }

    public function get_groups($id){
        $this->db->select('name');

        if ($id) {
            $this->db->where('id', $id, FALSE);
            //echo($this->db->get_compiled_select());
            $result=$this->db->get('groups',1);
            return $result->result();
        }
        else {
            $result=$this->db->get('groups');
            return $result->result();
        }
    }

    public function getUser(){
        $this->db->where('id', $this->session->userdata('group_id'));
      
        $res= $this->db->get('groups');
        
        return $res->result();
    }
}
