<?php
include 'includes/connection.php';
include 'includes/functions.php';

session_start();

$user = $_SESSION['user'];
if (!isset($user)) {
    header('Location: login.php');
}

deleteAccount($conn, $user['id']);

logOut();
?>