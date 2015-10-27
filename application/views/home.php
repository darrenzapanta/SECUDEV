<script>
tinymce.init({
    extended_valid_elements : "+*[*]",
    selector: "textarea",
    plugins: "image"
    
 });
  
</script>
<h1>HOME</h1>

<div class="row">
    <div class="col-lg-2">
       

      
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

        if($this->session->userdata('type') == 'admin'){
          echo "<li>".anchor('register', 'Register')."</li>";  
          echo "<li>".anchor('backup', 'Back up')."</li>";
          echo "<li>".anchor('managestore', 'Manage Store')."</li>";
        }
      ?>
      <li><?php echo anchor('editprofile', 'Edit Profile'); ?></li>
      <li><?php echo anchor('changepassword', 'Change Password'); ?></li>
      <li><?php echo anchor('search', 'Search Post'); ?></li>
      <li><?php echo anchor("home/logout/".$logout, 'Logout'); ?></li>
      <li><?php echo anchor("donate", 'Donate'); ?></li>
    </div>
    <div class="col-lg-10">
        <div class="table-reponsive" style="height: 70%; overflow-y:scroll" >
            <table id="table1"class="table table-striped" >

            </table>
        </div>
        <ul class="pagination">
        <?php
            for($i = 0; $i < $num; $i++){
                echo "<li><a href=\"#\" class=\"pageanchors\" data-id=\"".($i)."\">".($i+1)."</a></li>";
            }
        ?>
        </ul>
        
    </div>
</div>
<div class="row">
    <div class="col-lg-10 col-lg-offset-2">
        <div class="form-group">
            <form role="form" id="frmArticle" class="form" action="<?php echo site_url() ?>/home/postmessage" method="POST">
                <label>Message</label>
                <textarea id="message" name="message" rows="5" class="form-control"></textarea>
                <input class="btn btn-info btn-block" type="submit" value="Post" name="submit">
            </form>
        </div>
    </div>

</div>
<div id="editModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Post</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <form role="form" id="editArticle" class="form" action="<?php echo site_url() ?>/home/editmessage" method="POST">
                <label>Message</label>
                <textarea id="textedit" name="textedit" rows="5" class="form-control"></textarea>
            
                <input class="btn btn-info btn-block" type="submit" value="Save" name="submit">
            </form>
        </div>
      </div>
      <div class="modal-footer">
        <input id="editid" value="" type="hidden">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<script>
    var path = "<?php echo site_url() ?>";
    $(document).ready(function(){
        loadArticle(0);
        $("#frmArticle").submit(function (e){
            e.preventDefault();
            tinymce.triggerSave();
            //var data = $(this).serialize();
            var data = $("#message").val();
            var type = $(this).attr('method');
            var url = $(this).attr('action');
            //data = "<span style=\"color:red\">Hello</span>";
            console.log(data);
             
            $.ajax({
                url:url,
                type: type,
                data: {d:data},
                async: 'false'
            }).done(function (html){
                console.log(html);
                $('#frmArticle')[0].reset();
                location.reload();
            });
        });
        $("#editArticle").submit(function (e){
            e.preventDefault();
            tinymce.triggerSave();

            var data = $("#textedit").val();
            var type = $(this).attr('method');
            var url = $(this).attr('action');
            var postid = $("#editid").val();
             console.log($("#textedit").val());
            $.ajax({
                url:url,
                type: type,
                data: {message:data, id:postid},
                async: 'false'
            }).done(function (html){
                $('#editArticle')[0].reset();
                location.reload();
            });
        });
    });
    function loadArticle(page){
        $.ajax({
                url:'<?php echo site_url() ?>/home/loadmessage/'+page,
                type: 'post'
            }).done(function (html){
                $("#table1").html(html);
            });
    }



    $('#editModal').on('shown.bs.modal', function (e) {
        var id = $(e.relatedTarget).data('id');
        //tinyMCE.activeEditor.setContent($("#"+id + " .postmessage").html());
        tinyMCE.activeEditor.setContent($("#"+id + " .postmessage").html());
        $("#editid").val(id);
    })
    $(document).on('click', '.deletebtn', function(){
            var postid = $(this).data('id');
            $.ajax({
                url: path + "/home/deleteMessage",
                type: 'POST',
                data: {id: postid}
            }).done(function (html){
                location.reload();
            });
    });
    $(document).on('click', '.pageanchors', function(){
            var postid = $(this).data('id');
            loadArticle(postid);
    });
</script>


