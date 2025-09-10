<?php

require_once "user.php";

session_start();

$user = new Users;

$user->checkLogin();
?>


<h1>
    Login Here
</h1>

<form action="" method="post" enctype="multipart/form-data">
    User Name/Email: <input type="text" name="username" id="">
    <br><br>
    User Password: <input type="password" name="userpass" id="">
    
    <br><br>
    <input type="submit" value="Login" name="login">
</form>
<br>
<p>Dont have an account? <a href="register.php">Register Here</a></p>

<?php
    if (isset($_POST['login'])) {
    $user->login($_POST['username'] , $_POST['userpass']);
    };

?>



