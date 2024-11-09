<?php
include 'connection.php';

function register($nim, $username, $email, $password, $ktm)
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
    $sql = "INSERT INTO users (nim, username, email, password, ktm) VALUES ('$nim', '$username', '$email', '$passwordHash', '$ktmPath')";
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
?>