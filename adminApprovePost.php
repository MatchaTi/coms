<?php
include 'includes/functions.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
}

$status = $_GET['status'];
$id = $_GET['id'];


if ($status == 'approve') {
    $result = approvePost($id);
    if ($result['status']) {
        echo "<script>alert('" . $result['message'] . "')</script>";
        header('Location: manajemenPost.php');
    }
} else if ($status == 'reject') {
    $result = rejectPost($id);
    if ($result['status']) {
        echo "<script>alert('" . $result['message'] . "')</script>";
        header('Location: manajemenPost.php');
    }
} else if ($status == 'delete') {
    $result = deletePost($id);
    if ($result['status']) {
        echo "<script>alert('" . $result['message'] . "')</script>";
        header('Location: manajemenPost.php');
    }
}
?>