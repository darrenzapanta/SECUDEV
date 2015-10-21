<?php

class changepassword extends CI_Controller {
 
 function __construct()
 {

   parent::__construct();
   $this->load->library('session');
   $this->load->helper('url');
 }
 
 function index()
 {
 	if($this->session->userdata('logged_in') == true){
 		include 'user_info_loader.php';
 		$data['pagetitle'] = 'Change Password';

 		$this->load->helper(array('form'));
 		$this->load->view('header', $data);
   		$this->load->view('changepassword');
   		$this->load->view('footer');
 	}else{
 		redirect('welcome','refresh');
 	}

 }

}
 
?>