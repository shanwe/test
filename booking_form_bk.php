<?php

session_start();

$_SESSION[md5('page')] = 'reservation';

ini_set('default_charset','utf-8');

$date = $_POST['date'];

$range = $_POST['range'];



$link=mysqli_connect("localhost","soulangh_sinpao","!@#28809481") or die ("無法開啟Mysql資料庫連結"); //建立mysql資料庫連結



mysqli_select_db($link, "soulangh_SL"); //選擇資料庫abc



$sql = "SELECT * FROM reservation WHERE date='".$date."' && time_period = '".$range."'";



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

//var_dump($people_num);



$time_period[1] = '09:00~10:30';

$time_period[2] = '11:00~12:30';

$time_period[3] = '13:30~15:00';

$time_period[4] = '15:30~16:30';


mysql_close();
?>





<!DOCTYPE html>

<html lang="zh-Hant">

<head>

<!-- Meta -->

<meta charset="utf-8">

<meta name="viewport" content="1024, initial-scale=1">

<meta name="keywords" content="線上預約-蕭壠文化園區 | 此為校稿頁面">

<meta name="description" content="線上預約-蕭壠文化園區 | 此為校稿頁面">

<title>線上預約-蕭壠文化園區 | 此為校稿頁面</title>

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

      <div class="booking">

        <ul class="step ulset">

          <li><div class="icon"><span class="fa fa-calendar"></span>STEP1</div>選擇日期與時段</li>

          <li class="current"><div class="icon"><span class="fa fa-pencil-square-o"></span>STEP2</div>填寫人數與基本資料</li>

          <li><div class="icon"><span class="fa fa-ticket"></span>STEP3</div>完成預約</li>

        </ul>

        <form action="main.php" method="post">

        <input type="hidden" name="date" id="date" value="<?=$date?>">

        <input type="hidden" name="range" id="range" value="<?=$range?>">



          <div class="con">

            <div class="date">您選擇的<p><span>日期</span><?=date('Y',strtotime($date))?>/<?=date('m',strtotime($date))?>/<?=date('d',strtotime($date))?>&nbsp;&nbsp;&nbsp;<span>時段</span><?=$time_period[$range]?></p></div>

            <p class="note">若您為代訂人員，請填寫當日來館聯絡人的資料。<span>*</span>為必填欄位。</p>

            <div class="form-group">

              <label for="people" class="">參觀人數<strong>*</strong></label>

              <div class="input-txt">

                <!--<input type="text" name="people" id="people" value="" class="input-style" required>-->

                <select name="people" class="input-style">

                  <option value="1" SELECTED>1人</option>

                  <?=(30-$people_num >= 2)? '<option value="2">2人</option>':'' ?>

                  <?=(30-$people_num >= 3)? '<option value="3">3人</option>':'' ?>

                  <?=(30-$people_num >= 4)? '<option value="4">4人</option>':'' ?>

                  <?=(30-$people_num >= 5)? '<option value="5">5人</option>':'' ?>

                </select>

              <span>此時段最多可預約人數為 <?=(30-$people_num>5)?'5':(30-$people_num)?> 人，含家長及小朋友</span></div>

            </div>

            <div class="form-group">

              <label for="name" class="">聯絡姓名<strong>*</strong></label>

              <div class="input-txt"><input type="text" name="name" id="name" value="" class="input-style" required><span>請提供正確的全名，以利入館確認</span></div>

            </div>

            <div class="form-group">

              <label for="pid" class="">身份證末四碼<strong>*</strong></label>

              <div class="input-txt">

                <input type="text" name="pid" id="pid" value="" class="input-style" required>

                <div id = "pid_error" >此時段的身分證末四碼已預約</div>

              </div>

            </div>

            <div class="form-group">

              <label for="phone" class="">行動電話<strong>*</strong></label>

              <div class="input-txt">

                <input type="text" name="phone" id="phone" value="" class="input-style" required><span>例如：0910555666</span>

                <div id = "phone_error" hidden>此時段的行動電話已預約</div>

              </div>

            </div>

            <div class="form-group">

              <label for="email" class="">電子信箱<strong>*</strong></label>

              <div class="input-txt"><input type="text" name="email" id="email" value="" class="input-style" required><span>請使用可正常收發的信箱</span></div>

            </div>

            <div class="code form-group">

              <label for="code" class="">驗證碼<strong>*</strong></label>

              <div class="input-txt">

                <input type="text" name="code" id="code" value="" class="input-style" required>

                <div class="code-img"><img src="assets/images/del/code.gif" alt="code"></div>

                <span>不分大小寫</span>

              </div>

            </div>

          </div>

          <ul class="btn-group ulset">

            <li><a href="booking_date.php" title="上一步" class="gray btn">上一步</a></li>

            <li><button type="submit" value="" class="red btn">確認送出</button></li>

          </ul>

        </form>

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



$(document).ready(function(e) {

  var ckpid = true;

  var ckphone = true;

  $("#pid_error").hide();

    //alert("3333");

  $("#pid").focusout(function(e) {

        e.preventDefault();

        //console.log($("#pid").val());

        //console.log($("#date").val());

        //console.log($("#range").val());



        $.ajax({

          url: 'http://soulangh.tnc.gov.tw/soulangh_booking/booking_api.php',

          type: 'POST',

          dataType: 'json',

          data: {

              'pid':  $("#pid").val(),

              'date': $("#date").val(),

              'range':$("#range").val()

          },

          success: function(response) {

                console.log(response.records);

                if(response.records == 0) {

                  ckpid = true;

                  $("#pid_error").hide();

                } else {

                  ckpid = false;

                  $("#pid_error").show();

                }

          },

            error: function() {

                console.log('error');

            }

      });

    });



  $("#phone").focusout(function(e) {

        e.preventDefault();

        //console.log($("#pid").val());

        //console.log($("#date").val());

        //console.log($("#range").val());



        $.ajax({

          url: 'http://soulangh.tnc.gov.tw/soulangh_booking/booking_api.php',

          type: 'POST',

          dataType: 'json',

          data: {

              'phone':  $("#phone").val(),

              'date': $("#date").val(),

              'range':$("#range").val()

          },

          success: function(response) {

                console.log(response.records);

                if(response.records == 0) {

                  ckphone = true;

                  $("#phone_error").hide();

                } else {

                  ckphone = false;

                  $("#phone_error").show();

                }

          },

            error: function() {

                console.log('error');

            }

      });

    });





});



</script>