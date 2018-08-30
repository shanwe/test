<?php

$id = $_GET['id'];





session_start();

$serial_number = $_SESSION[md5('serial_number')];

include("sql_config.php");
/*
ini_set('default_charset','utf-8');
$link=mysqli_connect("localhost","root","") or die ("無法開啟Mysql資料庫連結"); //建立mysql資料庫連結
mysqli_select_db($link, "soulangh_SL"); //選擇資料庫abc
*/


$sql = "UPDATE `reservation` SET `status`= 0 WHERE id = ".$id;



mysqli_query($link, 'SET CHARACTER SET utf8');  // 送出Big5編碼的MySQL指令



mysqli_query($link, "SET collation_connection = utf8_general_ci");



$result = mysqli_query($link,$sql); // 執行SQL查詢

mysql_close();

return $result;



?>