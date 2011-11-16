<?php
$page_title = "Home";

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

    if ($role == Admin) {
        ?>
        <body bgcolor="#FFFFFF" text="#000000" link="#FFFFFF" vlink="#CC0000" alink="#0099CC" leftmargin="10" topmargin="10" marginwidth="0" marginheight="0">
            <div class="left">
                <h3>Menu</h3>
                <ul>
                    <li><a href = "frmViewUsers.php" >View User</a></li>
                    <li><a href = "frmAddUser.php">Add User</a></li>
                    <li><a href = "frmUpdateProfile.php" >Update Profile</a></li>
                    <li><a href = "frmNewItem.php" >Add New Item</a></li>
                    <li><a href = "frmViewItem.php" >View All Item</a></li>
                    <li><a href = "actSignout.php" >Signout</a></li>
                </ul>
            </div>
        <?php
    } else if ($role == Chef || $role == Waiter) {
        ?>
        <body bgcolor="#FFFFFF" text="#000000" link="#FFFFFF" vlink="#CC0000" alink="#0099CC" leftmargin="10" topmargin="10" marginwidth="0" marginheight="0">
            <div class="left">
                <h3>Menu</h3>
                <ul>
                    <li><a href = "frmUpdateProfile.php" >Update Profile</a></li>
                    <li><a href = "actSignout.php" >Signout</a></li>
                </ul>
            </div>
        <?php
    }
}
?>



    <script>
        <!--

        //enter refresh time in "minutes:seconds" Minutes should range from 0 to inifinity. Seconds should range from 0 to 59
        var limit="0:30"

        if (document.images){
            var parselimit=limit.split(":")
            parselimit=parselimit[0]*60+parselimit[1]*1
        }
        function beginrefresh(){
            if (!document.images)
                return
            if (parselimit==1)
                window.location.reload()
            else{ 
                parselimit-=1
                curmin=Math.floor(parselimit/60)
                cursec=parselimit%60
                if (curmin!=0)
                    curtime=curmin+" minutes and "+cursec+" seconds left until page refresh!"
                else
                    curtime=cursec+" seconds left until page refresh!"
                window.status=curtime
                setTimeout("beginrefresh()",1000)
            }
        }

        window.onload=beginrefresh
        //-->
    </script>


    <div class="content">

<?php
print "<div style=\"margin-bottom:5; margin-left:1; color:black; font-size:1em; font-weight:bold\"  align='right'>";
print "<p>$userInfo->role: <a href=\"frmUpdateProfile.php\">$userInfo->name</a></p>\n";
print "</div>"
?>
        <?php
        $result = getNewOrders();
        ?>
        <table width="500" border="0" cellspacing="0" cellpadding="1">

            <tr>
                <td colspan="4" height="350">
                    <!-- Table A1 -->

                    <div id="table01" style="position:absolute; width:50px; height:40px; z-index:1; left: 380px; top: 250px">
                        <div align="center">
<?php
$id_table = 1;
include'tables/divtables.php';
?>
                        </div>
                    </div>

                    <!-- Table A2 -->
                    <div id="table02" style="position:absolute; width:50px; height:40px; z-index:1; left: 460px; top: 250px">
                        <div align="center">
<?php
$id_table = 2;
include'tables/divtables.php';
?>
                        </div>
                    </div>

                    <!-- Table A3 -->
                    <div id="table03" style="position:absolute; width:50px; height:40px; z-index:1; left: 540px; top: 250px">
                        <div align="center">
<?php
$id_table = 3;
include'tables/divtables.php';
?> </div>
                    </div>

                    <!-- Table A4 -->
                    <div id="table04" style="position:absolute; width:50px; height:40px; z-index:1; left: 620px; top: 250px">
                        <div align="center">
                            <?php
                            $id_table = 4;
                            include'tables/divtables.php';
                            ?> </div>
                    </div>

                    <!-- Table A5 -->
                    <div id="table05" style="position:absolute; width:50px; height:40px; z-index:1; left: 700px; top: 250px">
                        <div align="center">
                            <?php
                            $id_table = 5;
                            include'tables/divtables.php';
                            ?> </div>
                    </div>

                    <!-- Table B6 -->
                    <div id="table06" style="position:absolute; width:50px; height:40px; z-index:1; left: 380px; top: 440px">
                        <div align="center">
                            <?php
                            $id_table = 6;
                            include'tables/divtables.php';
                            ?> </div>
                    </div>

                    <!-- Table B7 -->
                    <div id="table07" style="position:absolute; width:50px; height:40px; z-index:1; left: 460px; top: 440px">
                        <div align="center">
                            <?php
                            $id_table = 7;
                            include'tables/divtables.php';
                            ?>
                        </div>
                    </div>

                    <!-- table B8 -->
                    <div id="table08" style="position:absolute; width:50px; height:40px; z-index:1; left: 540px; top: 440px">
                        <div align="center">
                            <?php
                            $id_table = 8;
                            include'tables/divtables.php';
                            ?> </div>
                    </div>

                    <!-- Table B9 -->
                    <div id="table09" style="position:absolute; width:50px; height:40px; z-index:1; left: 620px; top: 440px">
                        <div align="center">
                            <?php
                            $id_table = 9;
                            include'tables/divtables.php';
                            ?> </div>
                    </div>

                    <!-- Table B10 -->
                    <div id="table10" style="position:absolute; width:50px; height:40px; z-index:1; left: 700px; top: 440px">
                        <div align="center">
                            <?php
                            $id_table = 10;
                            include'tables/divtables.php';
                            ?> </div>
                    </div>
                </td>
            <tr><td><br/><br/><br/></td></tr>
            </tr>

            <tr>
                <th>Color code</th>
                <th>Description</th>
            </tr>
            <tr>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td bgcolor="#FFCC99" ></td>
                <td>&nbsp;No Orders/Paid/Cancel</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td bgcolor="#FF6600"></td>
                <td>&nbsp;New Order</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td bgcolor="#FF6666"></td>
                <td>&nbsp;Order Confirmed</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td bgcolor="#FF9966"></td>
                <td>&nbsp;Food Delivered</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td bgcolor="#CC0000"></td>
                <td>&nbsp;Order Rejected</td>
            </tr>
        </table>

        <br/><br/>
    </div>
</body>

<?php
print $template[1];
?>