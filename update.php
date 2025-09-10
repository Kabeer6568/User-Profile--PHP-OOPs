<?php



require_once "user.php";

session_start();

$user = new Users;

if (!isset($_SESSION['user_id'])) {
    header("location: index.php");
}

// $user->checkLogin();

$id = $_GET['id'];

$getData = $user->getByID($id);

$data = $getData->fetch_assoc();

$id = $_GET['id'];


if (isset($_POST['update'])) {


    $user->updateData($id , $_POST['username'] , $_POST['useremail'] , $_POST['userpass'] , $_POST['usernum'] , 
    $_POST['usercity'] , $_POST['usercountry'] , $_FILES['user_img']);    
        
}

?>

<h1>
    Updata Data
</h1>

<form action="" method="post" enctype="multipart/form-data">
    User Name: <input type="text" name="username" value="<?php echo $data['user_name'] ?>">
    <br><br>
    User Email: <input type="email" name="useremail" value="<?php echo $data['user_email'] ?>">
    <br><br>
    User Password: <input type="password" name="userpass" value="">
    <br><br>
    User Phone.no: <input type="tel" name="usernum" value="<?php echo $data['user_num'] ?>">
    <br><br>
    User City: <input type="text" name="usercity" value="<?php echo $data['user_city'] ?>">
    <br><br>
    User Country: <input type="text" name="usercountry" value="<?php echo $data['user_country'] ?>">
    <br><br>
    User Profile: <input type="file" name="user_img" accept= "image/*">
    <br><br>
    <input type="submit" value="Update" name="update">
</form>
<br>
<p>Go back to profile? <a href="profile.php">Click Here</a></p>
