<?php
include 'includes/connection.php';
include 'includes/functions.php';
include 'components/avatar.php';
include 'components/dialog.php';

session_start();

$user = $_SESSION['user'];
if (!isset($user)) {
  header('Location: login.php');
}

if (isset($_POST['comment'])) {
  $postId = $_GET['id'];
  $userNim = $user['nim'];
  $content = $_POST['content'];

  $result = addComment($postId, $userNim, $content);
  echo "<script>alert('" . $result['message'] . "');</script>";
}


$post = getSinglePost($_GET['id']);
if ($post['status']) {
  incrementWatchingCounter($_GET['id']);
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

  <title><?= $post['title']; ?> | COMS</title>
</head>

<body>
  <?php
  include 'components/navbar.php';
  echo navbar();
  echo dialog();
  ?>
  <h2 class="heading text-center mb-6">Posts</h2>

  <dialog class="dialog-edit-comment cream shadow border rounded-lg">
    <div class="p-c border-b grid grid-cols-3">
      <div class="flex gap-3 items-center">
        <div class="w-5 h-5 rounded-full shadow border red"></div>
        <div class="w-5 h-5 rounded-full shadow border yellow"></div>
        <div class="w-5 h-5 rounded-full shadow border green"></div>
      </div>
      <h2 class="text-center font-bold">Edit Comment</h2>
      <button type="button" class="cancel-edit-comment text-end font-medium">Cancel</button>
    </div>
    <div class="p-c flex gap-6">
      <?php
      echo renderAvatar($user['username'], $user['photo']);
      ?>
      <form action="" class="w-full" enctype="multipart/form-data" method="POST">
        <div class="mb-6">
          <label for="content" class="heading block mb-2">Description Post</label>
          <input type="text" name="content" id="content" placeholder="What's your describe about this post" class="w-full yellow p-c rounded-lg border shadow">
        </div>
        <button type="submit" class="btn auth w-full px-6 font-bold py-2 flex text-center justify-center border shadow rounded-lg">Post</button>
      </form>
    </div>
  </dialog>

  <?php if ($post): ?>
    <article class="flex gap-6 mb-6 <?= !$post['status'] ? "pending" : "" ?>">
      <?php
      echo renderAvatar($post['user']['username'], $post['user']['photo'], 'avatar', 'Photo Profile', 'post-avatar-desktop mt-3');
      ?>
      <div class="w-full cream shadow border rounded-lg">
        <div class="p-c flex items-center justify-between border-b flex-wrap gap-3">
          <div class="flex items-center gap-3">
            <?php
            echo renderAvatar($post['user']['username'], $post['user']['photo'], 'avatar', 'Photo Profile', 'post-avatar-mobile');
            ?>
            <a href="profile.php?id=<?= $post['user']['nim'] ?>" class="heading capitalize"><?= $post['user']['username']; ?></a>
            <p class="text-sm"><?= explode(' ', $post['created_at'])[0]; ?></p>
          </div>
          <div class="flex items-center gap-3 flex-wrap">
            <div class="capitalize px-6 py-1 font-medium border rounded shadow <?= $post['category']; ?>"><?= $post['category'] ?></div>
            <?php if (!$post['status']): ?>
              <div class="capitalize px-4 py-1 font-medium border rounded shadow red"><?= !$post['status'] ? "Pending" : "" ?></div>
            <?php endif; ?>
            <?php if ($user['nim'] == $post['user']['nim']): ?>
              <button type="button" class="relative btn-floating w-10 h-10 flex items-center justify-center light-green border shadow rounded">
                <img src="assets/icons/menu.svg" alt="menu">
                <div class="floating-action cream border shadow rounded">
                  <a href="editPost.php?id=<?= $post['id'] ?>" class="block px-6 py-2 font-medium border-b"">Edit</a>
                                    <a href=" deletePost.php?id=<?= $post['id'] ?>" class="block px-6 py-2 font-medium" onclick="return confirmPrompt('Delete Post','Are you sure want to delete this post?', 'deletePost.php?id=<?= $post['id'] ?>')">Delete</a>
                </div>
              </button>
            <?php endif; ?>
          </div>
        </div>
        <div class="px-6 mt-6 mb-3">
          <h3 class="px-6 py-4 heading border rounded shadow blue"><?= $post['title']; ?></h3>
        </div>
        <div class="px-6 text-justify"><?= $post['description']; ?></div>
        <?php if ($post['photo']): ?>
          <div class="px-6">
            <div class="post-photo w-full rounded shadow border">
              <img src="<?= $post['photo'] ?>" alt="Post Image">
            </div>
          </div>
        <?php endif ?>
        <div class="p-c flex items-center gap-3 flex-wrap">
          <div class="px-6 py-1 flex gap-1 font-medium border shadow rounded-full red">
            <img src="assets/icons/comment.svg" alt="comment">
            <div><?= count($post['comments']) ?></div>
          </div>
          <div class="px-6 py-1 flex gap-1 font-medium border shadow rounded-full yellow">
            <img src="assets/icons/views.svg" alt="views">
            <div><?= $post['counter_views'] ?></div>
          </div>
          <button class="px-6 py-1 flex gap-1 font-medium border shadow rounded-full green" onclick="shareLink(<?= $post['id'] ?>)">
            <img src="assets/icons/share.svg" alt="share">
          </button>
        </div>
      </div>
    </article>
    <?php if ($post['status']): ?>
      <article class="flex gap-6 mb-6">
        <?php
        echo renderAvatar($user['username'], $user['photo'], 'avatar', 'Photo Profile');
        ?>
        <form action="" method="POST" class="w-full">
          <input id="content" name="content" class="mb-3 px-4 py-4 orange w-full rounded shadow border" required placeholder="Add comment..."></input>
          <button type="submit" name="comment" class="border shadow rounded purple px-4 py-1">Submit</button>
        </form>
      </article>
    <?php endif; ?>
    <p class="flex flex-col">
      <?php foreach ($post['comments'] as $comment): ?>
    <article class="flex gap-6 mb-3 <?= $comment['user']['nim'] == $user['nim'] ? "justify-end" : "" ?>">
      <div class="flex items-center gap-3">
        <a href="profile.php?nim=<?= $comment['user']['nim'] ?>" class="flex items-center gap-3 <?= $comment['user']['nim'] == $user['nim'] ? " order-1" : " " ?>">
          <?php
          echo renderAvatar($comment['user']['username'], $comment['user']['photo'], 'comment-avatar', 'Photo Profile', "rounded-full");
          ?>
        </a>
        <div class="<?= $comment['user']['nim'] == $user['nim'] ? "comment-container-right green" : "comment-container-left yellow" ?>  px-4 py-2 border shadow "><?= $comment['content'] ?></div>
      </div>
    </article>
  <?php endforeach; ?>
  </p>
<?php else: ?>
  <div class="p-c rounded-lg shadow border capitalize text-center">No post!</div>
<?php endif; ?>

<script src="js/dialog.js"></script>
<script src="js/script.js"></script>
</body>

</html>
