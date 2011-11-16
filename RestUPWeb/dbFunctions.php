<?php

// This is the main file for the web application. It contains all of the
// functions that are called by the other files.

class UserInfo {

    var $userid;
    var $email;
    var $name;
    var $telephone;
    var $password;
    var $role;
    var $remember;

}

class ItemInfo {

    var $itemid;
    var $itemname;
    var $category;
    var $price;
    var $description;

}

function userAccess() {

    // Include MySQL Server Connection Constants.
    include 'db/config.php';


    // First check for a POST
    $userid = mysql_real_escape_string($_POST['userid']);
    $password = mysql_real_escape_string($_POST['password']);


    // If no POST, check for a cookie
    if ($userid == NULL) {
        $userid = $_COOKIE['nbuserid'];
        $password = $_COOKIE['nbpassword'];
    } elseif (!$remember) {
        // If there was a POST, save the cookie
        // This will wipe out any long-term
        // cookies by this same name
        setcookie('nbuserid', $userid);
        setcookie('nbpassword', $password);
    }

    $okay = false;
    if ($userid && $password) {



        $newUserInfo = new UserInfo;

        $query = "SELECT * FROM $dbName.users WHERE $dbName.users.userid = '$userid' AND $dbName.users.password = '$password'";

        $result = mysql_query($query, $db) or die(mysql_error());

        if ($result) {
            if (mysql_num_rows($result) > 0) {
                $row = mysql_fetch_assoc($result);

                $newUserInfo->userid = $row['userid'];
                $newUserInfo->name = $row['name'];
                $newUserInfo->telephone = $row['telephone'];
                $newUserInfo->email = $row['email'];
                $newUserInfo->role = $row['role'];
                $pass = $row['password'];

                if ($pass) {

                    $okay = true;
                }
            }
            mysql_close($db);
        }
        if (!$okay) {
            header("location: loginfailed.php");
        }
        // If $remember is set, store in long-term cookie
        if ($remember) {
            // Remember until May 17, 2033.
            setcookie('nbuserid', $userid, 2000000000);
            setcookie('nbpassword', $password, 2000000000);
        }
        return $newUserInfo;
    }
}

function storeItem($itemid=0) {

    include 'db/config.php';

    if (!$itemid && isset($_GET['itemid']) && (int) $_GET['itemid'] > 0) {
        $itemid = (int) $_GET['itemid'];
    }

    // $itemid = trim($_GET["itemid"]);

    $newItemInfo = new ItemInfo;

    $query = "SELECT * FROM $dbName.items WHERE $dbName.items.itemid='$itemid'";

    $result = mysql_query($query, $db) or die(mysql_error());

    if ($result) {
        if (mysql_num_rows($result) > 0) {
            $row = mysql_fetch_assoc($result);

            $newItemInfo->itemid = $row['itemid'];
            $newItemInfo->itemname = $row['itemname'];
            $newItemInfo->category = $row['category'];
            $newItemInfo->price = $row['price'];
            $newItemInfo->description = $row['description'];
        }
        return $newItemInfo;
    }

    mysql_close($db);
}

// This function adds a new user. It checks the email address to see
// whether the user is already signed up.

function addUser($userid, $name, $email, $telephone, $password, $role) {

    // Include MySQL Server Connection Constants.
    include 'db/config.php';

    $query = "SELECT * FROM $dbName.users WHERE $dbName.users.userid = '$userid'";

    $result = mysql_query($query, $db) or die(mysql_error());

    $found = false;
    if ($result) {
        if (mysql_num_rows($result) > 0) {
            print "<p>It looks like you're already registered.</p>";
            $found = true;
            return;
        }
    }
    if ($found == false) {

        $query = "INSERT INTO $dbName.users
                (userid, name, email, telephone, password, role) VALUES
                ('$userid', '$name', '$email', '$telephone', '$password','$role')";

        $result = mysql_query($query, $db) or die(mysql_error());
    }

    mysql_close($db);
    return $result;
}

// This function updates a user profile.

