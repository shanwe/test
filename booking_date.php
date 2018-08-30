<?php

session_start();

$_SESSION[md5('page')] = 'reservation';

include("sql_config.php");
/*
ini_set('default_charset','utf-8');
$link=mysqli_connect("localhost","root","") or die ("無法開啟Mysql資料庫連結"); //建立mysql資料庫連結
mysqli_select_db($link, "soulangh_SL"); //選擇資料庫abc
*/




if(!empty($_GET['dd'])){

  $action = true;

  $date = base64_decode($_GET['dd']);


//$sql = "SELECT * FROM reservation "; //在test資料表中選擇所有欄位

$sql = "SELECT * FROM reservation WHERE date='".$date."'";

mysqli_query($link, 'SET CHARACTER SET utf8');  // 送出Big5編碼的MySQL指令

mysqli_query($link, "SET collation_connection = utf8_general_ci");

$result = mysqli_query($link,$sql); // 執行SQL查詢

$total_fields=mysqli_num_fields($result); // 取得欄位數

$total_records=mysqli_num_rows($result);  // 取得記錄數

for ($i=0; $i < $total_records; $i++) {
    $data[$i] = mysqli_fetch_assoc($result);
}

$time_period = array('1' => 0, '2' => 0, '3' => 0, '4' => 0);

if(!empty($data))

foreach ($data as $key => $value) {

  if($value['status'])

  $time_period[$value['time_period']] +=$value['people'];

}

$date_end = date('Y-m-d',strtotime(date('Y-m-d')."+7 day"));

if($date_end>$date) {
  ini_set('default_charset','utf-8');
  echo '<script charset="UTF-8">alert("此日期已失效");</script>';
  echo '<script>location.href = "http://soulangh.tnc.gov.tw/soulangh_booking/booking_date.php";</script>';
}

} else {
  $action = false;
}

$date_end = date('Y-m-d',strtotime(date('Y-m-d')."+7 day"));

$sql = "SELECT * FROM close_day";

mysqli_query($link, 'SET CHARACTER SET utf8');  // 送出Big5編碼的MySQL指令

mysqli_query($link, "SET collation_connection = utf8_general_ci");

$result = mysqli_query($link,$sql); // 執行SQL查詢

$total_records=mysqli_num_rows($result);  // 取得記錄數

for ($i=0; $i < $total_records; $i++) {
    $close_day[$i] = mysqli_fetch_assoc($result);
}
//var_dump($close_day);

$date_limit = date('Y-m-d',strtotime('+30 day')); //時間限制

?>

<!DOCTYPE html>

<html lang="zh-Hant">

<head>

<!-- Meta -->

<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<meta name="keywords" content="線上預約-蕭壠文化園區">

<meta name="description" content="線上預約-蕭壠文化園區">

<title>線上預約-蕭壠文化園區</title>

<!-- Favicon -->

<link href="favicon.ico" rel="icon">

<link href="favicon.ico" rel="shortcut icon">

<link href="apple-touch-icon.png" rel="apple-touch-icon">

<link href="assets/css/bootstrap.min.css" rel="stylesheet">

<link href="assets/css/font-awesome.min.css" rel="stylesheet">

