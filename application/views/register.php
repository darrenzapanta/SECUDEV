
   <h1>Register</h1>
   
  <?php echo form_open('verifyregister'); ?>
     <label for="firstname">First Name:</label>
     <input type="text" size="20" id="firstname" name="firstname"/>
    <label for="lastname">Last Name:</label>
     <input type="text" size="20" id="lastname" name="lastname"/>
     <br/>
     <label for="gender">Gender:</label>
     <select id="gender" name="gender">
        <option value = "Male"  <?php echo set_select('gender', 'Male'); ?> >Male</option>
        <option value = "Female"  <?php echo set_select('gender', 'Female'); ?> >Female</option>
      </select>
      <br/>
    <label for="salutation">Salutation:</label>
     <select id="salutation" name="salutation">
        
        <option class="male" value="Mr" <?php echo set_select('salutation', 'Mr'); ?> >Mr</option>
        <option class="male" value= "Sir" <?php echo set_select('salutation', 'Sir'); ?> >Sir</option>
        <option class="male" value= "Senior" <?php echo set_select('salutation', 'Senior'); ?> >Senior</option>
        <option class="male" value= "Count" <?php echo set_select('salutation', 'Count'); ?> >Count</option>
        <option class="female" value= "Miss" <?php echo set_select('salutation', 'Miss'); ?> >Miss</option>
        <option class="female" value= "Ms" <?php echo set_select('salutation', 'Ms'); ?> >Ms</option>
        <option class="female" value= "Mrs" <?php echo set_select('salutation', 'Mrs'); ?> >Mrs</option>
        <option class="female" value= "Madame" <?php echo set_select('salutation', 'Madame'); ?> >Madame</option>
        <option class="female" value= "Majesty" <?php echo set_select('salutation', 'Majesty'); ?> >Majesty</option>
        <option class="female" value= "Seniora" <?php echo set_select('salutation', 'Seniora'); ?> >Seniora</option>
      </select>

    <label for="birthdate">Birthdate:</label>
     <input type="text" id="birthdate" name="birthdate"/>
     <br/>
    <label for="username">Username:</label>
     <input type="text" id="username" name="username"/>
     <br/>
     <label for="password">Password:</label>
     <input type="password" size="20" id="passowrd" name="password"/>

     <br/>
     <br/>
    <p>About Me:</p>
     <textarea NAME="aboutme" id="aboutme" COLS=40 ROWS=4></textarea>
     <br/>
     <?php
     if($this->session->userdata('type') == 'admin'){
        $options = array(
                  'user'  => 'user',
                  'admin'    => 'admin'
       );
        echo form_dropdown('type', $options, 'user');
     }
     ?>
     <br/>
     <input type="submit" value="Register"/>
     <?php echo form_close(); ?>
     
     <?php echo validation_errors(); ?>
 <script>
  $("#gender").change(function(){
    
      var gender = $("#gender").val();
      if (gender == "Male"){
        $("#salutation").val("Mr");
        $(".male").show();
        $(".female").hide();
        $("#gender").val()
      }else if(gender == "Female"){
        $("#salutation").val("Miss");
        $(".female").show();
        $(".male").hide();
      }
      
  });
  $(function() {
    $( "#birthdate" ).datepicker({
      dateFormat: 'yy-mm-dd',
      maxDate: "-19y"
    });
  });
  $("#gender").trigger("change");
 </script>