function updateProfile() {

    // Include MySQL Server Connection Constants.
    include 'db/config.php';

    $userid = mysql_real_escape_string($_POST['userid']);
    $email = mysql_real_escape_string($_POST['email']);
    $name = mysql_real_escape_string($_POST['name']);
    $telephone = mysql_real_escape_string($_POST['telephone']);
    $password = mysql_real_escape_string($_POST['password']);


    if (empty($password)) {

        $query = " UPDATE $dbName.users  SET $dbName.users.email='$email' ,$dbName.users.name='$name' ,$dbName.users.telephone='$telephone' WHERE $dbName.users.userid='$userid' ";
        $result = mysql_query($query, $db) or die(mysql_error());
    } else {

        $query = " UPDATE $dbName.users  SET $dbName.users.email='$email' ,$dbName.users.name='$name' ,$dbName.users.telephone='$telephone' ,$dbName.users.password='$password' WHERE $dbName.users.userid='$userid' ";
        $result = mysql_query($query, $db) or die(mysql_error());
    }

    return $result;
    mysql_close($db);
}

// This function is used to generate the list of items when View All Items
// is selected.

function getItemList() {

    // Include MySQL Server Connection Constants.
    include 'db/config.php';
    require_once 'actPaginator.php';

    $category = $_GET["category"];

    $query = "SELECT COUNT(*) FROM $dbName.items";
    $result = mysql_query($query, $db) or die(mysql_error());

    $pages = new Paginator;
    $pages->items_total = $result;
    $pages->mid_range = 7;
    $pages->paginate();
    $query = "SELECT $dbName.items.itemid,
				$dbName.items.itemname,
				$dbName.items.category,
				$dbName.items.price,
				$dbName.items.description
				FROM $dbName.items WHERE category = '" . $category . "' ORDER BY $dbName.items.itemid $pages->limit";

    $result = mysql_query($query, $db) or die(mysql_error());
    echo $pages->display_pages();
    echo $pages->display_jump_menu();
    //echo $pages->display_items_per_page(); 

    return $result;
    mysql_close($db);
}

function getUserList() {

    // Include MySQL Server Connection Constants.
    include 'db/config.php';
    require_once 'actPaginator.php';

    $role = $_GET["role"];

    $query = "SELECT COUNT(*) FROM $dbName.users";
    $result = mysql_query($query, $db) or die(mysql_error());

    $pages = new Paginator;
    $pages->items_total = $result;
    $pages->mid_range = 7;
    $pages->paginate();
    $query = "SELECT $dbName.users.userid,
				$dbName.users.name,
				$dbName.users.email,
				$dbName.users.telephone,
                                $dbName.users.password,
				$dbName.users.role
				FROM $dbName.users WHERE role = '" . $role . "' $pages->limit";

    $result = mysql_query($query, $db) or die(mysql_error());
    echo $pages->display_pages();
    echo $pages->display_jump_menu();
    //echo $pages->display_items_per_page();

    return $result;
    mysql_close($db);
}

function getNewOrders() {

    // Include MySQL Server Connection Constants.
    include 'db/config.php';

    $query = "SELECT * FROM $dbName.orderitem, $dbName.tables WHERE
                            orderitem.tableid = tables.tableid
				AND orderdesc = 'New order'";

    $result = mysql_query($query, $db) or die(mysql_error());

    if (mysql_num_rows($result) == 0) {
        
    } else {

        print "<script type='text/javascript'>";
        print "alert('Alert!!!New order received..');";
        print "</script>";

        print "<table border=\"0\">
                 <tr>
                 <td><strong>New orders at table :<strong> <img src=\"template/images/new.gif\"/></td>";

        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
            //print "<tr>";
            print "<td><a href=\"frmViewOrders.php?id={$row['tableid']}\"><font color=\"red\">{$row['tablename']}</font></a></td>";
        }
        print "</tr>";
        print "</table>";
    }


    return $result;

    mysql_close($db);
}

