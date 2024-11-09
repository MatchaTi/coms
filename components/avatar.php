<?php
function renderAvatar($username, $photo, $size = 'avatar', $altText = 'Photo Profile', $class = '')
{
    $photoUrl = $photo ? $photo : "https://ui-avatars.com/api/?name=" . urlencode($username);
    return "
        <div class='photo-profile w-15 h-15 $class $size flex items-center justify-center rounded shadow border bg-red'>
            <img src=$photoUrl alt='$altText $username'>
        </div>
    ";
}
?>