<?php

session_start();

$_SESSION[md5('page')] = 'reservation';
include("sql_config.php");

?>

<!DOCTYPE html>

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

      <div class="precautions">

        <div class="ti"><span class="fa fa-bell-o"></span>【預約系統注意事項】</div>

        <div class="txt">

          <ol type="1">

            <li>

              <div>兒童遊戲館開放場次 ── (每週三至週日)</div>

              1. 第一場09:00~10:30<br>2. 第二場11:00~12:30<br>3. 第三場13:30~15:00<br>4. 第四場15:30~16:30<br>

            </li>

            <li>

              <div>每場入場時間 ── </div>

              1. 第一場入場時間09:00~09:15，開放候補進場時間09:16~09:20<br>
              2. 第二場入場時間11:00~11:15，開放候補進場時間11:16~11:20<br>
              3. 第三場入場時間13:30~13:45，開放候補進場時間13:46~13:50<br>
              4. 第四場入場時間15:30~15:45，開放候補進場時間15:46~15:50<br>
              <span>註：網路預約者，15分鐘內未報到，逾時視同放棄，釋出為現場名額。</span>
            </li>

            <li>

              <div>館內人數限制 ──</div>

              <p>每場入館人次上限100位(含家長及小朋友)，開放網路預約50名，開館日現場每天上午9時開始入場，請依時段進場。</p>

            </li>

            <li>
              <div>遊戲館入館對象 ──</div>
              <p>為維護兒童遊戲館的遊玩品質與安全，遊戲館入館對象為0-10歲之兒童，每位兒童須至少1位成人陪同，每名成人最多帶4位小朋友入場(含團體遊客、幼兒園、安親班等)。</p>

            </li>

            <li>

              <div>線上預約注意事項 ──</div>
                <p>預約系統網站於預定參觀日期前1個月開放預約，必須於預定參觀日期7天前完成線上預約。</p>
                <p>預約系統網址:<a href="http://soulangh.tnc.gov.tw/soulangh_booking/booking.php"> http://soulangh.tnc.gov.tw/soulangh_booking/booking.php</a></p>

            </li>

            <li>
              <div>館內禁止飲食，及請勿自行攜帶玩具入館。</div>
            </li>

            <li>
              <div>使用設備時，請家長、照顧者務必陪同在旁，注意小朋友安全!</div>
            </li>


            <li>
              <div>【線上預約注意事項】 ──</div>
                1. 預約時請務必使用真實姓名預約，以免影響自身權益。<br>
                2. <span class="marking" >本系統提供未來30日以內之預約，需於入館日7天前完成預約</span>，當日凌晨00:00時開始網路預約，如遇特殊情形，如3/29、30、31之參觀日因2月無相當日可供對應時，皆於3/1凌晨00:00開放，其餘月份則依此類推。<br>
                3. 網路線上預約每場人數為50人，<span class="marking" >必須於預定參觀日期7天前完成線上預約。</span><br>
                4. <span class="marking" >請於預約時段15分鐘內報到</span>，未抵達者視同放棄，釋出為現場入場名額。<br>
                5. 欲變更預約人數，請先取消預約後再重新線上預約。<br>
                6. 完成畫面中需顯示預約代號才算成功，請務必以「預約查詢 / 取消」功能檢查您的預約是否成立！<br>
                7. 欲取消預約，請於參觀日前一天完成。例：參觀日為26號，需於25號晚間12點前取消預約。<br>
            </li>

          </ol>
          <div class="agree">
            <label class="check">
              <input type="checkbox" id="read_check" name="read_check" value="1"><span></span>
              我已了解預約注意事項，可以進入預約流程。
            </label>
          </div>
          <!-- <input type="checkbox" id="read_check" name="read_check" value="1">
          <label for="subscribeNews">我已了解預約注意事項，可以進入預約流程。</label> -->

        </div>

        <ul class="btn-group ulset">

          <li><a href="http://soulangh.tnc.gov.tw/index.php" title="回首頁" class="gray btn">回首頁</a></li>

          <li><a id="ck_btn" href="javascript:;" title="我已了解，進入預約流程" class="red btn">進入預約流程</a></li>
<!-- booking_date.php -->
        </ul>

      </div>

    </div>

    <?php include('page_footer.php'); ?>

  </div>

</div>

<script src="assets/js/plugins/jQuery/jquery-2.1.4.min.js"></script>

<script src="assets/js/plugins/jQuery/searchform.js"></script>

<script src="assets/js/plugins/jQuery/dropdownmenu.js"></script>

<script>

$(document).ready(function(e) {

  $('#ck_btn').on('click', function(e){

    var obj=document.getElementsByName("read_check");

    console.log(obj[0].checked);

    if(obj[0].checked == true) {
      document.location.href="<?=$base_url?>booking_date.php";
    } else {
      alert('請勾選已了解預約注意事項，謝謝。');
    }

  });

});


</script>
</body>
</html>