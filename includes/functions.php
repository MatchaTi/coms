<?php
include 'connection.php';

function register($nim, $username, $fullname, $email, $password, $ktm)
{
  global $conn;

  if (strlen($nim) < 10) {
    return [
      "status" => false,
      "message" => "NIM must be 10 characters"
    ];
  }

  $sql = "SELECT * FROM users WHERE nim='$nim'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    return [
      "status" => false,
      "message" => "NIM already exists"
    ];
  }

  $sql = "SELECT * FROM users WHERE username='$username'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    return [
      "status" => false,
      "message" => "Username already exists"
    ];
  }

  $sql = "SELECT * FROM users WHERE fullname='$fullname'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    return [
      "status" => false,
      "message" => "Fullname already exists"
    ];
  }

  $sql = "SELECT * FROM users WHERE email='$email'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    return [
      "status" => false,
      "message" => "Email already exists"
    ];
  }

  if (strlen($password) < 4) {
    return [
      "status" => false,
      "message" => "Password must be at least 4 characters"
    ];
  }

  $ktmPath = null;

  if (empty($ktm['name'])) {
    return [
      "status" => false,
      "message" => "KTM must be uploaded"
    ];
  }

  if ($ktm['error'] == UPLOAD_ERR_OK) {
    $ktmCheck = checkValidPhoto($ktm);
    if (!$ktmCheck['status']) {
      return $ktmCheck;
    }

    $fileExtention = pathinfo($ktm['name'], PATHINFO_EXTENSION);
    $uniqueName = uniqid("ktm_", true) . '.' . $fileExtention;
    $uploadDir = 'uploads/ktm/';

    if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0777, true);
    }

    $ktmPath = $uploadDir . $uniqueName;

    if (!move_uploaded_file($ktm['tmp_name'], $ktmPath)) {
      return [
        "status" => false,
        "message" => "Failed to upload KTM"
      ];
    }
  }

  $passwordHash = password_hash($password, PASSWORD_DEFAULT);
  $sql = "INSERT INTO users (nim, username, fullname,email, password, ktm) VALUES ('$nim', '$username', '$fullname','$email', '$passwordHash', '$ktmPath')";
  $result = $conn->query($sql);
  if ($result) {
    return [
      "status" => true,
      "message" => "Registration successful"
    ];
  } else {
    return [
      "status" => false,
      "message" => "Registration failed"
    ];
  }
}

function login($nim, $password)
{
  global $conn;

  $sql = "SELECT nim, username, password, photo, role, status FROM users WHERE nim='$nim'";
  $result = $conn->query($sql);
  if ($result->num_rows == 0) {
    return [
      "status" => false,
      "message" => "NIM not found"
    ];
  }

  $user = $result->fetch_assoc();

  if (!password_verify($password, $user['password'])) {
    return [
      "status" => false,
      "message" => "Incorrect password"
    ];
  }

  if (!$user['status']) {
    return [
      "status" => false,
      "message" => "Account not active"
    ];
  }

  return [
    "status" => true,
    "message" => "Login successful",
    "data" => [
      "nim" => $user['nim'],
      "username" => $user['username'],
      "photo" => $user['photo'],
      "role" => $user['role']
    ]
  ];
}

function checkValidPhoto($imgFile)
{
  $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
  if (!in_array($imgFile['type'], $allowedTypes)) {
    return [
      "status" => false,
      "message" => "Only JPEG, PNG, and GIF images are allowed."
    ];
  }

  $maxSize = 2 * 1024 * 1024; // 2MB
  if ($imgFile['size'] > $maxSize) {
    return [
      "status" => false,
      "message" => "File size exceeds the maximum allowed size of 2 MB"
    ];
  }

  return [
    "status" => true,
    "message" => "Valid image."
  ];
}

function getAllUsers($pagination = false, $page = 1, $limit = 8)
{
  global $conn;

  $offset = ($page - 1) * $limit;
  $sql = "SELECT * FROM users WHERE role = 'user' ORDER BY nim";
  if ($pagination) {
    $sql .= " LIMIT $limit OFFSET $offset";
  }
  $result = $conn->query($sql);
  $users = [];
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $users[] = [
        "nim" => $row['nim'],
        "username" => $row['username'],
        "fullname" => $row['fullname'],
        "email" => $row['email'],
        "ktm" => $row['ktm'],
        "photo" => $row['photo'],
        "status" => $row['status']
      ];
    }
  }

  return $users;
}
function updateStatusUser($nim)
{
  global $conn;

  $sql = "UPDATE users SET status = 1 WHERE nim = $nim";
  $result = $conn->query($sql);
  if ($result) {
    return [
      "status" => true,
      "message" => "User enabled successfully"
    ];
  } else {
    return [
      "status" => false,
      "message" => "User failed to enable"
    ];
  }
}

