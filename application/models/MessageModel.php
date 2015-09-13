<?php
 
class MessageModel extends CI_Model {
  public function __construct() {
    parent::__construct();

    $this->load->library('session');

  }
    public function record_count(){
        return $this->db->count_all("message");
    }
    public function addMessage($message){
        $username = $this->session->userdata('username');
        $date = date('Y-m-d H:i:s');
        $Addarticle = $message;
        $data = array(
            'username' => $username,
            'post'=>$Addarticle,
            'datecreated'=>$date
            );
        $this-> db ->insert('message', $data);
    }

    public function editMessage($message, $postid){
        $username = $this->session->userdata('username');
        $type = $this->session->userdata('type');
        $match = false;
        if($type != 'admin'){
            $this->db->from('message');
            $this->db->where('postid', $postid);
            $query =  $this->db->get();
            foreach($query->result() as $row){
                if($row->username == $username){
                    $match = true;
                    break;
                }
            }
        }
        $data = array(
                'post' => $message,
                'lastedit' => date('Y-m-d H:i:s')
            );
        if($match || $type == 'admin'){
            $this->db->where('postid', $postid);
            $this->db->update('message', $data); 
        }
        if ($this->db->affected_rows() > 0) {
            return true;
        }else {
            return false;
        }
    }
     
    public function loadMessage($limit, $start){
        $this->db->from('message');
        $this->db->join('users', 'users.username = message.username');
        $this->db->order_by("datecreated","desc");
        $this->db->limit($limit, $start);
        $query =  $this->db->get();
        $username = $this->session->userdata('username');
        $type = $this->session->userdata('type');
        if ($query->num_rows() > 0){
            foreach ($query->result() as $row){
                echo "<tr id='".$row->postid."'><td class=\"col-lg-2\">";

                echo anchor('viewProfile\\'.$row->username,$row->firstname);

                echo "&nbsp(";
      
                echo anchor('viewProfile\\'.$row->username,$row->username);
                echo ")";
      
                echo "<br>";
                echo "<small>Date Joined:<br><strong>".$row->datejoined;
                echo "</strong></small></td><td td class=\"col-lg-7\"><small>Posted:<strong>";
                echo $row->datecreated;
                echo "</strong></small><br><span class=\"postmessage\">";
                echo html_entity_decode($row->post);
                echo "</span>";
                if($row->lastedit != ""){
                    echo "<br>";
                    echo "<small>Last Edit:<strong>".$row->lastedit;
                    echo "</strong></small>";
                }
                echo "<td td class=\"col-lg-2\">";
                if($username == $row->username || $type == 'admin'){
                    echo "<button data-toggle=\"modal\" data-target=\"#editModal\" data-id=\"".$row->postid."\" type=\"button\" class=\"btn btn-primary editbtn\">Edit</button>&nbsp";
                    echo "<button data-id=\"".$row->postid."\" type=\"button\" class=\"btn btn-danger deletebtn\">Delete</button>";
                    
                }
                echo "</td>";
            }
        }else{
                return false;
            }
    }
    public function deleteMessage($id){
        $username = $this->session->userdata('username');
        $type = $this->session->userdata('type');
        $match = false;
        if($type != 'admin'){
            $this->db->from('message');
            $this->db->where('postid', $id);
            $query =  $this->db->get();
            foreach($query->result() as $row){
                if($row->username == $username){
                    $match = true;
                    break;
                }
            }
        }
        if($match || $type == 'admin'){
            $this->db->where('postid', $id);
            $this->db->delete('message'); 
        }
        if ($this->db->affected_rows() > 0) {
            return true;
        }else {
            return false;
        }
    }



    
     
}
?>
