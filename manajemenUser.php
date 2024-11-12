<?php
include 'components/avatar.php';
include 'includes/functions.php';

session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
}

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$result = getAllUsers(true, $page);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $result = searchUser($name);
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
        <a href="logout.php" class="flex gap-4 items-center" onclick="return confirm('Are you sure want to logout?')">
            <div class="px-4 py-2 rounded-full border shadow bg-red">
                <img src="assets/icons/logout.svg" alt="Logout">
            </div>
            <span class="font-semibold">Logout</span>
        </a>
    </nav>

    <section>
        <h1 class="heading-2 mb-6">Manajemen User</h1>
        <form action="" class="mb-6" method="POST">
            <input type="text" name="name" class="p-6 rounded border shadow w-full" placeholder="Search users">
        </form>
        <div class="mb-10 p-6 grid grid-cols-4 gap-6 rounded border shadow w-full">
            <?php if ($result): ?>
                <?php foreach ($result as $user): ?>
                    <div class="p-6 flex flex-column gap-6 justify-center items-center border shadow rounded">
                        <a href="userDetail.php?nim=<?= $user['nim'] ?>" class="">
                            <?php
                            echo renderAvatar($user['username'], $user['photo']);
                            ?>
                        </a>
                        <a href="userDetail.php?nim=<?= $user['nim'] ?>" class=" heading-2"><?= $user['fullname']; ?></a>
                        <a href="userDetail.php?nim=<?= $user['nim'] ?>" class=" font-semibold"><?= $user['nim']; ?></a>
                        <?php if ($user['status']): ?>
                            <a href="adminApproveUser.php?nim=<?= $user['nim'] ?>&status=delete" class="py-4 bg-red w-full text-center shadow border rounded" onclick="return confirm('Are you sure want to delete this account?')">Delete Account</a>
                        <?php else: ?>
                            <div class="w-full flex items-center justify-between gap-6">
                                <a href="adminApproveUser.php?nim=<?= $user['nim'] ?>&status=approve" class="py-4 bg-green w-full text-center shadow border rounded" onclick="return confirm('Are you sure want to approve this account?')">Approve</a>
                                <a href="adminApproveUser.php?nim=<?= $user['nim'] ?>&status=reject" class="py-4 bg-red w-full text-center shadow border rounded" onclick="return confirm('Are you sure want to reject this account?')">Reject</a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div>Belum Ada User</div>
            <?php endif; ?>
        </div>
        <div class="flex items-center justify-end">
            <div class="">
                <?php if ($page > 1): ?>
                    <a href="manajemenUser.php?page=<?= $page - 1; ?>" class="py-4 px-6 bg-blue w-full text-center shadow border rounded">Previous</a>
                <?php endif; ?>
                <?php if ($result): ?>
                    <a href="manajemenUser.php?page=<?= $page + 1; ?>" class="py-4 px-6 bg-blue w-full text-center shadow border rounded">Next</a>
                <?php endif; ?>
            </div>
        </div>
    </section>
</body>

</html>