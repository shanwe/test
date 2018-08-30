<?php

session_start();

$_SESSION[md5('page')] = 'inquire';

//$pid = $_POST['pid'];
//$phone = $_POST['phone'];

include("sql_config.php");
/*
ini_set('default_charset','utf-8');
$link=mysqli_connect("localhost","root","") or die ("無法開啟Mysql資料庫連結"); //建立mysql資料庫連結
mysqli_select_db($link, "soulangh_SL"); //選擇資料庫abc
*/

$pid = htmlspecialchars(mysqli_real_escape_string($link,$_POST['pid']));
$phone = htmlspecialchars(mysqli_real_escape_string($link,$_POST['phone']));


$sql = "SELECT * FROM reservation WHERE pid='".$pid."' && phone = '".$phone."' && date > '".date('Y-m-d')." 'ORDER BY date ASC,time_period ASC ";



mysqli_query($link, 'SET CHARACTER SET utf8');  // 送出Big5編碼的MySQL指令



mysqli_query($link, "SET collation_connection = utf8_general_ci");



$result = mysqli_query($link,$sql); // 執行SQL查詢



$total_fields=mysqli_num_fields($result); // 取得欄位數



$total_records=mysqli_num_rows($result);  // 取得記錄數



for ($i=0; $i < $total_records; $i++) {

    $data[$i] = mysqli_fetch_assoc($result);

}



$time_period[1] = '09:00-10:30';

$time_period[2] = '11:00-12:30';

$time_period[3] = '13:30-15:00';

$time_period[4] = '15:30-16:30';


//mysql_close();
//var_dump($data);

?>





<html lang="zh-Hant">

<head>

<!-- Meta -->

<meta charset="utf-8">

<meta name="viewport" content="width=1024, initial-scale=1">

<meta name="keywords" content="線上預約-蕭壠文化園區">

<meta name="description" content="線上預約-蕭壠文化園區">

<title>線上預約-蕭壠文化園區</title>

<!-- Favicon -->

<link href="favicon.ico" rel="icon">

<link href="favicon.ico" rel="shortcut icon">

<link href="apple-touch-icon.png" rel="apple-touch-icon">

<link href="assets/css/font-awesome.min.css" rel="stylesheet">

<link href="assets/css/common.css" rel="stylesheet">

</head>

<body>

<div class="g-wrap">

  <?php include('page_header.php'); ?>

  <?php include('page_breadcrumbs.php'); ?>

  <div class="main-wrap">

    <div class="box">

      <?php include('booking_nav.php'); ?>

      <div class="inquire-list">

        <table class="list-tb tbset">

          <thead>

            <tr>

              <th>預約代號</th>

              <th>預約日期</th>

              <th>參觀時段</th>

              <th>參觀人數</th>

              <th class="r5">取消預約</th>

            </tr>

          </thead>

          <tbody>

            <?php if(!empty($data)) { ?>

            <?php foreach ($data as $key => $value) { ?>

            <tr>

              <td><?=$value['serial_number']?></td>

              <td><?=$value['date']?></td>

              <td><?=$time_period[$value['time_period']]?></td>

              <td><?=$value['people']?> 人</td>

              <?php if($value['status'] == 1) {?>

                <td><a class="del" onclick="del(<?='\''.$value['id'].'\''?>)" href="javascript: void(0);"> <span class="fa fa-trash"></span>我要取消預約</a></td>

              <?php } else { ?>

                <td><span class="">已取消預約</span></td>

              <?php } ?>

            </tr>

            <?php }} else { ?>

            <?php } ?>



          </tbody>

        </table>

        <div class="exhort">

          <span class="fa fa-comments"></span>小叮嚀：

          <ol type="1">

            <li>欲變更預約人數，請先取消預約後再重新線上預約。</li>

            <li>欲取消預約，請於參觀日前一天完成。例：參觀日為26號，需於25號晚間12點前取消預約。</li>

            <li>如有任何問題，請洽06-7228488&nbsp;&nbsp;&nbsp;7229910。</li>

          </ol>

        </div>

      </div>

    </div>

    <?php include('page_footer.php'); ?>

  </div>

</div>

<script src="assets/js/plugins/jQuery/jquery-2.1.4.min.js"></script>

<script src="assets/js/plugins/jQuery/searchform.js"></script>

<script src="assets/js/plugins/jQuery/dropdownmenu.js"></script>

</body>

</html>



<script type="text/javascript">



function del (id) {

    if (confirm("確定取消預約?")) {

        var csrf_hash = "<?=date('Y-m-d').'2083222'?>";

            $.post("<?=$base_url?>"+"inquire_main.php"+"?id="+id,{csrf:csrf_hash, is_del: 1},function(){

                location.reload();

            });

        }

        else return false;

}







</script>