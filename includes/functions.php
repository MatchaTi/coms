<?php
include 'connection.php';

function register($nim, $username, $fullname, $email, $password, $ktm)
{
    global $conn;

    if (strlen($nim) < 10) {
        return [
            "status" => false,
            "message" => "NIM harus 10 karakter"
        ];
    }

    $sql = "SELECT * FROM users WHERE nim='$nim'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return [
            "status" => false,
            "message" => "NIM sudah terdaftar"
        ];
    }

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return [
            "status" => false,
            "message" => "Username sudah terdaftar"
        ];
    }

    $sql = "SELECT * FROM users WHERE fullname='$fullname'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return [
            "status" => false,
            "message" => "Nama lengkap sudah terdaftar"
        ];
    }

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return [
            "status" => false,
            "message" => "Email sudah terdaftar"
        ];
    }

    if (strlen($password) < 4) {
        return [
            "status" => false,
            "message" => "Password minimal 4 karakter"
        ];
    }

    $ktmPath = null;

    if (empty($ktm['name'])) {
        return [
            "status" => false,
            "message" => "KTM harus diupload"
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
                "message" => "Gagal mengupload KTM"
            ];
        }
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (nim, username, fullname,email, password, ktm) VALUES ('$nim', '$username', '$fullname','$email', '$passwordHash', '$ktmPath')";
    $result = $conn->query($sql);
    if ($result) {
        return [
            "status" => true,
            "message" => "Registrasi berhasil"
        ];
    } else {
        return [
            "status" => false,
            "message" => "Registrasi gagal"
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
            "message" => "NIM tidak terdaftar"
        ];
    }

    $user = $result->fetch_assoc();

    if (!password_verify($password, $user['password'])) {
        return [
            "status" => false,
            "message" => "Password salah"
        ];
    }

    if (!$user['status']) {
        return [
            "status" => false,
            "message" => "Akun belum aktif"
        ];
    }

    return [
        "status" => true,
        "message" => "Login berhasil",
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
            "message" => "Ukuran file maksimal 2MB"
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
            "message" => "User berhasil diaktifkan"
        ];
    } else {
        return [
            "status" => false,
            "message" => "User gagal diaktifkan"
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
            "message" => "User berhasil ditolak"
        ];
    } else {
        return [
            "status" => false,
            "message" => "User gagal ditolak"
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
            "message" => "User berhasil dihapus"
        ];
    } else {
        return [
            "status" => false,
            "message" => "User gagal dihapus"
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
                "message" => "Gagal mengupload foto"
            ];
        }
    }

    $sql = "INSERT INTO posts (user_nim, title, description, category_id, photo) VALUES ('$userNIM', '$title', '$description', '$category', '$photoPath')";
    $result = $conn->query($sql);
    if ($result) {
        return [
            "status" => true,
            "message" => "Post berhasil ditambahkan, menunggu verifikasi admin!"
        ];
    } else {
        return [
            "status" => false,
            "message" => "Post gagal ditambahkan!"
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
        $sql .= " WHERE p.status = 1 ORDER BY p.created_at DESC";
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
            "message" => "Post berhasil diapprove"
        ];
    } else {
        return [
            "status" => false,
            "message" => "Post gagal diapprove"
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
            "message" => "Post berhasil direject"
        ];
    } else {
        return [
            "status" => false,
            "message" => "Post gagal direject"
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
            "message" => "Post berhasil dihapus"
        ];
    } else {
        return [
            "status" => false,
            "message" => "Post gagal dihapus"
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
            "counter_views" => $row['counter_views']
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
?>