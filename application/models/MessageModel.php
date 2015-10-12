<?php
 
class MessageModel extends CI_Model {
  public function __construct() {
    parent::__construct();
    $this->load->helper('file');
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

    public function search($data){
        $this->db->from('message');
        $flag = true;
        foreach($data as $d){
            try{
            if(!isset($d["type"]) || !isset($d["op"]) || !isset($d["value"])){
                return "error1";
            }
            if($d["type"] == "post" && $flag === true){
                if($d["op"] == "or"){
                    $this->db->or_like('post', $d["value"]);
                }elseif ($d["op"] == "and"){
                    $this->db->like('post', $d["value"]);
                }
                $flag = false;
            }elseif($d["type"] == "date"){
                if(!isset($d["dateop"])){
                    return "error2";
                }
                if($d["dateop"] == "lt"){
                    $temp = 'datecreated <';
                }elseif($d["dateop"] == "gt"){
                    $temp = 'datecreated >';
                }elseif($d["dateop"] == "eq"){
                    $temp = 'datecreated =';
                }elseif($d["dateop"] == "lte"){
                    $temp = 'datecreated <=';
                }elseif($d["dateop"] == "gte"){
                    $temp = 'datecreated >=';
                }
                $temp2 = new DateTime($d["value"]);
                $dt = $temp2->format('Y-m-d H:i:s');
                if($d["op"] == "or"){
                    if($d["dateop"] == "bt"){
                        if(!isset($d["value2"])){
                            return "error3";
                        }
                         $temp3 = new DateTime($d["value2"]);
                         $dt2 = $temp3->format('Y-m-d H:i:s');
                         $this->db->or_where("datecreated between '".$dt."' and '".$dt2."'");
                    }elseif($d["dateop"] == "lt" || $d["dateop"] == "gt" || $d["dateop"] == "eq" || $d["dateop"] == "lte" || $d["dateop"] == "gte"){
                        $this->db->or_where($temp, $dt);
                    }
                }elseif ($d["op"] == "and"){

                    if($d["dateop"] == "bt"){
                        if(!isset($d["value2"])){
                            return "error4";
                        }
                         $temp3 = new DateTime($d["value2"]);
                         $dt2 = $temp3->format('Y-m-d H:i:s');
                         $this->db->where("datecreated between '".$dt."' and '".$dt2."'");
                    }elseif($d["dateop"] == "lt" || $d["dateop"] == "gt" || $d["dateop"] == "eq" || $d["dateop"] == "lte" || $d["dateop"] == "gte"){
                        $this->db->where($temp, $dt);
                    }
                }
            }elseif($d["type"] == "user"){
                if($d["op"] == "or"){
                    $this->db->or_where('username', $d["value"]);
                }elseif ($d["op"] == "and"){
                    $this->db->where('message.username', $d["value"]);
                }
            }
        }catch(Exception $e){
            
        }
        }
        //echo $this->db->get_compiled_select();
        //return true;
        $this->db->join('users', 'users.username = message.username');
        $query = $this->db->get();
        $username = $this->session->userdata('username');
        $type = $this->session->userdata('type');
        if ($query->num_rows() > 0){
            foreach ($query->result() as $row){
                echo "<tr id='".$row->postid."'><td class=\"col-lg-2\">";

                echo anchor('viewProfile\\index\\'.$row->username,$row->firstname);

                echo "&nbsp(";

                echo anchor('viewProfile\\index\\'.$row->username,$row->username);
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

            }
    }else{
        echo "<p style=\"color: red\">No post found.</p>";
    }

    }

    public function backup(){
        $this->load->dbutil();
        $temp3 = new DateTime();
        $dt = $temp3->format('Y-m-d-H-i-s');
        $query = $this->db->query("SELECT * FROM message");

            
        if ( ! write_file('./application/backup/'.$dt.".csv", $this->dbutil->csv_from_result($query)))
        {
                echo 'Unable to write';
        }
        else
        {
                echo 'File written!';
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

                echo anchor('viewProfile\\index\\'.$row->username,$row->firstname);

                echo "&nbsp(";
      
                echo anchor('viewProfile\\index\\'.$row->username,$row->username);
                echo ")";
      
                echo "<br>";
                echo "<small>Date Joined:<br><strong>".$row->datejoined;
                echo "</strong></small></td><td td class=\"col-lg-7\"><small>Posted:<strong>";
                echo $row->datecreated;
                echo "</strong></small><br><span class=\"postmessage\">";
                echo ($row->post);
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
