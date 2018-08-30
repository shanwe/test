<?php

session_start();

$_SESSION[md5('page')] = 'inquire';

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

      <div class="inquire">

        <div class="note">您可以透過預約時填寫的聯絡人資訊，查詢預約資料或取消預約。</div>

        <form action="inquire_info.php" method="post">

          <div class="form">

            <div class="form-group">

              <label for="id" class="">身份證末四碼<strong>*</strong></label>

              <div class="input-txt"><input type="text" name="pid" id="pid" value="" class="input-style" maxlength="4" minlength="4" required ></div>

            </div>

            <div class="form-group">

              <label for="phone" class="">行動電話<strong>*</strong></label>

              <div class="input-txt"><input type="text" name="phone" id="phone" placeholder="例：0910555666" value="" class="input-style" maxlength="10" minlength="10" required></div>

            </div>

          </div>

          <button type="submit" value="" class="search red btn"><span class="fa fa-search"></span>查詢</button>

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