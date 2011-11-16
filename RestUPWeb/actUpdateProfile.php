<?php
// This page updates the database with the data from frmUpdateProfile.php.


require "dbFunctions.php";
$result = updateProfile();

if ($result) {
    ?>

    <html>
        <head>
            <title>Profile Updated</title>
            <link rel="stylesheet" type="text/css" href="style/style.css">

        </head>


        <BODY>

            <p>Your details have been updated.</p>

            <p>If you have changed your password, you must sign in again to consolidate your changes. If you have changed any other details, you can carry on working without signing in again.</p>

            <p>Click <a href="signout.php">here</a> to sign in again.</p>

        </body></html>
    <?php
} else {


    header("location: profilechangefailed.html");
}
?>