<link href="assets/css/zabuto_calendar.min.css" rel="stylesheet">

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

          <li class="current"><div class="icon"><span class="fa fa-calendar"></span>STEP1</div>選擇日期與時段</li>

          <li><div class="icon"><span class="fa fa-pencil-square-o"></span>STEP2</div>填寫人數與基本資料</li>

          <li><div class="icon"><span class="fa fa-ticket"></span>STEP3</div>完成預約</li>

        </ul>

        <form id='form' action="booking_form.php" method="post" onsubmit="return check_radio('form')">

        <input type="hidden" name="date" value="<?=(!empty($date))?$date:''?>">

          <div class="con clearfix">

            <div class="calendar">

              <div class="explain">※ 預約參觀日，請於一週前提前線上預約。</div>
              <div class="explain">※ 預約每個時段總上限人數為50人。</div>
                             <div class="explain">※ 系統提供至次月的預約服務。</div>
                             <div class="explain">※ 請於預約時段15分鐘內報到，未抵達者釋出為現場入場名額。</div>

              <!-- 月曆 -->

              <div id="date-popover" class="popover top" style="cursor: pointer; display: block; margin-left: 33%; margin-top: -50px; width: 175px;">

                  <div class="arrow"></div>

                  <h3 class="popover-title" style="display: none;"></h3>

                  <div id="date-popover-content" class="popover-content"></div>

              </div>

              <div id="my-calendar"></div>

            </div>

            <div class="time" <?=($action)?'':'hidden'?>>

              <div class="day"><strong><?=date('Y',strtotime($date))?>年<?=date('m',strtotime($date))?>月<?=date('d',strtotime($date))?>日</strong>請選擇入場參觀時段</div>

              <ul class="ulset">

                <!-- 已額滿 樣式 -->



              <?php if(($time_period[1]<50)){ ?>

                <li class="clearfix">

                  <label for="range-1" class="item">

                    <input type="radio" name="range" id="range-1" value="1">

                    <span class="select">

                      <span class="range"><i class="fa fa-clock-o"></i>09:00~10:30</span>

                      <span class="remaining"><i class="fa fa-male"></i><span><?=($time_period[1]<=50)?(50-$time_period[1]):'0'?></span>人</span>

                    </span>

                  </label>

                </li>

              <?php } else { ?>

                <li class="full clearfix">

                  <span class="range"><i class="fa fa-clock-o"></i><del>09:00~10:30</del></span>

                  <span class="remaining"><i class="fa fa-male"></i><span>0</span>人</span>

                </li>

              <?php } ?>



              <?php if(($time_period[2]<50)){ ?>

                <li class="clearfix">

                  <label for="range-2" class="item">

                    <input type="radio" name="range" id="range-2" value="2">

                    <span class="select">

                      <span class="range"><i class="fa fa-clock-o"></i>11:00~12:30</span>

                      <span class="remaining"><i class="fa fa-male"></i><span><?=($time_period[2]<=50)?(50-$time_period[2]):'0'?></span>人</span>

                    </span>

                  </label>

                </li>

              <?php } else { ?>

                <li class="full clearfix">

                  <span class="range"><i class="fa fa-clock-o"></i><del>11:00~12:30</del></span>

                  <span class="remaining"><i class="fa fa-male"></i><span>0</span>人</span>

                </li>

              <?php } ?>



              <?php if(($time_period[3]<50)){ ?>

                <li class="clearfix">

                  <label for="range-3" class="item">

                    <input type="radio" name="range" id="range-3" value="3">

                    <span class="select">
                      <span class="range"><i class="fa fa-clock-o"></i>13:30~15:00</span>

                      <span class="remaining"><i class="fa fa-male"></i><span><?=($time_period[3]<=50)?(50-$time_period[3]):'0'?></span>人</span>

                    </span>

                  </label>

                </li>

              <?php } else { ?>

                <li class="full clearfix">

                  <span class="range"><i class="fa fa-clock-o"></i><del>13:30~15:00</del></span>

                  <span class="remaining"><i class="fa fa-male"></i><span>0</span>人</span>

                </li>

              <?php } ?>



                <?php if($time_period[4]<50) { ?>

                <li class="clearfix">

                  <label for="range-4" class="item">

                    <input type="radio" name="range" id="range-4" value="4">

                    <span class="select">

                      <span class="range"><i class="fa fa-clock-o"></i>15:30~16:30</span>

                      <span class="remaining"><i class="fa fa-male"></i><span><?=($time_period[4]<=50)?(50-$time_period[4]):'0'?></span>人</span>

                    </span>

                  </label>

                </li>

                <?php } else { ?>

                <li class="full clearfix">

                  <span class="range"><i class="fa fa-clock-o"></i><del>15:30~16:30</del></span>

                  <span class="remaining"><i class="fa fa-male"></i><span>0</span>人</span>

                </li>

                <?php } ?>

              </ul>

            </div>

          </div>

          <ul class="btn-group ulset">

            <li><a href="booking.php" title="注意事項" class="gray btn">注意事項</a></li>

            <li><button type="submit" value="" class="red btn" >下一步</button></li>

          </ul>

        </form>

      </div>

    </div>

    <?php include('page_footer.php'); ?>

  </div>

</div>



<script src="assets/js/plugins/jQuery/jquery-2.1.4.min.js"></script>

<script src="assets/js/plugins/bootstrap/bootstrap-3.3.7.min.js"></script>

<script src="assets/js/plugins/jQuery/searchform.js"></script>

<script src="assets/js/plugins/jQuery/zabuto_calendar.min.js"></script>

