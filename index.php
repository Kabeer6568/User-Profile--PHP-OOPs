<?php

require_once "user.php";

session_start();

$user = new Users;


if (!isset($_SESSION['user_id'])) {
    echo "You must me login to view this page";
}



