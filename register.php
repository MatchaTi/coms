<?php
include 'includes/functions.php';

// WIP register logic
// ktm upload

session_start();

if (isset($_SESSION['user'])) {
    header('Location: index.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nim = $_POST['nim'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $ktm = $_FILES['ktm'];

    $result = register($nim, $username, $email, $password, $ktm);
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
    <!-- styles -->
    <link rel="stylesheet" href="css/utilities.css">
    <link rel="stylesheet" href="css/style.css">

    <title>Register | Coms</title>
</head>

<body class="w-screen h-screen flex items-center justify-center">
    <section class="w-full flex flex-wrap items-center justify-center gap-12">
        <div>
            <h1 class="heading-1">Coms</h1>
            <p class="hero-paragraph leading-relaxed">Coms helps you connect and share with students, lecturers, and the community at Mulawarman University, strengthening connections and collaboration in the academic environment.</p>
        </div>
        <form action="" class="form-auth w-full p-6 border shadow rounded-lg" method="POST" enctype="multipart/form-data">
            <h2 class="heading-2 text-center mb-6">Register</h2>
            <div class="mb-6">
                <label for="nim" class="block mb-2 font-semibold">NIM</label>
                <input type="text" name="nim" id="nim" class="p-6 rounded shadow border bg-red w-full" placeholder="Ex: 2309106065" required>
            </div>
            <div class="mb-6">
                <label for="username" class="block mb-2 font-semibold">Username</label>
                <input type="text" name="username" id="username" class="p-6 rounded shadow border bg-yellow w-full" placeholder="Ex: Fuyu" required>
            </div>
            <div class="mb-6">
                <label for="email" class="block mb-2 font-semibold">Email</label>
                <input type="email" name="email" id="email" class="p-6 rounded shadow border bg-orange w-full" placeholder="Ex: fuyu@gmail.com" required>
            </div>
            <div class="mb-6">
                <label for="password" class="block mb-2 font-semibold">Password</label>
                <input type="password" name="password" id="password" class="p-6 rounded shadow border bg-green w-full" placeholder="Min 4 characters" required>
            </div>
            <div class="mb-6">
                <label for="ktm" class="block mb-2 font-semibold">KTM</label>
                <input type="file" name="ktm" id="ktm" class="p-6 rounded shadow border bg-blue w-full">
            </div>
            <button type="submit" class="py-4 w-full border shadow rounded font-semibold">Register</button>
        </form>
    </section>
</body>

</html>