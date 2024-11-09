<?php
include 'includes/functions.php';

session_start();

// if (isset($_SESSION['user'])) {
//     header('Location: index.php');
// }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nim = htmlspecialchars($_POST['nim']);
    $password = htmlspecialchars($_POST['password']);

    $result = login($nim, $password);
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

    <title>Login | Coms</title>
</head>

<body class="w-screen h-screen flex items-center justify-center">
    <section class="container-auth w-full flex items-center justify-center gap-12">
        <div>
            <h1 class="heading-1">Coms</h1>
            <p class="hero-paragraph leading-relaxed">Coms helps you connect and share with students, lecturers, and the community at Mulawarman University, strengthening connections and collaboration in the academic environment.</p>
        </div>
        <form action="" class="form-auth w-full p-6 border shadow rounded-lg" method="POST" enctype="multipart/form-data">
            <h2 class="heading-2 text-center mb-6">Login</h2>
            <div class="mb-6">
                <label for="nim" class="block mb-2 font-semibold">NIM</label>
                <input type="text" name="nim" id="nim" class="p-6 rounded shadow border bg-blue w-full" placeholder="Ex: 2309106065" required>
            </div>
            <div class="mb-6">
                <label for="password" class="block mb-2 font-semibold">Password</label>
                <input type="password" name="password" id="password" class="p-6 rounded shadow border bg-pink w-full" placeholder="Min 4 characters" required>
            </div>
            <button type="submit" class="mb-6 py-4 w-full border shadow rounded font-semibold">Login</button>
            <div class="text-center w-full">
                <a href="register.php">Don't have a account? <span class="p-1 bg-light-blue">Register</span></a>
            </div>
        </form>
    </section>
</body>

</html>