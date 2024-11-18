<?php
require 'includes/connection.php';
require 'includes/functions.php';
require 'components/avatar.php';

session_start();

$user = $_SESSION['user'];
$postId = $_GET['id'];
$commentId = $_GET['commentId'];

$result = getSingleComment($conn, $commentId);

if ($result['user_id'] != $user['id']) {
    header('Location: post.php?id=' . $postId);
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $content = htmlspecialchars($_POST['content']);
    $result = editComment($conn, $commentId, $content);

    if (!$result['status']) {
        echo "<script>alert('" . addslashes($result['message']) . "'); setTimeout(function() { window.location.href = 'editComment.php?id=$postId&commentId=$commentId'; }, 0);</script>";
    } else {
        echo "<script>alert('" . addslashes($result['message']) . "'); setTimeout(function() { window.location.href = 'post.php?id=$postId'; }, 0);</script>";
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

    <title>Edit Comment | Issue Sedunia</title>
</head>

<body>
    <?php
    include 'components/navbar.php';
    echo navbar();
    ?>

    <section class="dialog cream shadow border rounded-lg">
        <div class="p-c border-b grid grid-cols-3">
            <div class="flex gap-3 items-center">
                <div class="w-5 h-5 rounded-full shadow border red"></div>
                <div class="w-5 h-5 rounded-full shadow border yellow"></div>
                <div class="w-5 h-5 rounded-full shadow border green"></div>
            </div>
            <h2 class="text-center font-bold">Edit Comment</h2>
            <a href="post.php?id=<?= $postId ?>" class="text-end font-medium">Cancel</a>
        </div>
        <div class="p-c flex gap-6">
            <?php
            echo renderAvatar($user['username'], $user['photo']);
            ?>
            <form action="" class="w-full" enctype="multipart/form-data" method="POST">
                <div class="mb-6">
                    <label for="content" class="heading block mb-2">Comment</label>
                    <input type="text" name="content" id="content" placeholder="Your comment..." class="w-full yellow p-c rounded-lg border shadow" value="<?= $result['content'] ?>">
                </div>
                <button type="submit" class="btn auth w-full px-6 font-bold py-2 flex text-center justify-center border shadow rounded-lg">Post</button>
            </form>
        </div>
    </section>
</body>

</html>