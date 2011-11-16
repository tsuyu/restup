<?php

$page_title = "Add New Item";

if (is_file("template/template.htm")) {
    $template = file_get_contents("template/template.htm");
    $template = str_replace('{TITLE}', $page_title, $template);
    $template = explode('{CONTENT}', $template);
}

echo $template[0];


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


        <script language="JavaScript">

            function IsNotNull(){
                if (document.form1.itemname == null ||
                    document.form1.description == null ||
                    document.form1.price == null) {

                    alert("Please fill out all the fields.");
                    return false;
                }
                if (document.form1.itemname.value.length == 0 ||
                    document.form1.description.value.length == 0 ||
                    document.form1.price.value.length == 0) {
                    alert("Please fill out all the fields.");
                    return false;
                }
                return true;
            }

            function IsValidPrice(){
                var price = document.form1.price.value;
                var myreg
                    = /\d+/
                if (myreg.test(price)) {
                    return true;
                }
                else {
                    alert("The price you have entered is invalid. You must enter a number.");
                    return false;
                }
            }


            function checkfields() {
                if (IsNotNull() == false) {
                    return false;
                }
                if (IsValidPrice() == false) {
                    return false;
                }
                return true;
            }

            function resetAddItems()
            {
                // Set the field into new variable
                var itemname = document.formComment.itemname;
                var category = document.formComment.category;
                var price = document.formComment.price;
                var description = document.formComment.description;
        	
                // Reset all the textfield on the form
                resetText(itemname);
                resetText(category);
                resetText(price);
                resetText(description);
        	
            }

        </script>

        <link href="template/content_css.css" rel="stylesheet" type="text/css" />

        <body>

            <div class="left">
                <h3>Menu</h3>
                <ul>
                    <li><a href = "frmHomepage.php" >Homepage</a></li>
                    <li><a href = "frmAddUser.php">Add User</a></li>
                    <li><a href = "frmViewUsers.php" >View User</a></li>
                    <li><a href = "frmUpdateProfile.php" >Update Profile</a></li>
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
                <p><strong>Enter your item here. Click Submit when finished</strong></p>

                <form name="form1" method="post" action="actNewItem.php" onSubmit='return checkfields();'>

                    <p>Item name:<font color="#FF0000">*</font>
                        <input type="text" name="itemname" size="50" maxlength="100" class="input" ></p>

                    <p>Category :<font color="#FF0000">*</font><select name="category">
                            <option value="Western">Western</option>
                            <option value="Kampung Style">Kampung Style</option>
                            <option value="Thai Style">Thai Style</option>>
                        </select></p>
                    <p>Price:<font color="#FF0000">*</font>
                        <input type="text" name="price" class="input" >
                    </p>


                    <p>Description:<br>
                        <textarea name="description" cols="50" rows="10" class="input" ></textarea>
                    </p>
                    <p><font color="#FF0000" face="Times new Roman" size="2">* Denotes required field &nbsp;</font></p>


                    <input type="submit" value="Submit">
                    <input type="reset" value="Reset" onSubmit='return resetAddItems();'>

                </form>

            </div>

        <?

    }
}
echo $template[1];
?>