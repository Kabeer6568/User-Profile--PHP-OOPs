<?php


require_once "user.php";

session_start();

$users = new Users;

$users->adminPanel();

