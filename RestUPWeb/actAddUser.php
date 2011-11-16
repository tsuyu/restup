<html><head>
        <title>Registration Complete</title>
        <link rel="stylesheet" type="text/css" href="style/style.css">
    </head>


    <!--
    This page is displayed at the end of the registration process. The message
    displayed to the user depends on whether the registration was successful.
    This is determined by the status of $result, which is returned from
    the function signup() in functions.php.
    -->



    <body>
        <?php
        require "dbFunctions.php";

        $userid = $_POST['userid'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $telephone = $_POST['telephone'];
        $password = $_POST['password'];
        $role = $_POST['role'];

        $result = addUser($userid, $name, $email, $telephone, $password, $role);

        if (!$result) {

            print "New user profile cannot be added into database";
        } else {

            print "<script type=\"text/javascript\">
        alert('New user has been added to the db.');
        location.href='frmAddUser.php';
        </script>";
        }
        ?>

    </body></html>