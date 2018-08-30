<?php



session_start();

if(!isset($_SESSION[md5('serial_number')])) {
  ini_set('default_charset','utf-8');
  echo '<script charset="UTF-8">alert("尚未預約完成，請重新預約");</script>';
  echo '<script>location.href = "http://soulangh.tnc.gov.tw/soulangh_booking/booking.php";</script>';
}

$serial_number = $_SESSION[md5('serial_number')];

$_SESSION[md5('page')] = 'reservation';

include("sql_config.php");
/*
ini_set('default_charset','utf-8');
$link=mysqli_connect("localhost","root","") or die ("無法開啟Mysql資料庫連結"); //建立mysql資料庫連結
mysqli_select_db($link, "soulangh_SL"); //選擇資料庫abc
*/


$sql = "SELECT * FROM reservation WHERE serial_number='".$serial_number."'";



mysqli_query($link, 'SET CHARACTER SET utf8');  // 送出Big5編碼的MySQL指令



mysqli_query($link, "SET collation_connection = utf8_general_ci");



$result = mysqli_query($link,$sql); // 執行SQL查詢



$total_fields=mysqli_num_fields($result); // 取得欄位數



$total_records=mysqli_num_rows($result);  // 取得記錄數



$data= mysqli_fetch_assoc($result);



//var_dump($serial_number);



$time_period[1] = '09:00~10:30';

$time_period[2] = '11:00~12:30';

$time_period[3] = '13:30~15:00';

$time_period[4] = '15:30~16:30';

//mysql_close();
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



      <div class="booking" >

        <ul class="step ulset">

          <li><div class="icon"><span class="fa fa-calendar"></span>STEP1</div>選擇日期與時段</li>

          <li><div class="icon"><span class="fa fa-pencil-square-o"></span>STEP2</div>填寫人數與基本資料</li>

          <li class="current"><div class="icon"><span class="fa fa-ticket"></span>STEP3</div>完成預約</li>

        </ul>



          <div class="con" >

            <div class="caption">

              請列印或拍下您的預約申請單!<br>

              參觀日時請出示給現場服務人員確認，以便入館，謝謝。

              <button type="submit" value="" onclick="printScreen(print_parts);">列印本頁</button>

            </div>

      <div id="print_parts">

        <div class="booking">

            <div class="com-txt">您已完成預約!</div>

            <div class="info">

              <table class="tbset">

                <tr class="color-red">

                  <th>預約代號：</th>

                  <td colspan="5"><?=$data['serial_number']?></td>

                </tr>

                <tr>

                  <th>預約日期：</th>

                  <td><?=$data['date']?></td>

                  <th>參觀時段：</th>

                  <td><?=$time_period[$data['time_period']]?></td>

                  <th>參觀人數：</th>

                  <td class="num"><?=$data['people']?>人</td>

                </tr>

                <tr>

                  <th>聯絡姓名：</th>

                  <td><?=$data['name']?></td>

                  <th class="id">身份證末四碼：</th>

                  <td colspan="3"><?=$data['pid']?></td>

                </tr>

                <tr>

                  <th>行動電話：</th>

                  <td><?=$data['phone']?></td>

                  <th>電子信箱：</th>

                  <td colspan="3"><?=$data['email']?></td>

                </tr>

              </table>

            </div>

            <div class="exhort">

              <div style="text-align: left;"><span class="fa fa-comments"></span>小叮嚀：</div>

              <ol type="1">

                <li>欲查詢預約狀態請至<a href="inquire.php" title="預約查詢/取消">「預約查詢/取消」</a>進行操作。<br>取消預約請於參觀日前一天完成。例：參觀日為26號，需於25號晚間12點前取消預約。</li>

                <li>如有任何問題，請洽06-7228488&nbsp;&nbsp;&nbsp;7229910。</li>

              </ol>

            </div>

        </div>

      </div>

          </div>



        <ul class="btn-group ulset">

          <li><a href="http://soulangh.tnc.gov.tw/page/info/27.php" title="園區參觀資訊" class="gray btn">園區參觀資訊</a></li>

          <li><a href="http://soulangh.tnc.gov.tw/product/class/index.php" title="園區展演活動" class="red btn">園區展演活動</a></li>

        </ul>

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

function printScreen(printlist)

  {

     var value = printlist.innerHTML;

     var printPage = window.open("", "Printing...", "");

     printPage.document.open();

     printPage.document.write("<HTML><head><link href=\"assets/css/font-awesome.min.css\" rel=\"stylesheet\"><link href=\"assets/css/common.css\" rel=\"stylesheet\"></head><BODY onload='window.print();window.close()'>");

     printPage.document.write("<PRE>");

     printPage.document.write(value);

     printPage.document.write("</PRE>");

     printPage.document.close("</BODY></HTML>");

  }

</script>