function rejectStatusUser($nim)
{
  global $conn;

  $sql = "DELETE FROM users WHERE nim = $nim";
  $result = $conn->query($sql);
  if ($result) {
    return [
      "status" => true,
      "message" => "User rejected successfully"
    ];
  } else {
    return [
      "status" => false,
      "message" => "User failed to reject"
    ];
  }
}

function deleteUser($nim)
{
  global $conn;

  $sql = "DELETE FROM users WHERE nim = $nim";
  $result = $conn->query($sql);
  if ($result) {
    return [
      "status" => true,
      "message" => "User deleted successfully"
    ];
  } else {
    return [
      "status" => false,
      "message" => "User failed to delete"
    ];
  }
}

function searchUser($name)
{
  global $conn;

  $sql = "SELECT * FROM users WHERE fullname LIKE '%$name%' OR username LIKE '%$name%' OR nim LIKE '%$name%' HAVING role = 'user'";
  $result = $conn->query($sql);
  $users = [];
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $users[] = [
        "nim" => $row['nim'],
        "username" => $row['username'],
        "fullname" => $row['fullname'],
        "email" => $row['email'],
        "ktm" => $row['ktm'],
        "photo" => $row['photo'],
        "status" => $row['status']
      ];
    }
  }

  return $users;
}

function getSingleUser($nim)
{
  global $conn;

  $sql = "SELECT * FROM users WHERE nim = $nim AND role = 'user'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    return [
      "nim" => $row['nim'],
      "username" => $row['username'],
      "fullname" => $row['fullname'],
      "email" => $row['email'],
      "ktm" => $row['ktm'],
      "photo" => $row['photo'],
      "status" => $row['status'],
      "role" => $row['role'],
      "joined_at" => $row['joined_at']
    ];
  }

  return null;
}

function addPost($userNIM, $title, $description, $category, $photo = null)
{
  global $conn;

  $photoPath = null;

  if ($photo['error'] == UPLOAD_ERR_OK) {
    $photoCheck = checkValidPhoto($photo);
    if (!$photoCheck['status']) {
      return $photoCheck;
    }

    $fileExtention = pathinfo($photo['name'], PATHINFO_EXTENSION);
    $uniqueName = uniqid("post_", true) . '.' . $fileExtention;
    $uploadDir = 'uploads/posts/';

    if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0777, true);
    }

    $photoPath = $uploadDir . $uniqueName;

    if (!move_uploaded_file($photo['tmp_name'], $photoPath)) {
      return [
        "status" => false,
        "message" => "Failed to upload photo"
      ];
    }
  }

  $sql = "INSERT INTO posts (user_nim, title, description, category_id, photo) VALUES ('$userNIM', '$title', '$description', '$category', '$photoPath')";
  $result = $conn->query($sql);
  if ($result) {
    return [
      "status" => true,
      "message" => "Post added successfully, please wait for admin approval!"
    ];
  } else {
    return [
      "status" => false,
      "message" => "Post failed to add!"
    ];
  }
}

function getAllPosts($pagination = false, $page = 1, $limit = 4)
{
  global $conn;

  $offset = ($page - 1) * $limit;
  $sql = "SELECT 
                p.id, p.title, p.description, p.photo, p.created_at, p.status, p.counter_views, 
                u.nim, u.username, u.photo AS photoUser, 
                c.name,
                (SELECT COUNT(*) FROM comments WHERE post_id = p.id) AS total_comments
            FROM posts p
            JOIN users u on p.user_nim = u.nim
           JOIN categories c on p.category_id = c.id";

  if ($pagination) {
    $sql .= " ORDER BY p.created_at DESC LIMIT $limit OFFSET $offset";
  } else {
    $sql .= " ORDER BY p.created_at DESC";
  }

  $result = $conn->query($sql);
  $posts = [];
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $posts[] = [
        "id" => $row['id'],
        "title" => $row['title'],
        "description" => $row['description'],
        "photo" => $row['photo'],
        "category" => $row['name'],
        "user" => [
          "nim" => $row['nim'],
          "username" => $row['username'],
          "photo" => $row['photoUser']
        ],
        "created_at" => $row['created_at'],
        "status" => $row['status'],
        "total_comments" => $row['total_comments'],
        "counter_views" => $row['counter_views']
      ];
    }
  }

  return $posts;
}

