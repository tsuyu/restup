<?php
$page_title = "Update Profile";

if (is_file("template/template.htm")) {
    $template = file_get_contents("template/template.htm");
    $template = str_replace('{TITLE}', $page_title, $template);
    $template = explode('{CONTENT}', $template);
}

print $template[0];

require "dbFunctions.php";
$profile = userAccess();
$role = $profile->role;

if ($role == null) {

    print "<script type=\"text/javascript\">
        alert('Your session has been expired. Please login!');
        location.href='index.html';
</script>";
} else if (!$role == null) {

    if ($role == Chef || $role == Waiter) {
        ?>
        <body>
            <div class="left">
                <h3>Menu</h3>
                <ul>
                    <li><a href = "frmHomepage.php" >Homepage</a></li>
                    <li><a href = "actSignout.php" >Signout</a></li>
                </ul>
            </div>
            <?php
        } else if ($role == Admin) {
            ?>
            <link href="template/content_css.css" rel="stylesheet" type="text/css" />
            <script type="text/javascript">
                function IsNotNull(){
                    if (document.form1.email == null ||
                        document.form1.name == null) {
                        alert("Please fill out all the fields.");
                        return false;
                    }
                    if (document.form1.email.value.length == 0 ||
                        document.form1.name.value.length == 0) {
                        alert("Please fill out all the fields.");
                        return false;
                    }
                    return true;
                }

                function IsValidEmail(){
                    var email = document.form1.email.value;
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

                function CheckForMatch() {
                    if (document.form1.password.value !=
                        document.form1.password2.value) {
                        alert("The passwords do not match.\n"+
                            "Please re-enter them. Thanks");
                        return false;
                    }
                    return true;
                }

                function checkfields() {
                    if (IsNotNull() == false) {
                        return false;
                    }
                    if (IsValidEmail() == false) {
                        return false;
                    }
                    if (CheckForMatch() == false) {
                        return false;
                    }
                    return true;
                }
            </script>
        <body>
            <div class="left">
                <h3>Menu</h3>
                <ul>
                    <li><a href = "frmHomepage.php" >Homepage</a></li>
                    <li><a href = "frmViewUsers.php" >View User</a></li>
                    <li><a href = "frmAddUser.php" >Add User</a></li>
                    <li><a href = "frmNewItem.php" >Add New Item</a></li>
                    <li><a href = "frmViewItem.php" >View All Item</a></li>
                    <li><a href = "actSignout.php" >Signout</a></li>
                </ul>
            </div>
            <?php
        }
        ?>
        <div class="content">

            <?php
            print "<div style=\"margin-bottom:5; margin-left:1; color:black; font-size:1em; font-weight:bold\"  align='right'>";
            print "<p>$profile->role: <a href=\"frmUpdateProfile.php\">$profile->name</a></p>\n";
            print "</div>"
            ?>

            <form name="form1" action="actUpdateProfile.php" method="post" onSubmit='return checkfields();'>
                <p><strong>Update Profile</strong><p>
                <p>User Id :<input type="text" name="userid" value="<? print $profile->userid ?>" readonly class="input"></p>
                <p>Email: <input type="text" name="email" value="<? print $profile->email ?>" class="input"></p>
                <p>Name: <input type="text" name="name" value="<? print $profile->name ?>" class="input"></p>
                <p>Telephone: <input type="text" name="telephone" value="<? print $profile->telephone ?>" class="input"></p>
                <p>Choose a password: <input type="password" name="password" value="<? print $profile->password ?>" class="input"></p>
                <p>Retype password: <input type="password" name="password2" value="<? print $profile->password ?>" class="input"></p>

                <br><br>

                <input type="submit" value="Update Details"> <input type="reset">

            </form>
        </div>
    </body>
    <?php
}
print $template[1];
?>