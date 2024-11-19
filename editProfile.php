<?php
include 'includes/connection.php';
include 'includes/functions.php';
include 'components/dialog.php';

session_start();

$user = $_SESSION['user'];
if (!isset($user)) {
    header('Location: login.php');
}

$userProfile = getProfileUser($user['nim']);

if (!$userProfile['status']) {
    echo "<script>alert('" . addslashes($userProfile['message']) . "'); setTimeout(function() { window.location.href = 'index.php'; }, 0);</script>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $fullname = htmlspecialchars($_POST['fullname']);
    $bio = htmlspecialchars($_POST['bio']);
    $newPassword = htmlspecialchars($_POST['newPassword']);
    $password = htmlspecialchars($_POST['password']);
    $photoProfile = isset($_FILES['photoProfile']) ? $_FILES['photoProfile'] : null;
    $linkInstagram = htmlspecialchars($_POST['instagram']);
    $linkFacebook = htmlspecialchars($_POST['facebook']);
    $linkGithub = htmlspecialchars($_POST['github']);
    $linkLinkedin = htmlspecialchars($_POST['linkedin']);
    $deletePhotoProfile = (bool) $_POST['deletePhotoProfile'];

    $result = editProfile($user['nim'], $username, $fullname, $bio, $newPassword, $password, $photoProfile, $linkInstagram, $linkFacebook, $linkGithub, $linkLinkedin, $deletePhotoProfile);
    if (!$result['status']) {
        echo "<script>alert('" . addslashes($result['message']) . "'); setTimeout(function() { window.location.href = 'editProfile.php'; }, 0);</script>";
    } else {
        echo "<script>alert('" . addslashes($result['message']) . "'); setTimeout(function() { window.location.href = 'profile.php?nim=" . $user['nim'] . "'; }, 0);</script>";
    }
}

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

    <!-- favicon -->
    <link rel="shortcut icon" href="favicon.svg" type="image/x-icon">

    <title>Edit Profile | COMS</title>
</head>

<body>
    <?php
    include 'components/navbar.php';
    echo navbar();
    echo dialog();
    ?>
    <h2 class="heading text-center mb-6">Edit Profile</h2>

    <section class="mb-6 p-c cream border rounded-lg shadow">
        <div class="flex items-center justify-between mb-2">
            <div>
                <h3 class="profile-fullname heading text-lg"><?= $userProfile['user']['fullname'] ?></h3>
                <div class="profile-username"><?= $userProfile['user']['username'] ?></div>
            </div>
            <?php
            include 'components/avatar.php';
            echo renderAvatar($userProfile['user']['username'], $userProfile['user']['photo'], 'avatar-lg', 'Photo Profile');
            ?>
        </div>
        <div class="profile-bio mb-2"><?= $userProfile['user']['bio'] ?></div>
        <div class="mb-6 text-sm">Joined at <?= $userProfile['user']['joined_at'] ?></div>
    </section>

    <form action="" method="POST" class="mb-6 p-c w-full cream border shadow rounded-lg" enctype="multipart/form-data">
        <div class="flex gap-6">
            <div class="mb-6 w-full">
                <label for="username" class="heading block mb-2">Username</label>
                <input type="text" name="username" id="username" placeholder="Ex: fuyu" class="w-full red p-c rounded-lg border shadow" value="<?= $userProfile['user']['username'] ?>" maxlength="25">
            </div>
            <div class="mb-6 w-full">
                <label for="fullname" class="heading block mb-2">Fullname</label>
                <input type="text" name="fullname" id="fullname" placeholder="Ex: Raana Fuyu" class="w-full yellow p-c rounded-lg border shadow" value="<?= $userProfile['user']['fullname'] ?>" maxlength="25">
            </div>
        </div>
        <div class="mb-6">
            <label for="bio" class="heading block mb-2">Bio</label>
            <textarea name="bio" id="bio" class="w-full light-green p-c rounded-lg border shadow" maxlength="75" placeholder="Your Bio"><?= $userProfile['user']['bio'] ?></textarea>
        </div>
        <div class="flex gap-6">
            <div class="mb-6 w-full">
                <label for="newPassword" class="heading block mb-2">New Password</label>
                <input type="password" name="newPassword" id="newPassword" placeholder="New password min 4 characters" class="w-full pink p-c rounded-lg border shadow">
            </div>
            <div class="mb-6 w-full">
                <label for="password" class="heading block mb-2">Current Password</label>
                <input type="password" name="password" id="password" placeholder="Current password min 4 characters" class="w-full blue p-c rounded-lg border shadow" required>
            </div>
        </div>
        <div class="mb-6">
            <label for="photoProfile" class="heading block mb-2">Photo Profile</label>
            <input type="file" name="photoProfile" id="photoProfile" class="mb-6 w-full purple p-c rounded-lg border shadow" onclick="addPhoto()">
            <input type="hidden" class="indicator-delete-photo" name="deletePhotoProfile" value="0">
            <button type="button" class="btn-delete-photo btn px-4 py-2 red rounded shadow border font-medium <?= $userProfile['user']['photo'] ? "" : "hidden" ?>" onclick="return deletePhoto()">Delete Photo Profile</button>
        </div>
        <div class="mb-6 grid grid-cols-2 gap-6">
            <div class="w-full">
                <label for="instagram" class="heading block mb-2">Instagram</label>
                <input type="text" name="instagram" id="instagram" placeholder="Ex: fuyu" class="w-full pink p-c rounded-lg border shadow" value="<?= $userProfile['user']['link_instagram'] ?>" maxlength="100">
            </div>
            <div class="w-full">
                <label for="facebook" class="heading block mb-2">Facebook</label>
                <input type="text" name="facebook" id="facebook" placeholder="Ex: Raana Fuyu" class="w-full blue p-c rounded-lg border shadow" value="<?= $userProfile['user']['link_facebook'] ?>" maxlength="100">
            </div>
            <div class="w-full">
                <label for="github" class="heading block mb-2">Github</label>
                <input type="text" name="github" id="github" placeholder="Ex: Raana Fuyu" class="w-full white p-c rounded-lg border shadow" value="<?= $userProfile['user']['link_github'] ?>" maxlength="100">
            </div>
            <div class="w-full">
                <label for="linkedin" class="heading block mb-2">Linkedin</label>
                <input type="text" name="linkedin" id="linkedin" placeholder="Ex: Raana Fuyu" class="w-full light-green p-c rounded-lg border shadow" value="<?= $userProfile['user']['link_linkedin'] ?>" maxlength="100">
            </div>
        </div>
        <div class="flex items-center justify-between">
            <a href="deleteAccount.php" type="button" class="btn px-4 py-2 red rounded shadow border font-medium" onclick="return confirmPrompt('Delete Account','Are you sure you want to delete this account?', 'deleteAccount.php')">Delete Account</a>
            <div class="flex items-center gap-3">
                <a href="/issue-sedunia" class="btn px-4 py-2 purple rounded shadow border font-medium">Cancel</a>
                <button type="submit" class="btn px-4 py-2 green rounded shadow border font-medium">Update Profile</button>
            </div>
        </div>
    </form>

    <script src="js/editProfile.js"></script>
    <script src="js/dialog.js"></script>
</body>

</html>