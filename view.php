<?php

require_once "user.php";

session_start();



$user = new Users;

if (!isset($_SESSION['user_id'])) {
    header("location: index.php");
}

$id = $_SESSION['user_id'];

$getData = $user->viewAll();


?>

<h1>View All Data</h1>

<table border= 1 >
    <tr>
        <th>Username</th>
        <th>User Email</th>
        <th>User Phone</th>
        <th>User City</th>
        <th>User Country</th>
        <th>User Profile</th>
        <th>UPDATE</th>
        <th>DELETE</th>
    </tr>
    <?php while ($rows = $getData->fetch_assoc()) {
        # code...
     ?>
    <tr>
        <td><?php echo $rows['user_name'] ?></td>
        <td><?php echo $rows['user_email'] ?></td>
        <td><?php echo $rows['user_num'] ?></td>
        <td><?php echo $rows['user_country'] ?></td>
        <td><?php echo $rows['user_city'] ?></td>
        <td><img src="<?php echo $rows['user_profile_img'] ?>" style="width: 100px">
            </td>
        <td><button>
    <a href="update.php?id=<?php echo $rows['id']; ?>">
        UPDATE DATA
    </a>
</button></td>
<td><button>
    <a href="delete.php?id=<?php echo $rows['id'];; ?>">
        DELETE DATA
    </a>
</button></td>
    </tr>
    <?php } ?>
</table>