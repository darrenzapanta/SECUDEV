



<div class="row" >
    <div class="col-lg-4">
        <h1>Add Items </h1>
       <?php echo validation_errors(); ?>
       <?php echo form_open('verifyadditem'); ?>
         <label for="Name">Name:</label>
         <input type="text" size="20" id="name" name="name"/>
         <br/>
         <label for="Price">Price:</label>
         <input type="text" size="20" id="price" name="price"/>
         <br/>
         <label for="Quantity">Quantity:</label>
         <input type="text" size="20" id="quantity" name="quantity"/>
         <br/>
         <label for="description">Description:</label>
         <textarea NAME="description" id="description" COLS=40 ROWS=4></textarea>
         <br/>
         <input type="submit" value="Add Item"/>
       <?php echo form_close(); ?>
   </div>
    <div class="col-lg-8">
        <h1>Item List</h1>
        <div class="table-responsive" style="height: 80%">
        <table class="table table-bordered table-striped" >
        <thead>
            <td>Picture</td>
            <td>Name</td>
            <td>Price</td>
            <td>Quantity</td>
            <td>Description</td>
            <td>Controls</td>
        </thead>
        <tbody id="table1">
        </tbody>
        </table>
    </div>
</div>

<div id="uploadModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Upload Image</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <?php echo form_open_multipart('managestore/uploadimage');?>
            <input type="file" name="userfile" size="20" />
            <input type="hidden" value="" id="itemid" name="itemid"/>
            <input type="submit" value="Upload" />
            </form>
        </div>
      </div>
    </div>

  </div>
</div>

<script>
var path = "<?php echo site_url() ?>";
$(document).ready(function(){
    loadItems();
});

function loadItems(){
    $.ajax({
            url:'<?php echo site_url() ?>/managestore/loaditems',
            type: 'post'
        }).done(function (html){
            $("#table1").html(html);
        });
}

$(document).on('click', '.deletebtn', function(){
        var postid = $(this).data('id');
        $.ajax({
            url: path + "/managestore/deleteitem/"+postid,
            type: 'POST',
        }).done(function (html){
            loadItems();
        });
});

$('#uploadModal').on('shown.bs.modal', function (e) {
    var id = $(e.relatedTarget).data('id');
    $("#itemid").val(id);
});
</script>

