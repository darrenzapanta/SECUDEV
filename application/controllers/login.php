<?php

class Login extends CI_Controller {
 
 function __construct()
 {

   parent::__construct();
   $this->load->library('session');
   $this->load->helper('url');
 }
 
 function index()
 {
 	if($this->session->userdata('logged_in') == true){
 		redirect('home','refresh');
 	}else{
 		$this->load->helper(array('form'));
 		$this->load->view('header');
   		$this->load->view('login');
   		$this->load->view('footer');
 	}

 }

}
 
?>