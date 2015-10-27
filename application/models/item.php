<?php
Class item extends CI_Model
{
  public function __construct() {
    parent::__construct();


  }

  function addItem($data){
  	$this-> db ->insert('items', $data);
  }

  function getAllItems(){
	$this->db->from('items');
    $query =  $this->db->get();
    if ($query->num_rows() > 0){
    	return $query->result();
    }else
    	return false;
  }

  function deleteItem($id){
    $type = $this->session->userdata('type');
    if($type == 'admin'){
        $this->db->where('itemid', $id);
        $this->db->delete('items'); 
    }
    if ($this->db->affected_rows() > 0) {
        return true;
    }else {
        return false;
    }
  }

  function editItem($id, $data){ 
    $type = $this->session->userdata('type');
    if($type == 'admin'){
        $this->db->where('itemid', $id);
        $this->db->update('items', $data); 
    }
    if ($this->db->affected_rows() > 0) {
        return true;
    }else {
        return false;
    }
  }
 }
 ?>