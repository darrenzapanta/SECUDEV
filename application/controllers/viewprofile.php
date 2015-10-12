<?php

class viewProfile extends CI_Controller {
 
 function __construct()
 {
   
   parent::__construct();
   $this->load->helper('url');
   $this->load->library('session');
   $this->load->model('user','',TRUE);
 }
 
function index($username = NULL){
   if($this->session->userdata('logged_in') == true && $username !== NULL){
      $result = $this->user->getUser($username);
      foreach($result as $row){
         $data['firstname'] = $row->firstname;
         $data['lastname'] = $row->lastname;
         $data['gender'] = $row->gender;
         $data['salutation'] = $row->salutation;
         $data['birthdate'] = $row->birthdate;
         $data['username'] = $row->username;
         $data['aboutme'] = $row->aboutme;
      }
      $this->load->view('header');
      $this->load->view('viewProfile', $data);
      $this->load->view('footer');
      }
   }
 
}

 
?>