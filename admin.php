<?php
include 'components/avatar.php';
include 'includes/functions.php';

session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
}

$totalUser = getTotalUsers();
$totalPost = getTotalPosts();
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
    <?php
    include 'components/navbarAdmin.php';
    ?>
    <section>
        <h1 class="heading-2 mb-6">Dashboard</h1>
        <div class="grid grid-cols-2 gap-6">
            <a href="manajemenUser.php" class="p-6 rounded border shadow">
                <h2 class="heading-2 mb-6">Total User</h2>
                <div class="flex items-center gap-6">
                    <h3 class="heading-3"><?= $totalUser ?> users</h3>
                </div>
            </a>
            <a href="manajemenPost.php" class="p-6 rounded border shadow">
                <h2 class="heading-2 mb-6">Total Post</h2>
                <div class="flex items-center gap-6">
                    <h3 class="heading-3"><?= $totalPost ?> posts</h3>
                </div>
            </a>
        </div>
    </section>
</body>

</html>