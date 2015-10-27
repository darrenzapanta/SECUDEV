<?php

class managestore extends CI_Controller {
 
 function __construct()
 {

   parent::__construct();
   $this->load->model('item','',TRUE);
   $this->load->library('session');
   $this->load->helper('url');
   $this->load->helper(array('form'));
   $this->load->library('upload');
 }
 
 function index()
 {
 	if($this->session->userdata('logged_in') == true && $this->session->userdata('type') == "admin" ){
 		$this->load->helper(array('form'));
 		$this->load->view('header');
   		$this->load->view('managestore');
   		$this->load->view('footer');
 	}
 }

 function loaditems(){
 	if($this->session->userdata('logged_in') == true && $this->session->userdata('type') == "admin" ){
 		$result = $this->item->getAllItems();
 		if($result !== FALSE){
	 		foreach($result as $row){
	 			    echo "<tr id='".$row->itemid."'>";
	 			    echo "<td class=\"col-lg-4\">";
	 			    echo "<img height=\"200\" width=\"200\" src=\"".$row->imagepath."\"/>";
	 			    echo "</td><td class=\"col-lg-1\">";
	                echo $row->name;
	                echo "</td><td class=\"col-lg-1\">";
	                echo $row->price;
	                echo "</td><td class=\"col-lg-1\">";
	                echo $row->quantity;
	                echo "</td><td class=\"col-lg-3\">";
	                echo $row->description;
	                echo "</td><td class=\"col-lg-2\">";                
	                echo "<button data-id=\"".$row->itemid."\" type=\"button\" class=\"btn btn-danger deletebtn\">Delete</button>";
	                echo "<br>";
	                echo "<button data-id=\"".$row->itemid."\" type=\"button\" class=\"btn btn-primary editbtn\">Save</button>";
	                echo "<br>";
	                echo "<button data-toggle=\"modal\" data-target=\"#uploadModal\" data-id=\"".$row->itemid."\" type=\"button\" class=\"btn btn-default uploadbtn\">Upload Image</button>";
	                echo "</td></tr>";

	 		}
	 	}
 	}
 }

 function edititem($id = null){
 	if($this->session->userdata('logged_in') == true && $this->session->userdata('type') == "admin" ){
 	}
 }

 function deleteitem($id = null){
 	if($this->session->userdata('logged_in') == true && $this->session->userdata('type') == "admin" ){
 		$this->item->deleteitem($id);
 	}
 }

 function uploadimage(){
 	if($this->session->userdata('logged_in') == true && $this->session->userdata('type') == "admin" ){
	    $itemid = $this->input->post("itemid");
	    $config['upload_path']          = './uploads';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 0;
        $config['max_width']            = 0;
        $config['max_height']           = 0;
        $config['file_name']            = $itemid;
        $this->upload->initialize($config);
        
        if ( ! $this->upload->do_upload('userfile'))
        {
                echo $this->upload->display_errors();
        }
        else
        {
        		$itemid = $this->input->post("itemid");
        		 $data = array(
                'imagepath' => base_url().'uploads/'.$this->upload->data('file_name') 
            	);
        		$this->item->edititem($itemid, $data);
                redirect('managestore', 'refresh');
               
        }
 	}

 }


}
 
?>