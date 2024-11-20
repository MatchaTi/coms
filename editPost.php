<?php
include 'includes/functions.php';
include 'components/nextDialog.php';

session_start();


$postId = $_GET['id'];
$singlePost = getSinglePost($postId);
$user = $_SESSION['user'];
if (!isset($user)) {
  header('Location: login.php');
}

if ($user['nim'] != $singlePost['user']['nim']) {
  header('Location: index.php');
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $categoryId = (int) $_POST['category'];
  $title = htmlspecialchars($_POST['title']);
  $content = htmlspecialchars($_POST['content']);
  $imgFile = isset($_FILES['img']) ? $_FILES['img'] : null;
  $deletePostPhoto = (bool) $_POST['deletePostPhoto'];
  $result = editPost($postId, $title, $content, $categoryId, $imgFile, $deletePostPhoto);

  if (!$result['status']) {
    echo nextDialog("editPost.php?id=$postId");
    echo "<script src='js/nextDialog.js'></script>";
    echo "<script> 
    next(
        'Edit Post', 
        '" . $result['message'] . "'
    );
    </script>";
  } else {
    echo nextDialog("post.php?id=$postId");
    echo "<script src='js/nextDialog.js'></script>";
    echo "<script> 
    next(
        'Edit Post', 
        '" . $result['message'] . "'
    );
    </script>";
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
  <title>Edit Post | COMS</title>
</head>

<body>
  <?php
  include 'components/navbar.php';
  echo navbar();
  ?>

  <div class="music-container hidden p-c cream border shadow rounded-lg">
    <h2 class="font-bold mb-6">Soundboard</h2>
  </div>

  <section class="dialog cream shadow border rounded-lg">
    <div class="p-c border-b grid grid-cols-3">
      <div class="flex gap-3 items-center">
        <div class="w-5 h-5 rounded-full shadow border red"></div>
        <div class="w-5 h-5 rounded-full shadow border yellow"></div>
        <div class="w-5 h-5 rounded-full shadow border green"></div>
      </div>
      <h2 class="text-center font-bold">Edit Post</h2>
      <a href="index.php" class="text-end font-medium">Cancel</a>
    </div>
    <div class="p-c flex gap-6">
      <div class="avatar white shadow border rounded-full">
        <img src="https://ui-avatars.com/api/?name=<?= $user['username'] ?>" alt="Avatar">
      </div>
      <form action="" class="w-full" enctype="multipart/form-data" method="POST">
        <div class="mb-6">
          <label for="category" class="heading block mb-2">Category</label>
          <select name="category" id="category" class="px-6 py-2 purple rounded shadow border w-full">
            <option value="1" selected>Front-End</option>
            <option value="2">Back-End</option>
            <option value="3">Full-Stack</option>
          </select>
        </div>
        <div class="mb-6">
          <label for="title" class="heading block mb-2">Title Post</label>
          <input type="text" name="title" id="title" placeholder="Raana! What's new? (Max 50 characters!)" class="w-full blue p-c rounded-lg border shadow" maxlength="50" value="<?= $singlePost['title'] ?>">
        </div>
        <div class="mb-6">
          <label for="content" class="heading block mb-2">Description Post</label>
          <input type="text" name="content" id="content" placeholder="What's your describe about this post" class="w-full yellow p-c rounded-lg border shadow" value="<?= $singlePost['description'] ?>">
        </div>
        <div class="mb-10">
          <label for="img" class="heading block mb-2">Photo Post</label>
          <input type="file" name="img" id="img" class=" mb-6 w-full light-green p-c rounded-lg border shadow" value="<?= $singlePost['photo'] ?>" onclick="addPhoto()">
          <?php if ($singlePost['photo']): ?>
            <div class="post-photo px-6 mb-6">
              <div class="post-photo w-full rounded shadow border">
                <img src="<?= $singlePost['photo'] ?>" alt="Post Image">
              </div>
            </div>
            <button type="button" class="btn-delete-post-photo px-4 py-2 red rounded shadow border font-medium" onclick="return deletePhoto()">Delete Photo Post</button>
          <?php endif ?>
          <input type="hidden" class="indicator-delete-photo" name="deletePostPhoto" value="0">
        </div>
        <button type="submit" class="btn auth w-full px-6 font-bold py-2 flex text-center justify-center border shadow rounded-lg">Edit Post</button>
      </form>
    </div>
  </section>

  <script src="js/editPost.js"></script>
</body>

</html>
