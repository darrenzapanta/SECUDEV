
   <h1>Edit</h1>
   
  <?php echo form_open('verifyedit'); ?>
     <label for="firstname">First Name:</label>
     <input type="text" size="20" id="firstname" name="firstname" value="<?php echo $firstname; ?>"/>
    <label for="lastname">Last Name:</label>
     <input type="text" size="20" id="lastname" name="lastname" value="<?php echo $lastname; ?>"/>
     <br/>
     <label for="gender">Gender:</label>
     <select id="gender" name="gender" value="<?php echo $gender;?>">
        <option value = "Male"  <?php echo set_select('gender', 'Male'); ?> >Male</option>
        <option value = "Female"  <?php echo set_select('gender', 'Female'); ?> >Female</option>
      </select>
      <br/>
    <label for="salutation">Salutation:</label>
     <select id="salutation" name="salutation" value="<?php echo $salutation; ?>"> 
        
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
     <input type="text" id="birthdate" name="birthdate" value="<?php echo $birthdate; ?>"/>
     <br/>
     
     <br/>
     <br/>
    <p>About Me:</p>
     <textarea NAME="aboutme" id="aboutme" COLS=40 ROWS=4><?php echo $aboutme; ?></textarea>
     <br/>
     <input type="submit" value="Save"/>
     <?php echo form_close(); ?>
     <?php echo validation_errors(); ?>
     <li><?php echo anchor('home', 'Home'); ?></li>
  </div>
</div>
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

