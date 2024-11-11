<?php
include 'components/avatar.php';

session_start();

if (!isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') {
    header('Location: login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- styles -->
    <link rel="stylesheet" href="css/utilities.css">
    <link rel="stylesheet" href="css/admin.css">

    <title>Admin | Coms</title>
</head>

<body>
    <nav class="navbar bg-cream">
        <div class="">
            <img src="assets/icons/logo.png" alt="logo" class="mb-10">
            <div class="">
                <div class="mb-6">
                    <a href="admin.php" class="font-semibold">Dashboard</a>
                </div>
                <div class="">
                    <a href="manajemenUser.php" class="flex gap-4 items-center mb-6">
                        <div class="px-4 py-2 rounded-full border shadow bg-blue">
                            <img src="assets/icons/profile.svg" alt="Manajemen User">
                        </div>
                        <span class="font-semibold">Manajemen User</span>
                    </a>
                    <a href="manajemenPost.php" class="flex gap-4 items-center">
                        <div class="px-4 py-2 rounded-full border shadow bg-green">
                            <img src="assets/icons/post.svg" alt="Manajemen Post">
                        </div>
                        <span class="font-semibold">Manajemen Post</span>
                    </a>
                </div>
            </div>
        </div>
        <div>logout</div>
    </nav>
    <section>hello</section>
</body>

</html>