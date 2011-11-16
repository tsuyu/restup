<?php

print "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n<tr class=\"Title2Cell\">\n<td>\n<p align=\"center\">";

include 'db/config.php';

$query = "SELECT * FROM $dbName.tables WHERE tableid='$id_table'";

$result = mysql_query($query, $db);

while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    print "{$row['tablename']}";
}
print "</p>\n</td>\n</tr>\n<tr";

$query = "SELECT * FROM $dbName.tables WHERE tableid='$id_table'";

$result = mysql_query($query, $db) or die('Error querying db');

while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    print " class=\"status";
    print "$row[status]\"";
    $table_status = $row[status];
    print">\n<td align=\"center\">\n<a href=\"frmViewOrders.php?id=$id_table\"><img src=\"template/images/table$table_status.gif\" width=\"27\" height=\"28\" border=\"0\" vspace=\"4\" hspace=\"4\">\n</a>\n</td>\n</tr>\n</table>";
}

return $result;
mysql_close();
?>