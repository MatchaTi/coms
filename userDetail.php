<?php
include 'includes/connection.php';
include 'includes/functions.php';
include 'components/avatar.php';

session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
}

$nim = isset($_GET['nim']) ? $_GET['nim'] : 0;
$user = getSingleUser($nim);
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

    <title>User Detail | Coms</title>
</head>

<body>
    <?php
    include 'components/dialog.php';
    echo dialog();
    ?>
    <h2 class="heading mb-6">User Detail</h2>

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

    <section class="h-full">
        <div class="mb-10 p-6 grid grid-cols-2 gap-6 rounded border shadow w-full">
            <?php if ($user): ?>
                <div>
                    <h2 class="mb-6 heading-2">KTM</h2>
                    <div class="ktm rounded shadow border">
                        <img src="<?= $user['ktm'] ?>" alt="KTM">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <h2 class=" heading-2">Profile</h2>
                    <div></div>
                    <div class="">
                        <div class="mb-2 font-semibold">Fullname:</div>
                        <div class="w-full red p-c rounded-lg border shadow"><?= $user['fullname'] ?></div>
                    </div>
                    <div class="">
                        <div class="mb-2 font-semibold">Username:</div>
                        <div class="w-full orange p-c rounded-lg border shadow"><?= $user['username'] ?></div>
                    </div>
                    <div class="">
                        <div class="mb-2 font-semibold">NIM:</div>
                        <div class="w-full yellow p-c rounded-lg border shadow"><?= $user['nim'] ?></div>
                    </div>
                    <div class="">
                        <div class="mb-2 font-semibold">Email:</div>
                        <div class="w-full green p-c rounded-lg border shadow"><?= $user['email'] ?></div>
                    </div>
                    <div class="">
                        <div class="mb-2 font-semibold">Joined at</div>
                        <div class="w-full blue p-c rounded-lg border shadow"><?= $user['joined_at'] ?></div>
                    </div>
                    <div class="mb-6">
                        <div class="mb-2 font-semibold">Status</div>
                        <div class="w-full purple p-c rounded-lg border shadow"><?= $user['status'] ? 'Aktif' : 'Belum Aktif' ?></div>
                    </div>
                    <div class="flex justify-end">
                        <?php if ($user['status']): ?>
                            <a href="adminApproveUser.php?nim=<?= $user['nim'] ?>&status=delete" class="py-4 px-6 red w-full text-center shadow border rounded" onclick="return confirmPrompt('Delete','Are you sure you want to delete this user?', 'adminApproveUser.php?nim=<?= $user['nim'] ?>&status=delete')">
                                <span class="font-bold">Delete</span>
                            </a>
                        <?php else: ?>
                            <div class="w-full flex items-center justify-between gap-6">
                                <a href="adminApproveUser.php?nim=<?= $user['nim'] ?>&status=approve" class="py-4 px-6 green w-full text-center shadow border rounded" onclick="return confirmPrompt('Approve','Are you sure you want to approve this user?', 'adminApproveUser.php?nim=<?= $user['nim'] ?>&status=approve')">
                                    <span class="font-bold">Approve</span>
                                </a>
                                <a href="adminApproveUser.php?nim=<?= $user['nim'] ?>&status=reject" class="py-4 px-6 red w-full text-center shadow border rounded" onclick="return confirmPrompt('Reject','Are you sure you want to reject this user?', 'adminApproveUser.php?nim=<?= $user['nim'] ?>&status=reject')">
                                    <span class="font-bold">Reject</span>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <div>User tidak ditemukan</div>
            <?php endif; ?>
        </div>
    </section>

    <script src="js/script.js"></script>
    <script src="js/dialog.js"></script>
    <script src="js/navbar.js"></script>
    <script src="js/admin.js"></script>
</body>

</html>