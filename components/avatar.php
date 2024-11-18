<?php
function renderAvatar($username, $photo, $size = 'avatar', $altText = 'Photo Profile', $class = '')
{
    $photoUrl = $photo ? $photo : "https://ui-avatars.com/api/?name=" . urlencode($username);
    return "
        <div class='profile-avatar $class $size white border shadow rounded'>
            <img src='$photoUrl' alt='$altText $username'>
        </div>
    ";
}
?>