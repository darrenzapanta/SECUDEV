<?php
Class User extends CI_Model
{
  public function __construct() {
    parent::__construct();

    $this->load->library('session');

  }
 function login($username, $password)
 {
   $this -> db -> from('users');
   $this -> db -> where('username', $username);
   $this -> db -> where('password', MD5($password));
   $this -> db -> limit(1);
 
   $query = $this -> db -> get();
 
   if($query -> num_rows() == 1)
   {
    foreach($query->result() as $rows)
       {
        $newdata = array(
          'username'  => $rows->username,
          'firstname'  => $rows->firstname,
          'lastname'    => $rows->lastname,
          'gender'    => $rows->gender,
          'salutation'    => $rows->salutation,
          'birthdate'    => $rows->birthdate,
          'aboutme'    => $rows->aboutme,
          'type'    => $rows->type,
          'logged_in' => true
        );
       }
       $this->session->set_userdata($newdata);
       return true;
   }
   else
   {
     return false;
   }
 }

 function getUser($username){
  $this -> db -> from('users');
   $this -> db -> where('username', $username);
   $this -> db -> limit(1);
 
   $query = $this -> db -> get();
 
   if($query -> num_rows() == 1)
   {
      return $query->result();
   }
   else
   {
     return false;
   }

 }
 function register($data){
  $this->db->insert('users', $data);
  if ($this->db->affected_rows() > 0) {
  return true;
  }else {
  return false;
  }
 }

 function editprofile($data){
  $username = $this->session->userdata('username');
  $this->db->where('username', $username);
  $this->db->update('users', $data);
  if ($this->db->affected_rows() > 0) {
      $this->session->set_userdata('firstname', $data['firstname']);
      $this->session->set_userdata('lastname', $data['lastname']);
      $this->session->set_userdata('gender', $data['gender']);
      $this->session->set_userdata('salutation', $data['salutation']);
      $this->session->set_userdata('birthdate', $data['birthdate']);
      $this->session->set_userdata('aboutme', $data['aboutme']);
      return true;
  }else {
      return false;
  }
 }

 function checkduplicate($username){
   $this -> db -> select('id, username');
   $this -> db -> from('users');
   $this -> db -> where('username', $username);
   $this -> db -> limit(1);
   $query = $this -> db -> get();
 
   if($query -> num_rows() == 1)
   {
     return true;
   }
   else
   {
     return false;
   }

 }

 function checkpassword($password){
   $username = $this->session->userdata('username');
   $this -> db -> select('password');
   $this -> db -> from('users');
   $this -> db -> where('username', $username);
   $this -> db -> limit(1);
   $query = $this -> db -> get();
   foreach($query->result() as $row){
      if(MD5($password) == $row->password)
        return true;
      else
        return false;
   }
 }

 function changepassword($data){
  $username = $this->session->userdata('username');
  $this->db->where('username', $username);
  $this->db->update('users', $data);
  if ($this->db->affected_rows() > 0) {
    return true;
  }else {
    return false;
  }
 }
}
?>