<?php

class Register extends CI_Controller {
 
 function __construct()
 {
 	
   parent::__construct();
   $this->load->helper('url');
   $this->load->library('session');
 }
 
 function index()
 {
 	if($this->session->userdata('logged_in') == true && $this->session->userdata('type') != 'admin' ){
 		redirect('home','refresh');
 	}else{

 		if($this->session->userdata('logged_in'))
 			include 'user_info_loader.php';

 		$data['pagetitle'] = "Register";

	   $this->load->helper(array('form'));
	   $this->load->view('header', $data);
	   $this->load->view('register', $data);
	   $this->load->view('footer');
	}
}
 
}
 
?>