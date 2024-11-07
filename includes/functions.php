<?php
include 'connection.php';


function register($nim, $username, $email, $password, $ktm)
{
    global $conn;

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

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (nim, username, email, password, ktm) VALUES ('$nim', '$username', '$email', '$passwordHash', '$ktm')";
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

    $sql = "SELECT nim, username, password, photo, role FROM users WHERE nim='$nim'";
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
?>