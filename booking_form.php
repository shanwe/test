<?php

session_start();

$_SESSION[md5('page')] = 'reservation';



if(!empty($_POST['date']) && $_POST['range']) {

  $date = $_POST['date'];

  $range = $_POST['range'];

} else {

    header("Location:booking.php");

}

include("sql_config.php");
/*
ini_set('default_charset','utf-8');
$link=mysqli_connect("localhost","root","") or die ("無法開啟Mysql資料庫連結"); //建立mysql資料庫連結
mysqli_select_db($link, "soulangh_SL"); //選擇資料庫abc
*/


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



include("simple-php-captcha.php");

$captcha = simple_php_captcha();

//var_dump($captcha['code']);

//var_dump($_SESSION['captcha']['image_src']);

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

<link href="assets/css/font-awesome.min.css" rel="stylesheet">

<link href="assets/css/common.css" rel="stylesheet">

<!-- js -->

<script src="assets/js/plugins/jQuery/jquery-2.1.4.min.js"></script>

<script src="assets/js/plugins/jQuery/searchform.js"></script>

<script src="assets/js/plugins/jQuery/dropdownmenu.js"></script>

<script src="assets/js/jquery-validation-1.11.1/dist/jquery.validate.min.js"></script>

<script src="assets/js/jquery-validation-1.11.1/dist/my-additional-methods.min.js"></script>

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

        <form id='form' action="main.php" method="post" onsubmit="return check_table('form')">

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

                  <?=(50-$people_num >= 2)? '<option value="2">2人</option>':'' ?>

                  <?=(50-$people_num >= 3)? '<option value="3">3人</option>':'' ?>

                  <?=(50-$people_num >= 4)? '<option value="4">4人</option>':'' ?>

                  <?=(50-$people_num >= 5)? '<option value="5">5人</option>':'' ?>

                </select>

              <span>此時段每人最多可預約人數為 <?=(50-$people_num>5)?'5':(50-$people_num)?> 人，含家長及小朋友</span></div>

            </div>

            <div class="form-group">

              <label for="name" class="">聯絡姓名<strong>*</strong></label>

              <div class="input-txt"><input type="text" name="name" id="name" value="" class="input-style" required><span>請提供正確的全名，以利入館確認</span></div>

            </div>

            <div class="form-group">

              <label for="pid" class="">身份證末四碼<strong>*</strong></label>

              <div class="input-txt">

                <input type="text" name="pid" id="pid" value="" class="input-style" maxlength="4" minlength="4" onkeyup="value=value.replace(/[^\d]/g,'') " required>

                <div id = "pid_num_error" >請填寫完整的身分證末四碼</div>

                <div id = "pid_error" >此時段的身分證末四碼已預約</div>

              </div>

            </div>

            <div class="form-group">

              <label for="phone" class="">行動電話<strong>*</strong></label>

              <div class="input-txt">

                <input type="text" name="phone" id="phone" value="" class="input-style" maxlength="10" minlength="10" onkeyup="value=value.replace(/[^\d]/g,'') " required><span>請提供正確的電話，以利入館確認。例：0910555666</span>

                <div id = "phone_num_error" hidden>請填寫完整的行動電話</div>

                <div id = "phone_error" hidden>此時段的行動電話已預約</div>

              </div>

            </div>

            <div class="form-group">

              <label for="email" class="">電子信箱<strong>*</strong></label>

              <div class="input-txt">

                <input type="email" name="email" id="email" value="" class="input-style" required><span>請使用可正常收發的信箱</span>

                <div id = "email_error" hidden>email信箱格式錯誤</div>

              </div>

            </div>

            <div class="code form-group">

              <label for="code" class="">驗證碼<strong>*</strong></label>

              <div class="input-txt">

                <input type="text" name="captcha" id="captcha" value="" class="input-style" maxlength="4" minlength="4" required>

                <!--<div class="code-img"><img src="assets/images/del/code.gif" alt="code"></div>-->

                <div class="code-img"><img id="captcha_img" src="<?=$captcha['image_src']?>" alt="code"></div><span>不分大小寫，點選圖片可更新驗證碼</span>

              </div>

            </div>

            <div class="statement form-group">

              <label class="check">
                <input type="checkbox" name="check_box" id="check_box" value="1"  ><span></span>
                我已詳細閱讀並接受<a href="statement.php" target="_blank" title="個資保護聲明">個資保護聲明</a>
              </label>

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

</body>

</html>



<script type="text/javascript">



var ckpid = true;

var cknumpid = true;

var ckphone = true;

var cknumphone = true;

var ckcaptcha = true;

var ckemail = true;



