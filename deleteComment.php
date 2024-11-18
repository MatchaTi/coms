<?php
require 'includes/connection.php';
require 'includes/functions.php';

session_start();

$user = $_SESSION['user'];
$postId = $_GET['id'];
$commentId = $_GET['commentId'];

$result = getSingleComment($conn, $commentId);

if ($result['user_id'] != $user['id']) {
    header('Location: post.php?id=' . $postId);
} else {
    deleteComment($conn, $commentId);
    header('Location: post.php?id=' . $postId);
}

?>