<?php

class search extends CI_Controller {
 
 function __construct()
 {
   
   parent::__construct();
   $this->load->helper('url');
   $this->load->library('session');
   $this->load->model('MessageModel','',TRUE);
 }
 
 function index()
 {
   if($this->session->userdata('logged_in') == true){
      $this->load->view('header');
      $this->load->view('search');
      $this->load->view('footer');
   }else{
      redirect('welcome', 'refresh');
   }
}

function basicsearch(){
   if($this->session->userdata('logged_in') == true){
      $d = $this->input->post('d');
      $data = json_decode($d, true);
      echo $this->MessageModel->search($data);
   }else{
      redirect('welcome', 'refresh');
   }
}

function advancedsearch(){
   if($this->session->userdata('logged_in') == true){
      $d = $this->input->post('d');
      $data = json_decode($d, true);

      echo $this->MessageModel->search($data);
   }else{
      redirect('welcome', 'refresh');
   }
}

function deletemessage(){
   if($this->session->userdata('logged_in') == true){
      $id = $this->input->post('id');
      $this->MessageModel->deleteMessage($id);
   }
}

function editmessage(){
   if($this->session->userdata('logged_in') == true){
      require APPPATH . 'third_party\Htmlawed.php';
      $postid = $this->input->post('id');
      $message = html_entity_decode($this->input->post('message'));
      //$message = $this->security->xss_clean($message);
      $ms = Htmlawed::filter($message, ['safe' => 1]);
      //$clean_html = html_purify($message);
     //echo $ms;
      $this->MessageModel->editMessage($ms,$postid);
   }
}
 
}
 
?>