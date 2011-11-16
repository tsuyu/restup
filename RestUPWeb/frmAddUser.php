<?php
$page_title = "Add User";

if (is_file("template/template.htm")) {
    $template = file_get_contents("template/template.htm");
    $template = str_replace('{TITLE}', $page_title, $template);
    $template = explode('{CONTENT}', $template);
}

print $template[0];

require "dbFunctions.php";
$newUserInfo = userAccess();

$role = $newUserInfo->role;

if ($role == null) {

    print "<script type=\"text/javascript\">
        alert('Your session has been expired. Please login!');
        location.href='index.html';
</script>";
} else if (!$role == null) {

    if ($role == Chef || $role == Waiter) {

        print "<script type=\"text/javascript\">
        alert('You do not have access to this page!');
        location.href='frmHomepage.php';
        </script>";
    } else if ($role == Admin) {
        ?>

        <head>


            <!--
            This page contains the registration form for new users. It is opened
            in an iframe by registerOutline.php. Various checks are performed to
            try to ensure that the user enters sensible data in the form fields.
            The form data is passed to regcomplete.php.
            -->


            <title>Registration Form</title>

            <script type="text/javascript">
                function IsNotNull(){
                    if ( document.formAddUser.userid == null ||
                        document.formAddUser.email == null ||
                        document.formAddUser.name == null) {
                        alert("Please fill out all the fields.");
                        return false;
                    }
                    if ( document.formAddUser.userid.value.length == 0 ||
                        document.formAddUser.email.value.length == 0 ||
                        document.formAddUser.name.value.length == 0) {
                        alert("Please fill out all the fields.");
                        return false;
                    }
                    return true;
                }

                function IsValidEmail(){
                    var email = document.formAddUser.email.value;
                    var myreg
                        = /^[^@\s]+@([-a-z0-9]+\.)+[a-z]{2,}$/
                    if (myreg.test(email)) {
                        return true;
                    }
                    else {
                        alert("The email address is invalid.");
                        return false;
                    }
                }


                function checkfields() {
                    if (IsNotNull() == false) {
                        return false;
                    }
                    if (IsValidEmail() == false) {
                        return false;
                    }
                    return true;
        	
                    function resetAddUsers()
                    {
                        // Set the field into new variable
                        var userid = document.formComment.userid;
                        var name = document.formComment.name;
                        var role = document.formComment.role;
                        var telephone = document.formComment.telephone;
                        var email = document.formComment.email;
        	
                        // Reset all the textfield on the form
                        resetText(userid);
                        resetText(name);
                        resetText(role);
                        resetText(telephone);
                        resetText(email);
        	
                    }
                }
            </script>
        </head>


        <body>
            <div class="left">
                <h3>Menu</h3>
                <ul>
                    <li><a href = "frmHomepage.php" >Homepage</a></li>
                    <li><a href = "frmViewUsers.php" >View User</a></li>
                    <li><a href = "frmUpdateProfile.php" >Update Profile</a></li>
                    <li><a href = "frmNewItem.php" >Add New Item</a></li>
                    <li><a href = "frmViewItem.php" >View All Item</a></li>
                    <li><a href = "actSignout.php" >Signout</a></li>
                </ul>
            </div>

            <div class="content">
        <?php
        print "<div style=\"margin-bottom:5; margin-left:1; color:black; font-size:1em; font-weight:bold\"  align='right'>";
        print "<p>$newUserInfo->role: <a href=\"frmUpdateProfile.php\">$newUserInfo->name</a></p>\n";
        print "</div>"
        ?>
                <p>Fill out the form below to add new user.</p>

                <form name="formAddUser" method="post" action="actAddUser.php" onSubmit='return checkfields();'>
                    <p>User Id:<font color="#FF0000">*</font> <input type="text" name="userid" class="input" ></p>
                    <p>Name:<font color="#FF0000">*</font> <input type="text" name="name" class="input"></p>
                    <p>Role :<font color="#FF0000">*</font> <select name="role" >
                            <option value="Admin">Admin</option>
                            <option value="Chef">Chef</option>
                            <option value="Waiter">Waiter</option>
                        </select></p>
                    <p>Telephone:<font color="#FF0000">*</font> <input type="text" name="telephone" class="input"></p>
                    <p>Email address:<font color="#FF0000">*</font> <input type="text" name="email" class="input"></p>
                    <input type="hidden" name="password" value="123">
                    <p><font color="#FF0000" face="Times new Roman" size="2">* Denotes required field &nbsp;</font></p>

                    <p><input type="submit" name="Submit" value="Add"><input type="reset" value="Reset" onSubmit='return resetAddUsers();'></p>

                </form>
            </div>
        </body>

        <?php
        print $template[1];
    }
}
?>