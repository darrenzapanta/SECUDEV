<?php

class Home extends CI_Controller {
 
 function __construct()
 {
 	
   parent::__construct();
   $this->load->library('session');
   $this->load->helper('url');
   $this->load->model('MessageModel','',TRUE);
   $this->load->library("pagination");
   //$this->load->model('htmlfilter');
   //$this->load->model('library\HTMLPurifierauto');
 }
 
 function index($page=0)
 {
   if($this->session->userdata('logged_in') == true){
   	$data['firstname'] = $this->session->userdata('firstname');
   	$data['lastname'] = $this->session->userdata('lastname');
   	$data['gender'] = $this->session->userdata('gender');
   	$data['salutation'] = $this->session->userdata('salutation');
   	$data['birthdate'] = $this->session->userdata('birthdate');
   	$data['username'] = $this->session->userdata('username');
   	$data['aboutme'] = $this->session->userdata('aboutme');

      $config = array();
     $config["base_url"] = site_url() . "/home/index/";
     $config["total_rows"] = $this->MessageModel->record_count();
     $config["per_page"] = 10;
     $config["uri_segment"] = 3;
     $choice = $config["total_rows"] / $config["per_page"];
     $data['num'] = ceil($choice);
     $config['attributes'] = array('class' => 'pageanchors');

     $this->pagination->initialize($config);

      $this->pagination->initialize($config);
      if($this->uri->segment(2)){
      $page = ($this->uri->segment(3)) ;
      }
      else{
      $page = 1;
      }
     //$data["results"] = $this->loadMessage($config["per_page"], $page);
     $data["links"] = $this->pagination->create_links();

      $this->load->view('header');
      $this->load->view('home', $data);
      $this->load->view('footer');

   }else{
   	redirect('welcome', 'refresh');
   }
 }
function logout(){
	$this->session->sess_destroy();
	redirect('welcome', 'refresh');
}

function postmessage(){
   require APPPATH . 'third_party\Htmlawed.php';
   if($this->session->userdata('logged_in') == true){
      //$message = htmlentities($this->input->post('message'));
      $message = html_entity_decode($this->input->post('d'));

      //$message = $this->security->xss_clean($message);
      $config = array('safe'=>1);
      $ms = Htmlawed::filter($message, ['safe' => 1]);
      //$clean_html = html_purify($message);
      //echo $ms;
      $this->MessageModel->addMessage($ms);
   }
}

function loadmessage($start){
   $limit = 10;
   if($this->session->userdata('logged_in') == true){
      $this->MessageModel->loadMessage($limit, $start*$limit);
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