<?php
require "dbFunctions.php";
$result = confirmOrders();
?>
<script type="text/javascript">
    location.href = "frmHomepage.php";
</script>


