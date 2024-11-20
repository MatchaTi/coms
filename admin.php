<?php
include 'includes/functions.php';
include 'components/avatar.php';

session_start();

$user = $_SESSION['user'];
if (!isset($user) || $user['role'] == 'user') {
    header('Location: login.php');
}

$totalUsers = getTotalUsers();
$totalPosts = getTotalPosts();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

    <!-- styles -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/components.css">
    <link rel="stylesheet" href="css/admin.css">

    <!-- favicon -->
    <link rel="shortcut icon" href="favicon.svg" type="image/x-icon">

    <title>Admin | Coms</title>
</head>

<body>
    <?php
    include 'components/dialog.php';
    echo dialog();
    ?>
    <h2 class="heading mb-6">Admin Dashboard</h2>

    <nav class="px-4 navbar cream shadow border rounded-full">
        <div class="w-full">
            <a href="index.php" class="logo rounded-full mb-6">
                <img src="assets/icons/logo.png" alt="logo">
            </a>
            <div class="">
                <a href="admin.php" class="dashboard mb-6 px-6 py-3 flex gap-3 items-center border shadow rounded-full yellow">
                    <img src="assets/icons/dashboard.svg" alt="Dashboard">
                    <span class="font-bold">Dashboard</span>
                </a>
                <a href="manajemenUser.php" class="profile mb-6 px-6 py-3 flex gap-3 items-center rounded-full">
                    <img src="assets/icons/profile.svg" alt="Profile">
                    <span class="font-bold">Manajemen User</span>
                </a>
                <a href="manajemenPost.php" class="posts mb-6 px-6 py-3 flex gap-3 items-center rounded-full">
                    <img src="assets/icons/post.svg" alt="Posts">
                    <span class="font-bold">Manajemen Post</span>
                </a>
            </div>
        </div>
        <div>
            <a href="logout.php" class="logout setting-icon setting px-6 py-3 flex items-center gap-3 rounded-full" onclick="return confirmPrompt('Logout','Are you sure you want to logout?', 'logout.php')">
                <img src="assets/icons/logout.svg" alt="logout">
                <span class="font-bold">Logout</span>
            </a>
        </div>
    </nav>

    <section class="h-full grid grid-cols-2 gap-6">
        <a href="manajemenUser.php" class="px-6 py-6 flex items-center justify-center flex-col gap-6 shadow border rounded h-full pink">
            <div class="heading">Total Users</div>
            <div class="font-bold"><?= $totalUsers ?></div>
        </a>
        <a href="manajemenPost.php" class="px-6 py-6 flex items-center justify-center flex-col gap-6 shadow border rounded h-full orange">
            <div class="heading">Total Posts</div>
            <div class="font-bold"><?= $totalPosts ?></div>
        </a>
    </section>

    <script src="js/script.js"></script>
    <script src="js/dialog.js"></script>
    <script src="js/navbar.js"></script>
    <script src="js/admin.js"></script>
</body>

</html>
