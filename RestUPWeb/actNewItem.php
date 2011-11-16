<?php
require "dbFunctions.php";
$result = newItem();
?>

<script type="text/javascript">
    alert('Thank you. Your item has been added to the db.');
    location.href = "frmNewItem.php";
</script>
