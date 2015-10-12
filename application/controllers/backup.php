<?php

class backup extends CI_Controller {
 
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
   if($this->session->userdata('logged_in') == true && $this->session->userdata('type') == 'admin'){
      $fn = get_filenames(APPPATH.'backup/');
      $data["fn"] = $fn;
      $this->load->view('header');
      $this->load->view('backup', $data);
      $this->load->view('footer');
   }else{
      echo ("Invalid");
   }
}

function backup(){
   if($this->session->userdata('logged_in') == true && $this->session->userdata('type') == 'admin'){
      echo $this->MessageModel->backup();
   }else{
      redirect('welcome', 'refresh');
   }
}

function download($fn = null){
   if($this->session->userdata('logged_in') == true && $this->session->userdata('type') == 'admin'){
      force_download(APPPATH.'backup/'.$fn, NULL);
   }else{
      redirect('welcome', 'refresh');
   }
}
 
}
 
?>