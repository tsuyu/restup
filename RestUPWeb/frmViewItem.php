<?php
$page_title = "View Items";

if (is_file("template/template.htm")) {
    $template = file_get_contents("template/template.htm");
    $template = str_replace('{TITLE}', $page_title, $template);
    $template = explode('{CONTENT}', $template);
}

print $template[0];

require "dbFunctions.php";
$userInfo = userAccess();

$role = $userInfo->role;

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

        <script type="text/javascript" src="selectCategory.js"></script>

        <body>
            <div class="left">
                <h3>Menu</h3>
                <ul>
                    <li><a href = "frmHomepage.php" >Homepage</a></li>
                    <li><a href = "frmViewUsers.php" >View User</a></li>
                    <li><a href = "frmAddUser.php">Add User</a></li>
                    <li><a href = "frmUpdateProfile.php" >Update Profile</a></li>
                    <li><a href = "frmNewItem.php" >Add New Item</a></li>
                    <li><a href = "actSignout.php" >Signout</a></li>
                </ul>
            </div>

            <div class="content">
                <?php
                print "<div style=\"margin-bottom:5; margin-left:1; color:black; font-size:1em; font-weight:bold\"  align='right'>";
                print "<p>$userInfo->role: <a href=\"frmUpdateProfile.php\">$userInfo->name</a></p>\n";
                print "</div>"
                ?>
                <form>
                    <strong>View Item</strong><br/><br/>
                    Select item by category:
                    <select name="" onchange="showItem(this.value)">
                        <option>Select</option>
                        <option value="Western">Western</option>
                        <option value="Kampung Style">Kampung Style</option>
                        <option value="Thai Style">Thai Style</option>
                    </select>
                </form>
                <br />
                <div id="txtHint"></div>
        </body>
        </div>
        <br/><br/><br/>
        <?php
    }
}


print $template[1];
?>
