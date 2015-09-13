<?php

class verifyregister extends CI_Controller {
 
 function __construct()
 {
   parent::__construct();
   $this->load->model('user','',TRUE);
   $this->load->helper('url');
   $this->load->library('session');
 }
 
 function index()
 {

  $this->load->library('form_validation');
  $this->form_validation->set_rules('firstname', 'First Name', 'required|max_length[50]|callback_namecheck');
  $this->form_validation->set_rules('lastname', 'Last Name', 'required|max_length[50]|callback_namecheck');
  $this->form_validation->set_rules('gender', 'Gender', 'required|callback_gendercheck');
  $this->form_validation->set_rules('salutation', 'Salutation', 'required|callback_salutationcheck');
  $this->form_validation->set_rules('birthdate', 'Birthdate', 'required|callback_birthdatecheck');
  $this->form_validation->set_rules('username', 'Username', 'trim|required|max_length[50]|callback_usernamecheck');
  $this->form_validation->set_rules('password', 'Password', 'trim|required');
  $this->form_validation->set_rules('aboutme', 'About me', 'required');
  if($this->session->userdata('type') == 'admin'){
    $this->form_validation->set_rules('type', 'type', 'required|callback_typecheck');
  }
 
   if($this->form_validation->run() == FALSE)
   {
     $this->load->view('header');
     $this->load->view('register');
     $this->load->view('footer');
   }
   else
   {
      if($this->session->userdata('type') == 'admin'){
        $t = $this->input->post('type');
      }else{
        $t = 'user';
      }
     $data = array(
      'username' => $this->input->post('username'),
      'password' => MD5($this->input->post('password')),
      'firstname' => $this->input->post('firstname'),
      'lastname' => $this->input->post('lastname'),
      'gender' => $this->input->post('gender'),
      'salutation' => $this->input->post('salutation'),
      'birthdate' => $this->input->post('birthdate'),
      'aboutme' => $this->input->post('aboutme'),
      'type' => $t,
      'datejoined' => date('Y-m-d')
      );
     $this->user->register($data);
     redirect('welcome', 'refresh');
   }
 
 }

 function typecheck($type){
  if($type != 'user' && $type != 'admin'){
    $this->form_validation->set_message('typecheck', 'Type should be admin or user only');
    return FALSE;
  }else{
    return true;
  }
 }

 function usernamecheck($username){
    if (preg_match('/[^a-zA-Z0-9_]+/', $username))
  {
    $this->form_validation->set_message('usernamecheck', 'The %s field can not contain special characters other than underscore');
    return FALSE;
  }
  else
  {
    if($this->checkdatabase($username)){
        $this->form_validation->set_message('usernamecheck', 'Invalid username. Duplicate found');
        return FALSE;
    }else{
      return true;
      }
  }
 }

 function birthdatecheck($b){

  try{
    if(!preg_match('/^(19|20)\d\d[-](0[1-9]|1[012])[-](0[1-9]|[12][0-9]|3[01])$/', $b)){
      $this->form_validation->set_message('birthdatecheck', 'Please enter a valid date');
      return false;
    }
     $d1 = new DateTime();
    $d2 = new DateTime($b);
    $diff = $d2->diff($d1);
    $years = $diff->y;
    if($years < 19){
      $this->form_validation->set_message('birthdatecheck', 'You must be above 18 years old to hack this.');
      return false;
    }else{
      return true;
    }
  }catch(exception $e){
     $this->form_validation->set_message('birthdatecheck', 'Please enter a valid date.');
      return false;
  }


 }
 function salutationcheck($salutation){
  $gender = $_POST["gender"];
  if($gender == "Male"){
    if($salutation != "Mr" && $salutation != "Sir" && $salutation != "Senior" && $salutation != "Count"){
      $this->form_validation->set_message('salutationcheck', 'Nice try. Please enter a valid salutation in %s field.');
      return false;
    }
    else{
      return true;
    }
  }elseif($gender == "Female"){
    if($salutation != "Miss" && $salutation != "Ms" && $salutation != "Mrs" && $salutation != "Madame" && $salutation != "Seniora" && $salutation != "Majesty"){
      $this->form_validation->set_message('salutationcheck', 'Nice try. Please enter a valid salutation in %s field.');
      return false;
    }
    else{
      return true;
    }
  }
 }
 function gendercheck($gender){

  if($gender != "Male" && $gender != "Female"){
    $this->form_validation->set_message('gendercheck', 'Please don\'t try to hack my website. The %s field should only be Male or Female');
    return FALSE;
  }else{
    return TRUE;
  }
 }

 function namecheck($name){
  if (preg_match('/[^a-zA-Z0-9 ]+/', $name))
  {
    $this->form_validation->set_message('namecheck', 'The %s field can not contain special characters');
    return FALSE;
  }
  else
  {
    return true;
  }

 }
 
 function checkdatabase($username)
 {
   return $this->user->checkduplicate($username);
 }
}
?>