<?php
    
    if($this->session->userdata('type') == 'admin'){
      echo '<br><b>Admin Menu</b><hr style="margin:5px">';
      echo "<li>".anchor('register', 'Register')."</li>";  
      echo "<li>".anchor('backup', 'Back up')."</li>";
    }
  ?>