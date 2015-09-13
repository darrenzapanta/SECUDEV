<?php

class editpassword extends CI_Controller {
 
 function __construct()
 {
   parent::__construct();
   $this->load->model('user','',TRUE);
   $this->load->helper('url');
 }
 
 function index()
 {
   //This method will have the credentials validation
   $this->load->library('form_validation');
 
   $this->form_validation->set_rules('oldpassword', 'Old password', 'trim|required|callback_check_database');
   $this->form_validation->set_rules('newpassword', 'New password', 'trim|required');
 
   if($this->form_validation->run() == FALSE)
   {
     //Field validation failed.  User redirected to login page
    $this->load->view('header');
     $this->load->view('changepassword');
     $this->load->view('footer');
   }
   else
   {
    $data = array(
      'password' => MD5($this->input->post('newpassword'))
      );
    if($this->user->changepassword($data) == true){
     redirect('home', 'refresh');
    }else{
      $this->form_validation->set_message('Unable to change password.');
      $this->load->view('header');
     $this->load->view('changepassword');
     $this->load->view('footer');
    }
   }
 
 }
 
 function check_database($password)
 {
   $result = $this->user->checkpassword($password);
   if($result)
   {
     return TRUE;
   }
   else
   {
     $this->form_validation->set_message('check_database', 'Old password doesn\'t match');
     return false;
   }
 }
}
?>