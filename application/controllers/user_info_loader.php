<?php
 
  $data['firstname'] = $this->session->userdata('firstname');
  $data['lastname'] = $this->session->userdata('lastname');
  $data['gender'] = $this->session->userdata('gender');
  $data['salutation'] = $this->session->userdata('salutation');
  $data['birthdate'] = $this->session->userdata('birthdate');
  $data['username'] = $this->session->userdata('username');
  $data['aboutme'] = $this->session->userdata('aboutme');
  $data['logout'] = session_id();

?>
