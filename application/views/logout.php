<script>
$(document).ready(function(){
	window.localStorage.setItem('logged_in', false);
	window.location.href = "<?php echo site_url() ?>/welcome";
});
</script>