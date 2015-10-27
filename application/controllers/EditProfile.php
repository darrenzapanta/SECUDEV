<?php

class EditProfile extends CI_Controller {
 
 function __construct()
 {
   
   parent::__construct();
   $this->load->helper('url');
   $this->load->library('session');
 }
 
 function index()
 {
   if($this->session->userdata('logged_in') == true){
      $data['firstname'] = $this->session->userdata('firstname');
      $data['lastname'] = $this->session->userdata('lastname');
      $data['gender'] = $this->session->userdata('gender');
      $data['salutation'] = $this->session->userdata('salutation');
      $data['birthdate'] = $this->session->userdata('birthdate');
      $data['username'] = $this->session->userdata('username');
      $data['aboutme'] = $this->session->userdata('aboutme');
      $this->load->helper(array('form'));
      $this->load->view('header');
      $this->load->view('editprofile', $data);
      $this->load->view('footer');
   }else{
      redirect('welcome', 'refresh');
   }
}
 
}
 
?>