function newItem() {

    // Include MySQL Server Connection Constants.
    include 'db/config.php';

    $itemname = mysql_real_escape_string($_POST['itemname']);
    $category = mysql_real_escape_string($_POST['category']);
    $price = mysql_real_escape_string($_POST['price']);
    $description = mysql_real_escape_string($_POST['description']);


    $query = "INSERT INTO $dbName.items
                        (itemid, itemname, category, price,  description)
                             VALUES (NULL, '$itemname', '$category', '$price', '$description')";

    $result = mysql_query($query, $db) or die(mysql_error());



    if ($result) {

        return $result;
    } else {
        header("location: newitemfailed.html");
    }

    mysql_close($db);
}

function updateItem() {

    // Include MySQL Server Connection Constants.
    include 'db/config.php';

    $itemid = mysql_real_escape_string($_POST['itemid']);
    $itemname = mysql_real_escape_string($_POST['itemname']);
    $category = mysql_real_escape_string($_POST['category']);
    $price = mysql_real_escape_string($_POST['price']);
    $description = mysql_real_escape_string($_POST['description']);

    $query = " UPDATE $dbName.items  SET $dbName.items.itemname='$itemname' ,$dbName.items.category='$category' ,$dbName.items.price='$price' ,$dbName.items.description='$description' WHERE $dbName.items.itemid='$itemid' ";
    $result = mysql_query($query, $db) or die(mysql_error());

    if ($result) {

        print "<script type=\"text/javascript\">
        alert('Item details have been updated.');
        location.href = \"frmViewItem.php\";
        </script>";
        return $result;
    } else {
        header("location: itemchangefailed.html");
    }

    mysql_close($db);
}

function deleteItem($itemid=0) {

    include 'db/config.php';

    if (!$itemid && isset($_GET['itemid']) && (int) $_GET['itemid'] > 0) {
        $itemid = (int) $_GET['itemid'];
    }

    if ($_POST['delete']) { // from button name="delete"
        $checkbox = $_POST['checkbox']; //from name="checkbox[]"
        $countCheck = count($_POST['checkbox']);

        for ($i = 0; $i < $countCheck; $i++) {
            $itemid = $checkbox[$i];
            $query = "DELETE FROM $dbName.items WHERE $dbName.items.itemid='$itemid'";
            $result = mysql_query($query, $db) or die(mysql_error());
        }
    }

    return $result;

    mysql_close($db);
}

function deleteUser() {

    include 'db/config.php';

    $userid = mysql_real_escape_string($_POST['userid']);

    if ($_POST['delete']) { // from button name="delete"
        $checkbox = $_POST['checkbox']; //from name="checkbox[]"
        $countCheck = count($_POST['checkbox']);

        for ($i = 0; $i < $countCheck; $i++) {
            $userid = $checkbox[$i];
            $query = "DELETE FROM $dbName.users WHERE $dbName.users.userid='$userid'";
            $result = mysql_query($query, $db) or die(mysql_error());
        }
    }

    return $result;

    mysql_close($db);
}

function viewOrders() {

    include 'db/config.php';
    //retrieve the data

    $tableid = trim($_GET["id"]);

    //set the query to extract the latest post form the author $author
    $query = "SELECT * FROM $dbName.orderitem , $dbName.orders, $dbName.tables, $dbName.items ,$dbName.users
                          WHERE orderitem.orderitemid = orders.orderid AND items.itemid=orders.itemid
                             AND orderitem.userid=users.userid AND orderstatus='1'AND orderitem.tableid ='$tableid'
                               AND tables.tableid ='$tableid'";
    //execute it
    $result = mysql_query($query, $db) or die(mysql_error());

    return $result;
    mysql_close($db);
}

