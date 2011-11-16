<?php
require "dbFunctions.php";
$result = getUserList();
?>
<form name="form1" method="post" action="actDeleteUser.php">
    <table width="400" border="1" class="listtable">
        <tr>
            <td align="center" bgcolor="#FFFFFF"></td>
            <td align="center" bgcolor="#FFFFFF"><strong>User Id</strong></td>
            <td align="center" bgcolor="#FFFFFF"><strong>Name</strong></td>
            <td align="center" bgcolor="#FFFFFF"><strong>Email</strong></td>
            <td align="center" bgcolor="#FFFFFF"><strong>Telephone</strong></td>
            <td align="center" bgcolor="#FFFFFF"><strong>Role</strong></td>
        </tr>


<?php
while ($row = mysql_fetch_array($result)) {
    ?>
            <tr>
                <td align="center" bgcolor="#FFFFFF"><input name="checkbox[]" type="checkbox" id="checkbox[]" value="<?php print $row['userid']; ?>"></td>
                <td><?php print $row['userid']; ?></td>
                <td><?php print $row['name']; ?></td>
                <td><?php print $row['email']; ?></td>
                <td><?php print $row['telephone']; ?> </td>
                <td><?php print $row['role']; ?></td>
            </tr>
<?php } ?>
        <tr>
            <td colspan="10" align="center" bgcolor="#FFFFFF"><input name="delete" type="submit" id="delete" value="Delete" ></td>
        </tr>
    </table>
</form>
