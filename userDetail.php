<?php
include 'components/avatar.php';
include 'includes/functions.php';

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
        <h1 class="heading-2 mb-6">Manajemen User</h1>
        <div class="mb-10 p-6 grid grid-cols-2 gap-8 rounded border shadow w-full">
            <?php if ($user): ?>
                <div>
                    <h2 class="mb-6 heading-2">KTM</h2>
                    <div class="ktm rounded shadow border">
                        <img src="<?= $user['ktm'] ?>" alt="KTM">
                    </div>
                </div>
                <div class="grid grid-cols-2">
                    <h2 class=" heading-2">Profile</h2>
                    <div></div>
                    <div class="">
                        <div class="mb-2 font-semibold">Fullname:</div>
                        <span><?= $user['fullname'] ?></span>
                    </div>
                    <div class="">
                        <div class="mb-2 font-semibold">Username:</div>
                        <span><?= $user['username'] ?></span>
                    </div>
                    <div class="">
                        <div class="mb-2 font-semibold">NIM:</div>
                        <span><?= $user['nim'] ?></span>
                    </div>
                    <div class="">
                        <div class="mb-2 font-semibold">Email:</div>
                        <span><?= $user['email'] ?></span>
                    </div>
                    <div class="">
                        <div class="mb-2 font-semibold">Joined at</div>
                        <span><?= $user['joined_at'] ?></span>
                    </div>
                    <div class="">
                        <div class="mb-2 font-semibold">Status</div>
                        <span><?= $user['status'] ? 'Aktif' : 'Belum Aktif' ?></span>
                    </div>
                    <div>
                        <?php if ($user['status']): ?>
                            <a href="adminApproveUser.php?nim=<?= $user['nim'] ?>&status=delete" class="py-4 px-4 bg-red w-full text-center shadow border rounded" onclick="return confirm('Are you sure want to delete this account?')">Delete Account</a>
                        <?php else: ?>
                            <div class="w-full flex items-center justify-between gap-6">
                                <a href="adminApproveUser.php?nim=<?= $user['nim'] ?>&status=approve" class="py-4 bg-green w-full text-center shadow border rounded" onclick="return confirm('Are you sure want to approve this account?')">Approve</a>
                                <a href="adminApproveUser.php?nim=<?= $user['nim'] ?>&status=reject" class="py-4 bg-red w-full text-center shadow border rounded" onclick="return confirm('Are you sure want to reject this account?')">Reject</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <div>User tidak ditemukan</div>
            <?php endif; ?>
        </div>
    </section>
</body>

</html>