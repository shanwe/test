<?php
session_start();
include("simple-php-captcha.php");
$captcha = simple_php_captcha();

echo json_encode($captcha);
?>