function approvePost($id)
{
  global $conn;

  $sql = "UPDATE posts SET status = 1 WHERE id = $id";
  $result = $conn->query($sql);
  if ($result) {
    return [
      "status" => true,
      "message" => "Post approved successfully"
    ];
  } else {
    return [
      "status" => false,
      "message" => "Post failed to approve"
    ];
  }
}

function rejectPost($id)
{
  global $conn;

  $sql = "DELETE FROM posts WHERE id = $id";
  $result = $conn->query($sql);
  if ($result) {
    return [
      "status" => true,
      "message" => "Post rejected successfully"
    ];
  } else {
    return [
      "status" => false,
      "message" => "Post failed to reject"
    ];
  }
}

function deletePost($id)
{
  global $conn;

  $sql = "DELETE FROM posts WHERE id = $id";
  $result = $conn->query($sql);
  if ($result) {
    return [
      "status" => true,
      "message" => "Post deleted successfully"
    ];
  } else {
    return [
      "status" => false,
      "message" => "Post failed to delete"
    ];
  }
}

function getSinglePost($id)
{
  global $conn;

  $sql = "SELECT 
                p.id, p.title, p.description, p.photo, p.created_at, p.status, p.counter_views, 
                u.nim, u.username, u.photo AS photoUser, 
                c.name,
                (SELECT COUNT(*) FROM comments WHERE post_id = p.id) AS total_comments
            FROM posts p
            JOIN users u on p.user_nim = u.nim
            JOIN categories c on p.category_id = c.id
            WHERE p.id = $id";

  $result = $conn->query($sql);

  $sqlComments = "SELECT c.id, c.content, c.created_at, u.nim, u.username, u.photo 
                    FROM comments c JOIN users u ON c.user_nim = u.nim 
                    WHERE c.post_id = $id ORDER BY c.created_at DESC";

  $resultComments = $conn->query($sqlComments);

  $comments = [];
  if ($resultComments->num_rows > 0) {
    while ($rowComment = $resultComments->fetch_assoc()) {
      $comments[] = [
        "id" => $rowComment['id'],
        "content" => $rowComment['content'],
        "created_at" => $rowComment['created_at'],
        "user" => [
          "nim" => $rowComment['nim'],
          "username" => $rowComment['username'],
          "photo" => $rowComment['photo']
        ]
      ];
    }
  }

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    return [
      "id" => $row['id'],
      "title" => $row['title'],
      "description" => $row['description'],
      "photo" => $row['photo'],
      "category" => $row['name'],
      "user" => [
        "nim" => $row['nim'],
        "username" => $row['username'],
        "photo" => $row['photoUser']
      ],
      "created_at" => $row['created_at'],
      "status" => $row['status'],
      "total_comments" => $row['total_comments'],
      "counter_views" => $row['counter_views'],
      "comments" => $comments
    ];
  }
}

function getTotalUsers()
{
  global $conn;

  $sql = "SELECT COUNT(*) AS total FROM users WHERE role = 'user'";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  return $row['total'];
}

function getTotalPosts()
{
  global $conn;

  $sql = "SELECT COUNT(*) AS total FROM posts WHERE status = 1";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  return $row['total'];
}

function addComment($postId, $userNim, $content)
{
  global $conn;
  if (empty($content)) {
    return [
      "status" => false,
      "message" => "Comments cannot be empty."
    ];
  }

  $sql = "INSERT INTO comments(content, user_nim, post_id) VALUES('$content', '$userNim', '$postId')";
  $result = $conn->query($sql);
  if ($result) {
    return [
      "status" => true,
      "message" => "Comment success added!"
    ];
  }

  return [
    "status" => false,
    "message" => "Comment failed added!"
  ];
}
function incrementWatchingCounter($id)
{
  global $conn;

  $sql = "UPDATE posts SET counter_views = counter_views + 1 WHERE id = $id";
  $conn->query($sql);
}

