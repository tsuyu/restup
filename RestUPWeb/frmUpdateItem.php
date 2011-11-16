<?php
// This page enables a user to update their details. Various checks are
// performed to try to ensure that the user enters sensible data. The form
// data are passed to update_profile2.php.

require "dbFunctions.php";
$item = storeItem();

$page_title = "Update Item";

if (is_file("template/template.htm")) {
    $template = file_get_contents("template/template.htm");
    $template = str_replace('{TITLE}', $page_title, $template);
    $template = explode('{CONTENT}', $template);
}

print $template[0];

$userInfo = userAccess();

$role = $userInfo->role;

if ($role == null) {

    print "<script type=\"text/javascript\">
        alert('Your session has been expired. Please login!');
        location.href='index.html';
</script>";
} else if (!$role == null) {

    if ($role == Cooker || $role == Waiter) {

        print "<script type=\"text/javascript\">
        alert('You do not have access to this page!');
        location.href='frmHomepage.php';
</script>";
    } else if ($role == Admin) {
        ?>
        <head>
            <script type="text/javascript">
                function IsNotNull(){
                    if (
                    document.form1.itemname == null||
                        document.form1.price == null) {
                        alert("Please fill out all the fields.");
                        return false;
                    }
                    if (
                    document.form1.itemname.value.length == 0||
                        document.form1.price.value.length==0) {
                        alert("Please fill out all the fields.");
                        return false;
                    }
                    return true;
                }



                function checkfields() {
                    if (IsNotNull() == false) {
                        return false;
                    }
        	
                    if (CheckForMatch() == false) {
                        return false;
                    }
                    return true;
                }
            </script>
        </head>

        <body>
            <link href="template/content_css.css" rel="stylesheet" type="text/css" />
        <body>
            <div class="left">
                <h3>Menu</h3>
                <ul>
                    <li><a href = "frmHomepage.php" >Homepage</a></li>
                    <li><a href = "frmAddUser.php">Add User</a></li>
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
        print "<p>$userInfo->role: <a href=\"frmUpdateProfile.php\">$userInfo->name</a></p>\n";
        print "</div>";
        ?>
                <form name="form1" action="actUpdateItem.php" method="post" onSubmit='return checkfields();'>
                    <p><strong>Update Item Details</strong></p><br/>
                    <p>Item Id :<input type="text" name="itemid" value="<? print "$item->itemid" ?>"  class="input" readonly></p>
                    <p>Name: <input type="text" name="itemname" value="<? print "$item->itemname" ?>" class="input"></p>
                    <p>Category: <input type="text" name="category" value="<? print "$item->category" ?>" class="input"></p>
                    <p>Price: <input type="text" name="price" value="<? print "$item->price" ?>" class="input"></p>
                    <p>Description: <br/><textarea name="description"   class="input" cols="50" rows="10"><? print "$item->description" ?></textarea></p>

                    <br><br>

                    <input type="submit" value="Update Details"> <input type="reset">

                </form>
            </div>
        </body>
        <?php
    }
}
print $template[1];
?>