function confirmOrders() {

    include 'db/config.php';

    $tablestatus = $_POST["status"];
    $orderitemid = trim($_GET["orderitemid"]);
    $tableid = trim($_GET["tableid"]);

    if ($tablestatus == 1) {

        $order = 1;
        $orderstatus = 0;
        $desc = "No order / paid / cancel";

        $query = "UPDATE $dbName.orderitem SET $dbName.orderitem.orderstatus ='$orderstatus',$dbName.orderitem.orderdesc ='$desc' WHERE $dbName.orderitem.orderitemid='$orderitemid' ";
        $result = mysql_query($query, $db) or die(mysql_error());
    } elseif ($tablestatus == 2) {

        $order = 3;
        $desc = "Order confirmed";

        $query = "UPDATE $dbName.orderitem SET $dbName.orderitem.orderdesc ='$desc' WHERE $dbName.orderitem.orderitemid='$orderitemid' ";
        $result = mysql_query($query, $db) or die(mysql_error());
    } elseif ($tablestatus == 3) {

        $order = 4;
        $desc = "Food delivered";

        $query = "UPDATE $dbName.orderitem SET $dbName.orderitem.orderdesc ='$desc' WHERE $dbName.orderitem.orderitemid='$orderitemid' ";
        $result = mysql_query($query, $db) or die(mysql_error());
    } elseif ($tablestatus == 4) {

        $order = 5;
        $desc = "Order rejected";

        $query = "UPDATE $dbName.orderitem SET $dbName.orderitem.orderdesc ='$desc' WHERE $dbName.orderitem.orderitemid='$orderitemid' ";
        $result = mysql_query($query, $db) or die(mysql_error());
    }

    $query = "UPDATE $dbName.tables SET $dbName.tables.status ='$order' WHERE $dbName.tables.tableid='$tableid' ";
    $result = mysql_query($query, $db) or die(mysql_error());

    if (!$result) {
        
    } else {

        print "<script type='text/javascript'>";
        print "alert('Order Status updated');";
        print "</script>";
    }
    return $result;
    mysql_close($db);
}

function orderSenderMobile() {

    include 'db/config.php';

    //retrieve data
    $userid = trim($_GET["userid"]);
    $password = trim($_GET["password"]);
    $tablename = trim($_GET["table"]);
    $tableid = trim($_GET["table"]);

    $item0 = trim($_GET["item0"]);
    $item1 = trim($_GET["item1"]);
    $item2 = trim($_GET["item2"]);
    $item3 = trim($_GET["item3"]);
    $item4 = trim($_GET["item4"]);
    $item5 = trim($_GET["item5"]);

    $qty0 = trim($_GET["qty0"]);
    $qty1 = trim($_GET["qty1"]);
    $qty2 = trim($_GET["qty2"]);
    $qty3 = trim($_GET["qty3"]);
    $qty4 = trim($_GET["qty4"]);
    $qty5 = trim($_GET["qty5"]);

    $tablestatus = 2;
    $orderstatus = 1;
    $orderdesc = "New Order";

    //connect to the DB
    if ($tableid{0} == "A" || $tableid{0} == "B")
        $tableid = substr($tableid, 1);
    //set the query to check the credentials
    $query = "SELECT userid, password FROM $dbName.users WHERE $dbName.users.userid='$userid' AND $dbName.users.password='$password'";

    //execute it
    $result = mysql_query($query, $db) or die(mysql_error());

    if (mysql_num_rows($result) == 0) {
        // wrong credentials
        //echo "Wrong userid and/or password";

        die();
    } else {

        $query = "SELECT * FROM $dbName.orderitem WHERE 
			                $dbName.orderitem.orderstatus = '1' AND $dbName.orderitem.tableid = '$tableid'";

        $result = mysql_query($query, $db) or die(mysql_error());

        $found = false;
        if ($result) {
            if (mysql_num_rows($result) > 0) {
                print "Orders for this table already submitted.";
                $found = true;
                return;
            }
        }
        if ($found == false) {


            $tablequery = "UPDATE $dbName.tables SET $dbName.tables.status='$tablestatus'WHERE $dbName.tables.tableid='$tableid'";
            //execute it
            mysql_query($tablequery, $db) or die('Error querying db');
            //right credentials

            $date = date("Y-m-d H:i:s");
            //$text = addslashes($text);
            $query = "INSERT INTO $dbName.orderitem (orderitemid, userid, date, tableid, orderstatus, orderdesc) VALUES( NULL, '$userid', '$date', '$tableid', '$orderstatus','$orderdesc')";
            //execute it
            mysql_query($query, $db) or die(mysql_error());

            $order_id = mysql_insert_id($db);

            if ($item0) {


                //set the query
                $query = "INSERT INTO $dbName.orders (orderid, itemid, quantity) VALUES( '$order_id', '$item0', '$qty0')";
                //execute it
                $result = mysql_query($query, $db) or die('Error querying db');
                if (!$result) {
                    print "Error";
                } else {
                    print "List orders for table $tablename :\n";
                    print "...............................\n";
                    print "1. " . $item0 . " -> $qty0\n";
                }
            }

            if ($item1) {
                //set the query
                $query = "INSERT INTO $dbName.orders (orderid, itemid, quantity) VALUES( '$order_id', '$item1', '$qty1')";
                //execute it
                $result = mysql_query($query, $db) or die(mysql_error());
                if ($result) {
                    print "2. " . $item1 . " -> $qty1\n";
                }
            }

            if ($item2) {

                //set the query
                $query = "INSERT INTO $dbName.orders (orderid, itemid, quantity) VALUES( '$order_id', '$item2', '$qty2')";
                //execute it
                $result = mysql_query($query, $db) or die(mysql_error());
                if ($result) {
                    print "3. " . $item2 . " -> $qty2\n";
                }
            }

            if ($item3) {

                //set the query
                $query = "INSERT INTO $dbName.orders (orderid, itemid, quantity) VALUES( '$order_id', '$item3', '$qty3')";
                //execute it
                $result = mysql_query($query, $db) or die(mysql_error());
                if ($result) {
                    print "4. " . $item3 . " -> $qty3\n";
                }
            }

            if ($item4) {

                //set the query
                $query = "INSERT INTO $dbName.orders (orderid, itemid, quantity) VALUES( '$order_id','$item4', '$qty4')";
                //execute it
                $result = mysql_query($query, $db) or die(mysql_error());
                if ($result) {
                    print "5. " . $item4 . " -> $qty4\n";
                }
            }

            if ($item5) {

                //set the query
                $query = "INSERT INTO $dbName.orders (orderid, itemid, quantity) VALUES( '$order_id', '$item5', '$qty5')";
                //execute it
                $result = mysql_query($query, $db) or die(mysql_error());
                if ($result) {
                    print "6. " . $item5 . " -> $qty5\n";
                }
            }
        }

        return $result;
        mysql_close($db);
    }
}