function editPost($postId, $title, $content, $categoryId, $imgFile, $removePhoto)
{
  global $conn;
  if (empty($title) || empty($content) || empty($categoryId)) {
    return [
      "status" => false,
      "message" => "Title, Content, and Category cannot be empty."
    ];
  }

  $existingPhoto = null;
  $imagePath = null;
  $sql = "SELECT photo FROM posts WHERE id = $postId";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $existingPhoto = $row['photo'];
    $imagePath = $existingPhoto;
  }

  if ($removePhoto) {
    if ($existingPhoto && file_exists($existingPhoto)) {
      unlink($existingPhoto);
    }
    $imagePath = null;
  } elseif ($imgFile && $imgFile['error'] == UPLOAD_ERR_OK) {
    $photoCheck = checkValidPhoto($imgFile);
    if (!$photoCheck['status']) {
      return $photoCheck;
    }

    if ($existingPhoto && file_exists($existingPhoto)) {
      unlink($existingPhoto);
    }

    $fileExtension = strtolower(pathinfo($imgFile['name'], PATHINFO_EXTENSION));
    $uniqueName = uniqid("post_", true) . "." . $fileExtension;
    $uploadDir = 'uploads/posts/';

    if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0777, true);
    }

    $imagePath = $uploadDir . $uniqueName;
    $imagePath = $uploadDir . basename($imgFile['name']);
    if (!move_uploaded_file($imgFile['tmp_name'], $imagePath)) {
      return [
        "status" => false,
        "message" => "Failed to upload new image."
      ];
    }
  }

  $sql = "UPDATE posts SET title = '$title', description = '$content', category_id = $categoryId, photo = '$imagePath', status = 0 WHERE id = $postId";
  $result = $conn->query($sql);
  if (!$result) {
    return [
      "status" => false,
      "message" => "Failed to update post."
    ];
  }

  return [
    "status" => true,
    "message" => "Post updated successfully, please wait for admin confirmation!"
  ];
}

function getProfileUser($nim)
{
  global $conn;

  $sqlUser = "SELECT * FROM users WHERE nim = $nim";
  $resultUser = $conn->query($sqlUser);
  $user = $resultUser->fetch_assoc();
  $sqlPosts = "SELECT 
                p.id, p.title, p.description, p.photo, p.created_at, p.status, p.counter_views, 
                u.nim, u.username, u.photo AS photoUser, 
                c.name,
                (SELECT COUNT(*) FROM comments WHERE post_id = p.id) AS total_comments
                FROM posts p
                JOIN users u on p.user_nim = u.nim
                JOIN categories c on p.category_id = c.id
                WHERE u.nim = $nim
                ORDER BY p.created_at DESC";
  $resultPosts = $conn->query($sqlPosts);
  $posts = [];
  if ($resultPosts->num_rows > 0) {
    while ($row = $resultPosts->fetch_assoc()) {
      $posts[] = [
        "id" => $row['id'],
        "title" => $row['title'],
        "description" => $row['description'],
        "photo" => $row['photo'],
        "category" => $row['name'],
        "created_at" => $row['created_at'],
        "status" => $row['status'],
        "total_comments" => $row['total_comments'],
        "counter_views" => $row['counter_views']
      ];
    }
  }

  return [
    "status" => true,
    "user" => $user,
    "posts" => $posts
  ];
}

