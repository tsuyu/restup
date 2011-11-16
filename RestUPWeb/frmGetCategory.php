<?php
require "dbFunctions.php";
$result = getItemList();
?>
<form name="form1" method="post" action="actDeleteItem.php">
    <table width="400" border="1" class="listtable">
        <tr>
            <td align="center" bgcolor="#FFFFFF"></td>
            <td align="center" bgcolor="#FFFFFF"><strong>ItemId</strong></td>
            <td align="center" bgcolor="#FFFFFF"><strong>Name</strong></td>
            <td align="center" bgcolor="#FFFFFF"><strong>Category</strong></td>
            <td align="center" bgcolor="#FFFFFF"><strong>Price</strong></td>
            <td align="center" bgcolor="#FFFFFF"><strong>Description</strong></td>
            <td align="center" bgcolor="#FFFFFF"><strong>Action</strong></td>
        </tr>


<?php
while ($row = mysql_fetch_array($result)) {
    ?>
            <tr>
                <td align="center" bgcolor="#FFFFFF"><input name="checkbox[]" type="checkbox" id="checkbox[]" value="<?php print $row['itemid']; ?>"></td>
                <td><?php print $row['itemid']; ?></td>
                <td><?php print $row['itemname']; ?></td>
                <td><?php print $row['category']; ?></td>
                <td><?php print $row['price']; ?> </td>
                <td><?php print $row['description']; ?></td>
                <td width="67"><div align="center"><a href="frmUpdateItem.php?itemid=<?php print $row['itemid']; ?>">Update</a></div></td>
            </tr>
<?php } ?>
        <tr>
            <td colspan="10" align="center" bgcolor="#FFFFFF"><input name="delete" type="submit" id="delete" value="Delete" ></td>
        </tr>
    </table>
</form>