function statusRetriverMobile() {

    include 'db/config.php';

    //retrieve the data
    $userid = trim($_GET["userid"]);
    $password = trim($_GET["password"]);
    $tablename = trim($_GET["table"]);
    $tableid = trim($_GET["table"]);


    //set the query to check the credentials
    $query = "SELECT userid, password FROM $dbName.users WHERE $dbName.users.userid='$userid' AND $dbName.users.password='$password'";

    //execute the query
    $result = mysql_query($query, $db) or die(mysql_error());

    if (mysql_num_rows($result) == 0) {
        // wrong cedentials
        echo "Wrong username and/or password";
        die();
    } else {
        if ($tableid{0} == "A" || $tableid{0} == "B")
            $tableid = substr($tableid, 1);
        //right credentials
        //set the query to extract the latest post form the author $author
        $query = "SELECT * FROM $dbName.orderitem , $dbName.orders, $dbName.tables, $dbName.items ,$dbName.users
                          WHERE orderitem.orderitemid = orders.orderid AND items.itemid=orders.itemid
                             AND orderitem.userid = users.userid AND orderstatus='1'AND orderitem.tableid ='$tableid'
                               AND tables.tableid ='$tableid'";

        //execute it
        $result = mysql_query($query, $db) or die(mysql_error());

        if (mysql_num_rows($result) == 0) {
            print "No order present from table $tablename ";
            print " or ";
            print "Customer have paid the bill";
            die();
        } else {
            print "Order for table " . $tablename . "\n";
            print "\n";

            while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

                print "Item :{$row['itemid']} \n" .
                        "Item Name :{$row['itemname']} \n" .
                        "Quantity :{$row['quantity']} \n" .
                        "Order Status :{$row['orderdesc']} \n" .
                        "\n";
            }
        }
    }

    mysql_close($db);
    return $result;
}

?>