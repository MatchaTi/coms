<?php
include 'connection.php';

function register($conn, $nim, $username, $email, $password, $ktm)
{
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

}
?>