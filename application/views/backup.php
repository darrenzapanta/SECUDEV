
<div class="col-lg-10">
	<!-- <div class="jumbotron"> -->
		<button class="btn btn-primary" id="backup">Create Backup</button>
		<br><br>
	<!-- </div> -->
	<div class="table-responsive">
		<table id="table1" class="table table-striped">
		<?php
			for($i = 0; $i < count($fn); $i++){
				echo "<tr>";
				echo "<td>";
				echo $fn[$i];
				echo "</td>";
				echo "<td>";
				echo anchor('backup/download/'.$fn[$i], 'Download');
				echo "</td>";
				echo "</tr>";
			}

		?>
		</table>
	</div>
	<script>
	$("#backup").click(function (e){

	    $.ajax({
	        url:"<?php echo site_url() ?>/backup/backup",
	        type: "post",
	        async: 'false'
	    }).done(function (html){
	    	location.reload();
	    });
	});
	</script>

</div>