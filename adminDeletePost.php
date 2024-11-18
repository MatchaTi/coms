<?php
require 'includes/connection.php';
require 'includes/functions.php';

session_start();

$user = $_SESSION['user'];
$userId = $_GET['id'];
if (!isset($user) || $user['role'] == 'user') {
    header('Location: login.php');
}

deletePost($conn, $userId);
header('Location: admin.php');
?>