<?php

if(!empty($_POST['pid']))

	$data['pid'] = $_POST['pid'];

if(!empty($_POST['phone']))

	$data['phone'] = $_POST['phone'];

$data['date'] = $_POST['date'];

$data['time_period'] = $_POST['range'];


include("sql_config.php");
/*
ini_set('default_charset','utf-8');
$link=mysqli_connect("localhost","soulangh_sinpao","!@#28809481") or die ("無法開啟Mysql資料庫連結"); //建立mysql資料庫連結
mysqli_select_db($link, "soulangh_SL"); //選擇資料庫abc
*/


if(!empty($_POST['pid']))

	$sql = "SELECT * FROM reservation WHERE date='".$data['date']."' && time_period = '".$data['time_period']."' && pid='".$data['pid']."' && status = '1'";

if(!empty($_POST['phone']))

	$sql = "SELECT * FROM reservation WHERE date='".$data['date']."' && time_period = '".$data['time_period']."' && phone='".$data['phone']."' && status = '1'";



mysqli_query($link, 'SET CHARACTER SET utf8');  // 送出Big5編碼的MySQL指令



mysqli_query($link, "SET collation_connection = utf8_general_ci");



$result = mysqli_query($link,$sql); // 執行SQL查詢



$total_fields=mysqli_num_fields($result); // 取得欄位數



$total_records=mysqli_num_rows($result);  // 取得記錄數



$data['records'] = $total_records;

mysql_close();

echo json_encode($data);







?>