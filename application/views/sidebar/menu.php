<li><?php echo '<br><b>Navigation Menu</b><hr style="margin:5px">';?></li>
<li><?php echo anchor('home', 'Home'); ?></li>
<li><?php echo anchor('editprofile', 'Edit Profile'); ?></li>
<li><?php echo anchor('changepassword', 'Change Password'); ?></li>
<li><?php echo anchor('search', 'Search Post'); ?></li>
<li><?php echo anchor("home/logout/".$logout, 'Logout'); ?></li>