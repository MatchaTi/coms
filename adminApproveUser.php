<?php
include 'includes/functions.php';

$status = $_GET['status'];
$nim = $_GET['nim'];

if ($status == 'approve') {
    $result = updateStatusUser($nim);
    if ($result['status']) {
        echo "<script>alert('" . $result['message'] . "')</script>";
        header('Location: manajemenUser.php');
    }
} else if ($status == 'reject') {
    $result = rejectStatusUser($nim);
    if ($result['status']) {
        echo "<script>alert('" . $result['message'] . "')</script>";
        header('Location: manajemenUser.php');
    }
} else if ($status == 'delete') {
    $result = deleteUser($nim);
    if ($result['status']) {
        echo "<script>alert('" . $result['message'] . "')</script>";
        header('Location: manajemenUser.php');
    }
}
?>