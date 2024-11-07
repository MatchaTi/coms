<?php
include 'includes/functions.php';

$result = login("2309106065", "adi");
echo $result['message'];
var_dump($result['data']);
?>