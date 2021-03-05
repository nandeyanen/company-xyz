<?php
session_start();
if (!$_SESSION['id']) { //if no session id
    header("location: loginRedirect.php");
}

include_once "../classes/user.php";

$user = new User();
$user_id = $_GET['user_id'];
$user->deleteUser($user_id);
