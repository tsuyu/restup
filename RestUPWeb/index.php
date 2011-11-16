<?php

$page_title = "Login Page";

if (is_file("template/template.htm")) {
    $template = file_get_contents("template/template.htm");
    $template = str_replace('{TITLE}', $page_title, $template);
    $template = explode('{CONTENT}', $template);
}

print $template[0];
?>
<script type="text/javascript">
    function IsNotNull(){
        if (document.form1.userid == null ||
            document.form1.password == null) {

            alert("Please fill out all the fields.");
            return false;
        }
        if (document.form1.userid.value.length == 0 ||
            document.form1.password.value.length == 0) {
            alert("Please fill out all the fields.");
            return false;
        }
        return true;
    }
    function checkfields() {
        if (IsNotNull() == false) {
            return false;
        }
    }
</script>
<body bgcolor="white">

    <!--
    This is the sign in page. The user has to enter an email address and a
    password. The user can select the Remember me check box, so that he does
    not have to sign in each time he starts the application. There are also
    links from this page to enable the user to register (registerOutline.php),
    or to request a new password (newpassword.html).
    -->

    <p>To sign in, enter your email and password, and click the <b>Sign in</b> button.</p>
    <div class="box">
        <form name="form1" method="post" action="actHomepage.php" onSubmit='return checkfields();'>
            <p>User Id : <input type="text" name="userid" class="input"></p>
            <p>Password: <input type="password" name="password" class="input"></p>
            <input type="submit" name="Submit" value="Sign in">
        </form>
    </div>


</body>
<?php print $template[1]; ?>
