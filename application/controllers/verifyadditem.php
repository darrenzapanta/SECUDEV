<?php

class verifyadditem extends CI_Controller {
 
 function __construct()
 {
   parent::__construct();
   $this->load->model('item','',TRUE);
   $this->load->helper('url');
   $this->load->library('session');
 }
 
 function index()
 {
   //This method will have the credentials validation
   $this->load->library('form_validation');
 
   $this->form_validation->set_rules('name', 'Name', 'trim|required');
   $this->form_validation->set_rules('price', 'Price', 'trim');
   $this->form_validation->set_rules('quantity', 'Quantity', 'trim');
   $this->form_validation->set_rules('description', 'Description', 'trim');

 
   if($this->form_validation->run() == FALSE)
   {

     $this->load->view('header');
     $this->load->view('managestore');
     $this->load->view('footer');

   }
   else
   {
     $this->load->helper('security');
     $data = array(
      'name' => $this->input->post('name', TRUE),
      'price' => $this->input->post('price', TRUE),
      'quantity' => $this->input->post('quantity', TRUE),
      'description' => $this->input->post('description', TRUE)
      );
    $this->item->addItem($data);
    redirect('managestore', 'refresh');

   }
 
 }
 
}
?>