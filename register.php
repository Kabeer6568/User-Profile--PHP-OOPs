<?php

require_once "user.php";

$user = new Users;



if (isset($_POST['register'])) {

    if (empty($_POST['username']) || empty($_POST['useremail']) || empty($_POST['userpass']) || 
    empty($_POST['usernum']) || empty($_POST['usercity']) || empty($_POST['usercountry']) || 
    empty($_FILES['user_img']['name']) ) {

        echo "one or more fileds are empty";
    }
    elseif ($user->checkemail($_POST['useremail'])) {
        echo "Email already Exists";
    }
    else{
    $user->register($_POST['username'] , $_POST['useremail'] , $_POST['userpass'] , $_POST['usernum'] , 
    $_POST['usercity'] , $_POST['usercountry'] , $_FILES['user_img']);
    }
    
}

?>

<h1>
    Register Here
</h1>

<form action="" method="post" enctype="multipart/form-data">
    User Name: <input type="text" name="username" id="">
    <br><br>
    User Email: <input type="email" name="useremail" id="">
    <br><br>
    User Password: <input type="password" name="userpass" id="">
    <br><br>
    User Phone.no: <input type="tel" name="usernum" id="">
    <br><br>
    User City: <input type="text" name="usercity" id="">
    <br><br>
    User Country: <input type="text" name="usercountry" id="">
    <br><br>
    User Profile: <input type="file" name="user_img" accept= "image/*">
    <br><br>
    <input type="submit" value="Register" name="register">
</form>
<br>
<p>Already have an account? <a href="login.php">Login Here</a></p>
