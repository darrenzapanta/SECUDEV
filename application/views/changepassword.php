 
   <?php echo validation_errors(); ?>
   <?php echo form_open('editpassword'); ?>
     <label for="oldpassword">Old Password</label>
     <input type="password" size="20" id="oldpassword" name="oldpassword"/>
     <br/>
     <label for="newpassword">New Password:</label>
     <input type="password" size="20" id="newpassword" name="newpassword"/>
     <br/>
     <input type="submit" value="Save"/>
   </form>