function editProfile($nim, $username, $fullname, $bio, $newPassword, $password, $photoProfile, $linkInstagram, $linkFacebook, $linkGithub, $linkLinkedin, $deletePhotoProfile = false)
{
  global $conn;

  $allUsers = "SELECT username, fullname FROM users";
  $resultAllUsers = $conn->query($allUsers);
  $user = "SELECT username, fullname, password, photo FROM users WHERE nim = $nim";
  $resultUser = $conn->query($user);
  $rowUser = $resultUser->fetch_assoc();
  while ($row = $resultAllUsers->fetch_assoc()) {
    if ($username == $row['username'] && $username != $rowUser['username']) {
      return [
        "status" => false,
        "message" => "Username already exists"
      ];
    }
    if ($fullname == $row['fullname'] && $fullname != $rowUser['fullname']) {
      return [
        "status" => false,
        "message" => "Fullname already exists"
      ];
    }
  }

  if (!password_verify($password, $rowUser['password'])) {
    return [
      "status" => false,
      "message" => "Password is incorrect"
    ];
  }

  $existingPhoto = $rowUser['photo'];
  $imagePath = $existingPhoto;

  if ($deletePhotoProfile) {
    if ($existingPhoto && file_exists($existingPhoto)) {
      unlink($existingPhoto);
    }
    $imagePath = null;
  } elseif ($photoProfile && $photoProfile['error'] == UPLOAD_ERR_OK) {
    $photoCheck = checkValidPhoto($photoProfile);
    if (!$photoCheck['status']) {
      return $photoCheck;
    }

    if ($existingPhoto && file_exists($existingPhoto)) {
      unlink($existingPhoto);
    }

    $fileExtension = strtolower(pathinfo($photoProfile['name'], PATHINFO_EXTENSION));
    $uniqueName = uniqid("profile_", true) . "." . $fileExtension;
    $uploadDir = "uploads/profile/";

    if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0777, true);
    }

    $imagePath = $uploadDir . $uniqueName;
    if (!move_uploaded_file($photoProfile['tmp_name'], $imagePath)) {
      return [
        "status" => false,
        "message" => "Failed to upload new image."
      ];
    }
  }

  $newPassword = $newPassword ? password_hash($newPassword, PASSWORD_DEFAULT) : $rowUser['password'];

  $sql = "UPDATE users SET username = '$username', fullname = '$fullname', bio = '$bio', password = '$newPassword', photo = '$imagePath', link_instagram = '$linkInstagram', link_facebook = '$linkFacebook', link_github = '$linkGithub', link_linkedin = '$linkLinkedin' WHERE nim = $nim";
  $result = $conn->query($sql);
  if ($result) {
    return [
      "status" => true,
      "message" => "Profile updated successfully"
    ];
  } else {
    return [
      "status" => false,
      "message" => "Failed to update profile"
    ];
  }
}

function top5WatchingCounter()
{
  global $conn;

  $sql = "SELECT 
                p.id, p.title, p.description, p.photo, p.created_at, p.status, p.counter_views, 
                u.nim, u.username, u.photo AS photoUser, 
                c.name,
                (SELECT COUNT(*) FROM comments WHERE post_id = p.id) AS total_comments
           FROM posts p
           JOIN users u on p.user_nim = u.nim
           JOIN categories c on p.category_id = c.id
            ORDER BY p.counter_views DESC LIMIT 5";


  $result = $conn->query($sql);
  $posts = [];
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $posts[] = [
        "id" => $row['id'],
        "title" => $row['title'],
        "description" => $row['description'],
        "photo" => $row['photo'],
        "category" => $row['name'],
        "user" => [
          "nim" => $row['nim'],
          "username" => $row['username'],
          "photo" => $row['photoUser']
        ],
        "created_at" => $row['created_at'],
        "status" => $row['status'],
        "total_comments" => $row['total_comments'],
        "counter_views" => $row['counter_views']
      ];
    }
  }

  return $posts;
}

function search($keyword)
{
  global $conn;

  $sql = "SELECT 
                p.id, p.title, p.description, p.photo, p.created_at, p.status, p.counter_views, 
                u.nim, u.username, u.photo AS photoUser, 
                c.name,
                (SELECT COUNT(*) FROM comments WHERE post_id = p.id) AS total_comments
            FROM posts p
            JOIN users u on p.user_nim = u.nim
           JOIN categories c on p.category_id = c.id
            WHERE p.title LIKE '%$keyword%' OR p.description LIKE '%$keyword%' OR u.username LIKE '%$keyword%' OR c.name LIKE '%$keyword%'";

  $result = $conn->query($sql);
  $posts = [];
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $posts[] = [
        "id" => $row['id'],
        "title" => $row['title'],
        "description" => $row['description'],
        "photo" => $row['photo'],
        "category" => $row['name'],
        "user" => [
          "nim" => $row['nim'],
          "username" => $row['username'],
          "photo" => $row['photoUser']
        ],
        "created_at" => $row['created_at'],
        "status" => $row['status'],
        "total_comments" => $row['total_comments'],
        "counter_views" => $row['counter_views']
      ];
    }
  }

  $sqlUsers = "SELECT * FROM users WHERE username LIKE '%$keyword%' OR fullname LIKE '%$keyword%' AND role = 'user' HAVING role = 'user'";
  $resultUsers = $conn->query($sqlUsers);
  $users = [];
  if ($resultUsers->num_rows > 0) {
    while ($row = $resultUsers->fetch_assoc()) {
      $users[] = [
        "nim" => $row['nim'],
        "username" => $row['username'],
        "fullname" => $row['fullname'],
        "email" => $row['email'],
        "photo" => $row['photo'],
        "status" => $row['status']
      ];
    }
  }


  return [
    "users" => $users,
    "posts" => $posts
  ];
}
