<?php
ini_set('default_charset','utf-8');
$link=mysqli_connect("localhost","root","") or die ("無法開啟Mysql資料庫連結"); //建立mysql資料庫連結
mysqli_select_db($link, "soulangh_SL"); //選擇資料庫abc

$site_url = 'http://gengar.info/soulangh';
$base_url = 'http://gengar.info/soulangh/soulangh_booking/';


// var_dump('sadsadsd');
?>