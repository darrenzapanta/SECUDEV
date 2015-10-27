<?php

class donate extends CI_Controller {
 
 function __construct()
 {
   
   parent::__construct();
   $this->load->helper('url');
   $this->load->library('session');
   $this->load->model('MessageModel','',TRUE);
   $this->load->helper('file');
   $this->load->helper('download');
 }
 
 function index()
 {
   if($this->session->userdata('logged_in') == true){


      $data['pagetitle'] = 'Backup';

      $this->load->view('header', $data);
      $this->load->view('donate', $data);
      $this->load->view('footer');
   }else{
      echo ("Invalid");
   }
}

}
 
?>