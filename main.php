<?php

include("sql_config.php");
/*
ini_set('default_charset','utf-8');
$link=mysqli_connect("localhost","root","") or die ("無法開啟Mysql資料庫連結"); //建立mysql資料庫連結
mysqli_select_db($link, "soulangh_SL"); //選擇資料庫abc
*/

$name = htmlspecialchars(mysqli_real_escape_string($link,$_POST['name']));
$phone = htmlspecialchars(mysqli_real_escape_string($link,$_POST['phone']));
$email = htmlspecialchars(mysqli_real_escape_string($link,$_POST['email']));
$pid = htmlspecialchars(mysqli_real_escape_string($link,$_POST['pid']));
$time_period = htmlspecialchars(mysqli_real_escape_string($link,$_POST['range']));
$people = htmlspecialchars(mysqli_real_escape_string($link,$_POST['people']));
$date = htmlspecialchars(mysqli_real_escape_string($link,$_POST['date']));

$sql = "SELECT * FROM reservation WHERE date='".$date."' && time_period = '".$time_period."'";



mysqli_query($link, 'SET CHARACTER SET utf8');  // 送出Big5編碼的MySQL指令



mysqli_query($link, "SET collation_connection = utf8_general_ci");



$result = mysqli_query($link,$sql); // 執行SQL查詢



$total_fields=mysqli_num_fields($result); // 取得欄位數



$total_records=mysqli_num_rows($result);  // 取得記錄數



for ($i=0; $i < $total_records; $i++) {

    $data[$i] = mysqli_fetch_assoc($result);

}



$people_num = 0;

if(!empty($data)){

	foreach ($data as $key => $value) {

		if($value['status'] == 1)

			$people_num += $value['people'];

	}

}
$date_end = date('Y-m-d',strtotime(date('Y-m-d')."+7 day"));

if(($date < $date_end)) {
    ini_set('default_charset','utf-8');
    echo '<script charset="UTF-8">alert("預約失敗，別鬧了亂改啥日期，請重新預約，謝謝！");</script>';
    echo '<script>location.href = "booking.php";</script>';
	die();
}

if($people > 5){
    ini_set('default_charset','utf-8');
    echo '<script charset="UTF-8">alert("預約失敗，別鬧了亂改啥數字，請重新預約，謝謝！");</script>';
    echo '<script>location.href = "booking.php";</script>';
	die();
}


if($people_num+$people >50){

    ini_set('default_charset','utf-8');

    echo '<script charset="UTF-8">alert("預約失敗，超過該時段預約人數，請重新預約，謝謝！");</script>';

    echo '<script>location.href = "booking.php";</script>';

	die();

}



if(!empty($data)){

	if($total_records<10){

		$num = '0'.$total_records;

	} else {

		$num = $total_records;

	}

} else {

	$num = '00';

}

$date_arr = explode("-",$date);

$serial_number = ($date_arr[0].$date_arr[1].$date_arr[2].$_POST['range'].$num)+1;



$sql = "INSERT INTO reservation(`name`,`phone`,`email`,`pid`,`time_period`,`people`,`serial_number`,`date`) VALUES ('".$name."','".$phone."','".$email."','".$pid."','".$time_period."','".$people."','".$serial_number."','".$date."')";



mysqli_query($link, 'SET CHARACTER SET utf8');  // 送出Big5編碼的MySQL指令



mysqli_query($link, "SET collation_connection = utf8_general_ci");



$result = mysqli_query($link,$sql); // 執行SQL查詢
//mysql_close();
if($result) {



		session_start();

		$_SESSION[md5('serial_number')] = $serial_number;



        ini_set('default_charset','utf-8');

        echo '<script charset="UTF-8">alert("預約成功");</script>';

        echo '<script>location.href = "booking_complete.php";</script>';

} else {

        ini_set('default_charset','utf-8');

        echo '<script charset="UTF-8">alert("預約失敗，請重新預約！");</script>';

        echo '<script>location.href = "booking.php";</script>';

}



?>