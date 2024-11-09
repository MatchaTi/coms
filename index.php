<?php
include 'components/avatar.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- styles -->
    <link rel="stylesheet" href="css/utilities.css">
    <link rel="stylesheet" href="css/style.css">

    <title>Home</title>
</head>

<body>
    <?php
    include 'components/navbar.php';
    ?>
    <h2 class="mb-6 heading-2 text-center">Posts</h2>
    <section class="mb-6 p-6 flex gap-6 items-center rounded shadow border bg-cream">
        <?php
        echo renderAvatar('Ymy', '')
            ?>
        <p class="font-semibold">What's the error you're stuck on? Let's solve it!</p>
    </section>
    <article class="mb-6 p-6 w-full flex gap-6 rounded shadow border bg-cream">
        <?php
        echo renderAvatar('Ymy', '')
            ?>
        <div class="w-full">
            <div class="mb-6 flex items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div>
                        <div class="mb-1 heading-2">Youmiya</div>
                        <div>2024-10-21</div>
                    </div>
                    <div class="px-6 py-3 rounded-full shadow border bg-pink">Code</div>
                </div>
                <div>
                    <img src="assets/icons/option.svg" alt="option">
                </div>
            </div>
            <div class="mb-6 p-6 rounded shadow border bg-blue">
                <h3 class="heading-2">Title</h3>
            </div>
            <p class="mb-6 leading-relaxed">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Voluptas earum nam eligendi iste a suscipit et? Vero repellendus, laudantium voluptatibus voluptate culpa voluptates ipsam ratione sint, unde doloremque, non pariatur!</p>
            <div class="mb-6 p-12 rounded border shadow bg-green">image</div>
            <div class="flex items-center gap-3">
                <div class="px-6 py-2 flex items-center gap-2 rounded-full border shadow bg-red">
                    <img src="assets/icons/comment.svg" alt="comment">
                    <span>9</span>
                </div>
                <div class="px-6 py-2 flex items-center gap-2 rounded-full border shadow bg-yellow">
                    <img src="assets/icons/view.svg" alt="view">
                    <span>9</span>
                </div>
                <div class="px-6 py-2 rounded-full border shadow bg-green">
                    <img src="assets/icons/share.svg" alt="share">
                </div>
            </div>
        </div>
    </article>
</body>

</html>