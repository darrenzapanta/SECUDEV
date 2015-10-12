<script>
function storageChange(event) {
    if(event.key == 'logged_in') {
        location.reload();
    }
}
window.addEventListener('storage', storageChange, false);
</script>
</div>

</body>
<html>