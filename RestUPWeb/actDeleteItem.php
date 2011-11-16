<?php

require "dbFunctions.php";
$result = deleteItem();


if ($result) {
    header("location: frmViewItem.php");
} else {
    print "Cannot perform operation";
}
?>
