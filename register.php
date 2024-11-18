<?php
include 'includes/connection.php';
include 'includes/functions.php';

session_start();

if (isset($_SESSION['user'])) {
    header('Location: index.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nim = htmlspecialchars($_POST['nim']);
    $username = htmlspecialchars($_POST['username']);
    $fullname = htmlspecialchars($_POST['fullname']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $ktm = $_FILES['ktm'];

    $result = register($nim, $username, $fullname, $email, $password, $ktm);
    if ($result['status']) {
        echo "<script>alert('" . $result['message'] . "')</script>";
        header('Location: login.php');
    } else {
        echo "<script>alert('" . $result['message'] . "')</script>";
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
    <link rel="stylesheet" href="css/auth.css">

    <!-- favicon -->
    <link rel="shortcut icon" href="favicon.svg" type="image/x-icon">

    <title>Register | COMS</title>
</head>

<body>
    <div class="auth w-full flex items-center gap-6">
        <div>
            <h1 class="heading">COMS</h1>
            <p>Coms helps you connect and share with students, lecturers, and the community at Mulawarman University, strengthening connections and collaboration in the academic environment.</p>
        </div>
        <form action="" method="POST" class="mb-6 p-c w-full cream border shadow rounded-lg" enctype="multipart/form-data">
            <h2 class="heading mb-6 text-center">Register</h2>
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="nim" class="font-bold block mb-2">NIM</label>
                    <input type="text" name="nim" id="nim" placeholder="Ex: 2309106065" class="w-full red p-c rounded-lg border shadow" maxlength="10">
                </div>
                <div>
                    <label for="username" class="font-bold block mb-2">Username</label>
                    <input type="text" name="username" id="username" placeholder="Ex: Adi" class="w-full orange p-c rounded-lg border shadow" maxlength="25">
                </div>
                <div>
                    <label for="fullname" class="font-bold block mb-2">Fullname</label>
                    <input type="text" name="fullname" id="fullname" placeholder="Ex: Adi Muhammad Syifai" class="w-full yellow p-c rounded-lg border shadow" maxlength="50">
                </div>
                <div>
                    <label for="email" class="font-bold block mb-2">Email</label>
                    <input type="email" name="email" id="email" placeholder="Ex: adi@gmail.com" class="w-full green p-c rounded-lg border shadow" maxlength="50">
                </div>
                <div>
                    <label for="ktm" class="font-bold block mb-2">KTM</label>
                    <input type="file" name="ktm" id="ktm" placeholder="Ex: adi@gmail.com" class="w-full blue p-c rounded-lg border shadow" accept="image/*">
                </div>
                <div>
                    <label for="password" class="font-bold block mb-2">Password</label>
                    <input type="password" name="password" id="password" placeholder="Min 4 characters" class="w-full purple p-c rounded-lg border shadow" maxlength="50">
                </div>
            </div>
            <button type="submit" class="btn auth w-full px-6 font-bold py-2 flex text-center justify-center border shadow rounded-lg">Register</button>
            <div class="mt-3 text-center">Have a account? <a href="login.php" class="blue px-1 py-1">Login</a></div>
        </form>
    </div>
</body>

</html>