<script src="assets/js/plugins/jQuery/dropdownmenu.js"></script>

<script src="assets/js/jquery.base64.js"></script>

<script>

//var Today=new Date();

//console.log(Today);

// 缺少 非預約日不能點選





$(document).ready(function(e) {



//var date1 = new Date("<?=date('Y')?>/<?=date('m')?>/<?=(date('d')+7)?>");
var today = new Date();
var date1 = today.addDays(7);
var close_day = [ <?php foreach ($close_day as $k => $val) { echo "'".$val['day']."'".","; } ?>];
var date_limit = '<?=$date_limit?>'+"T12:00:00-00:00";
var date_limit_close = new Date(date_limit);

console.log(close_day);
console.log(date_limit);
console.log(date_limit_close);
  $("#date-popover").popover({html: true, trigger: "manual"});

  $("#date-popover").hide();

  $("#date-popover").click(function (e) {

    $(this).hide();

  });



  $("#my-calendar").zabuto_calendar({

    /*action: function () {

      return myDateFunction(this.id, false);

    },

    action_nav: function () {

      return myNavFunction(this.id);

    },*/

    action: function(){

      var action_date = this.id.split("_");
      var date_a = action_date[3]+"T12:00:00-00:00";
      var date2 = new Date(date_a);
      var ck_close_day = jQuery.inArray(action_date[3], close_day);
      var dt = date2.getDay()
      if(date1 < date2 && dt != 1 && dt != 2 && ck_close_day == -1 && date2 <= date_limit_close)
        return date_action(this.id, false);
      else {
        //console.log(action_date[3]);
        if(action_date[3] == '2018-02-19' || action_date[3] == '2018-02-20') {
          return date_action(this.id, false);
        } else {
          return true;
        }
      }
    },

    language: "cn",

    legend: [

      {type: "block", label: "休館日", classname: "closed"},

      {type: "block", label: "可預約", classname: "reserve"},

      {type: "block", label: "已額滿", classname: "fulled"}

    ],

    ajax: {

      <?=($action)?'url: "show_data.php?grade=1&dd='.$date.'"':'url: "show_data.php?grade=1"'?>,

      modal: true

    },

    today: true,
    <?php if($action) { ?>
      <?php if(date('m',strtotime($date))==date('m')) { ?>
              show_previous: false,
              show_next: 1,
      <?php } else { ?>
              <?= ($action)?'year:'.date('Y',strtotime($date)).',':'' ?>
              <?= ($action)?'month:'.date('m',strtotime($date)).',':'' ?>
              show_previous: 1,
              show_next: 0,
      <?php } ?>
    <?php } else { ?>
        show_previous: false,
        show_next: 1,
    <?php } ?>

  });



  var eventData = [

    {"date":"2017-12-20","badge":false,"title":"Example 1", classname: "closed"},

    {"date":"2015-12-08","badge":true,"title":"Example 2", classname: "closed"}

  ];





  $('label.item').on('click', function(e) {

    $('label.item .select').removeClass('custom-radio');

    $('.select', this).addClass('custom-radio');

  });



});



function date_action(id) {

  var action_date = id.split("_");

  var str = $.base64.encode(action_date[3]);

  document.location.href="<?=$base_url?>"+"booking_date.php?dd="+str;

  return true;

}



function check_radio(input1){    // input1 為form name變數



    var flag = false;



    if(document.getElementById("range-1")) {

      if(document.getElementById("range-1").checked)

        flag = true

    }

    if(document.getElementById("range-2")) {

      if(document.getElementById("range-2").checked)

        flag = true

    }

    if(document.getElementById("range-3")) {

      if(document.getElementById("range-3").checked)

        flag = true

    }

    if(document.getElementById("range-4")) {

      if(document.getElementById("range-4").checked)

        flag = true

    }



/*

    if(document.getElementById("range-2"))

      console.log(document.getElementById("range-2").checked);

    if(document.getElementById("range-3"))

      console.log(document.getElementById("range-3").checked);

    if(document.getElementById("range-4"))

      console.log(document.getElementById("range-4").checked);*/

    if(flag){

      return flag;

    } else {

      alert('請選擇預約時段，謝謝！');

      return flag;

    }

}

Date.prototype.addDays = function(days) {
  this.setDate(this.getDate() + days);
  return this;
}

</script>

</body>

</html>