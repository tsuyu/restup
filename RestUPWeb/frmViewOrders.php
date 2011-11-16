<?php
$page_title = "View Orders";

if (is_file("template/template.htm")) {
    $template = file_get_contents("template/template.htm");
    $template = str_replace('{TITLE}', $page_title, $template);
    $template = explode('{CONTENT}', $template);
}

print $template[0];
?>
<script type="text/javascript">
    function cancelConfirm(){
        location.href='frmHomepage.php';
    }
</script>
<?php
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
        <div class="left">
            <h3>Menu</h3>
            <ul>
                <li><a href = "frmHomepage.php" >Homepage</a></li>
                <li><a href = "frmViewUsers.php" >View User</a></li>
                <li><a href = "frmAddUser.php">Add User</a></li>
                <li><a href = "frmUpdateProfile.php" >Update Profile</a></li>
                <li><a href = "frmNewItem.php" >Add New Item</a></li>
                <li><a href = "frmViewItem.php" >View All Item</a></li>
                <li><a href = "actSignout.php" >Signout</a></li>
            </ul>
        </div>
    <?php } ?>
    <div class="content">
        <?php
        print "<div style=\"margin-bottom:5; margin-left:1; color:black; font-size:1em; font-weight:bold\"  align='right'>";
        print "<p>$profile->role: <a href=\"frmUpdateProfile.php\">$profile->name</a></p>\n";
        print "</div>"
        ?>
        <?php
        $result = viewOrders();
        $tableid = $_GET['id'];

        if ($tableid <= 5) {
            $tabs = "A" . $tableid;
        } else {
            $tabs = "B" . $tableid;
        }

        if (mysql_num_rows($result) == 0) {
            ?>
            <script type="text/javascript">
                alert("No order from table <?php print $tabs ?> or Customer have paid the bill")
                location.href = "frmHomepage.php";
            </script>


            <?php
        } else {

            print "<strong>Order for table " . $tabs . "</strong>\n";
            print "\n";
            ?>
            <br/><br/>
            <table border="1" class="listtable">
                <tr>
                    <th>Item Id</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Order status</th>
                </tr>

                <?php
                while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

                    print "<tr>";
                    $orderid = $row[orderid];
                    print"<td>{$row['itemid']}</td>";
                    print "<td>{$row['itemname']}</td>";
                    print "<td>{$row['quantity']}</td>";
                    print"<td>{$row['price']}</td>";
                    print "<td>{$row['orderdesc']}</td>";
                    $tableid = $row[tableid];
                    $tablename = $row[tablename];
                    $userid = $row[userid];
                    $name = $row[name];
                    print "</tr>";
                }
                ?>

            </table>
            <br/>

            <?php
            print "<strong>Order Summary :</strong><br/><br/>";
            print "Waiter :" . $name . " [$userid]<br/>";
            print "Order Id :" . $orderid . "<br/>";
        }
        ?>

        <form name="confirm" action="actConfirmOrders.php?orderitemid=<?php print $orderid ?>&tableid=<?php print $tableid ?>" method="POST">
            Confirm status :&nbsp;
            <select name="status">
                <option value="1">No order / paid / cancel</option>
                <option value="2">Order confirmed</option>
                <option value="3">Food delivered</option>
                <option value="4">Order rejected</option>
            </select>
            <br/>
            <p><input type="submit" value="Confirm" name="confirm" />
                <input type="reset" value="Cancel" name="cancel" onClick="cancelConfirm();"/></p>
        </form>
    </div>
    <?php
}
print $template[1];
?>