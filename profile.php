<?php

require_once "user.php";

session_start();

$user = new Users;

if (!isset($_SESSION['user_id'])) {
    header("location: index.php");
}

$id = $_SESSION['user_id'];

$getData = $user->profile_data($id);
$rows = $getData->fetch_assoc();

?>

<h1>Profile Data</h1>


STUDENT NAME: <?php echo $rows['user_name']; ?>
<br><br>
STUDENT EMAIL: <?php echo $rows['user_email'] ;?>
<br><br>
STUDENT PHONE.NO: <?php echo $rows['user_num'] ;?>
<br><br>
STUDENT CITY: <?php echo $rows['user_city'] ;?>
<br><br>
STUDENT COUNTRY: <?php echo $rows['user_country'] ;?>
<br><br>
STUDENT PROFILE IMAGE: <br><img src="<?php echo $rows['user_profile_img'] ;?>" style="width: 100px">
<br><br>
<br>

<button>
    <a href="update.php?id=<?php echo $id; ?>">
        UPDATE DATA
    </a>
</button>