<?php

require_once "user.php";

session_start();

$id = $_GET['id'];

$users = new Users;

$delete_data = $users->deleteData($id);

if ($delete_data) {
    header("location: view.php")''
}
else{
    echo "Error deleting data";
}

?>