var captcha = '<?=$captcha['code']?>';



$(document).ready(function(e) {



  $("#pid_error").hide();

  $("#pid_num_error").hide();



  $("#captcha_img").click(function(e) {

      $.ajax({

        url: '<?=$base_url?>'+'captcha_api.php',

        type: 'POST',

        dataType: 'json',

        data: {},

        success: function(response) {

            image = document.getElementById('captcha_img');

            image.src = '<?=$site_url?>'+response.image_src;

            captcha = response.code;

        },

        error: function() {

            //console.log('error');

        }

    });

  });



  $("#pid").focusout(function(e) {

        e.preventDefault();

        //console.log($("#pid").val().length);

        if($("#pid").val().length == 4) {

          $("#pid_num_error").hide();

          cknumpid = true;

          $.ajax({

            url: '<?=$base_url?>'+'booking_api.php',

            type: 'POST',

            dataType: 'json',

            data: {

                'pid':  $("#pid").val(),

                'date': $("#date").val(),

                'range':$("#range").val()

            },

            success: function(response) {

                  //console.log(response.records);

                  if(response.records == 0) {

                    ckpid = true;

                    $("#pid_error").hide();

                  } else {

                    ckpid = false;

                    $("#pid_error").show();

                  }

            },

            error: function() {

                  //console.log('error');

            }

          });

        } else {

          cknumpid = false;

          $("#pid_num_error").show();

        }

  });



  $("#email").focusout(function(e) {

        e.preventDefault();

        if(IsEmail($("#email").val())){

          ckemail = true;

          $("#email_error").hide();

        } else {

          ckemail = false;

          $("#email_error").show();

        }

  });





  $("#phone_error").hide();

  $("#phone_num_error").hide();



  $("#phone").focusout(function(e) {

        e.preventDefault();

        if($("#phone").val().length == 10) {

          $("#phone_num_error").hide();

          cknumphone = true;

          $.ajax({

            url: '<?=$base_url?>'+'booking_api.php',

            type: 'POST',

            dataType: 'json',

            data: {

                'phone':  $("#phone").val(),

                'date': $("#date").val(),

                'range':$("#range").val()

            },

            success: function(response) {

                  //console.log(response.records);

                  if(response.records == 0) {

                    ckphone = true;

                    $("#phone_error").hide();

                  } else {

                    ckphone = false;

                    $("#phone_error").show();

                  }

            },

              error: function() {

                  //console.log('error');

              }

          });

        } else {

          cknumphone = false;

          $("#phone_num_error").show();

        }

    });



  $("#captcha").focusout(function(e) {

        e.preventDefault();

        if(captcha == $("#captcha").val().toUpperCase()){

          ckcaptcha = true;

          //console.log('驗證碼正確');

        } else {

          ckcaptcha = false;

          //console.log('驗證碼錯誤');

        }



    });





});



function IsEmail(email) {

        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        if(!regex.test(email)) {

            return false;

        }else{

            return true;

        }

    }





function check_table(input1){    // input1 為form name變數



    var flag = false;



    if(document.getElementById("range-1")) {

      if(document.getElementById("range-1").checked)

        flag = true

    }
/*
   if($("input#check_box").attr('checked',true)){
      alert('尚未勾選同意個資保護聲明，請點選同意後再嘗試送出表單，謝謝！');
      return flag;
   }
*/
        var field = document.getElementsByName('check_box');
        var fieldYN = new Boolean();
        var fieldYN = false;
        var field_arr=[];
        for (var i=0; i<field.length; i++) {
        if (field[i].checked) {
            field_arr.push(field[i].value);
            fieldYN = true;
          }
        }
        console.log(fieldYN);

    if(!fieldYN) {
      alert('尚未勾選同意個資保護聲明，請點選同意後再嘗試送出表單，謝謝！');
      return flag;
    } else if(!ckpid) {

      alert('此時段的身分證末四碼已預約，請重新填寫，謝謝！');

      return flag;

    } else if(!cknumpid) {

      alert('請填寫完整的身分證末四碼，謝謝！');

      return flag;

    } else if(!ckphone) {

      alert('此時段的行動電話已預約，請重新填寫，謝謝！');

      return flag;

    } else if(!cknumphone) {

      alert('請填寫完整的行動電話，謝謝！');

      return flag;

    } else if(!ckemail) {

      alert('電子信箱格式錯誤，請重新填寫，謝謝！');

      return flag;

    } else if(!ckcaptcha) {

      alert('驗證碼錯誤，請重新填寫，謝謝！');

      return flag;    }



    if(ckpid && ckphone) {

      flag = true;

      return flag;

    }



}



</script>