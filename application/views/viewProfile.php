<div class="jumbotron">
      <?php
        echo "<h6 style=\"display: inline-block\"><strong>Salutation: </strong> </h6>  ";
        echo $salutation;
        echo "<br/>";
        echo "<h6 style=\"display: inline-block\"><strong>First Name:</strong></h6>  ";
        echo $firstname;
        echo "<br/>";
        echo "<h6 style=\"display: inline-block\"><strong>Last Name:</strong>  </h6>  ";
        echo $lastname;
        echo "<br/>";
        echo "<h6 style=\"display: inline-block\"><strong>Gender:</strong>  </h6>  ";
        echo $gender;
        echo "<br/>";
        echo "<h6 style=\"display: inline-block\"><strong>Birthdate: </strong> </h6>  ";
        echo $birthdate;
        echo "<br/>";
        echo "<h6 style=\"display: inline-block\"><strong>About Me: </strong> </h6>  ";
        echo $aboutme;
        echo "<br/>";
        echo "<h6 style=\"display: inline-block\"><strong>User Name: </strong> </h6>  ";
        echo $username;
        echo "<br/>";

      ?>
            <li><?php echo anchor('home', 'Home'); ?></li>
</div>