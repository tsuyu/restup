<?php

require "dbFunctions.php";
$result = deleteUser();


if ($result) {
    header("location: frmViewUsers.php");
} else {
    print "Cannot perform operation";
}
?>
