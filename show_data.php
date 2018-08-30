<?php
/**
 * Example of JSON data for calendar
 *
 * @package zabuto_calendar
 */

include("sql_config.php");
/*
ini_set('default_charset','utf-8');
$link=mysqli_connect("localhost","root","") or die ("無法開啟Mysql資料庫連結"); //建立mysql資料庫連結
mysqli_select_db($link, "soulangh_SL"); //選擇資料庫abc
*/
$sql = "SELECT * FROM close_day ";

mysqli_query($link, 'SET CHARACTER SET utf8');  // 送出Big5編碼的MySQL指令

mysqli_query($link, "SET collation_connection = utf8_general_ci");

$result = mysqli_query($link,$sql); // 執行SQL查詢

$total_fields=mysqli_num_fields($result); // 取得欄位數

$total_records=mysqli_num_rows($result);  // 取得記錄數

for ($j=0; $j < $total_records; $j++) {
    $query[$j] = mysqli_fetch_assoc($result);
    $close_day[$j] = $query[$j]['day'];
}

 //var_dump(date('Y-m-d'));
 //var_dump(date('Y-m-d',strtotime('+30 day')));
//var_dump(strtotime('2018-13-31'));
    $date_limit = date('Y-m-d',strtotime('+30 day'));
 //$date_limit = date('Y').'-'.str_pad((date('m')+1),2,"0",STR_PAD_LEFT).'-'.str_pad((date('d')+7),2,"0",STR_PAD_LEFT);

if (!empty($_REQUEST['year']) && !empty($_REQUEST['month'])) {
    $year = intval($_REQUEST['year']);
    $month = intval($_REQUEST['month']);
    $lastday = intval(strftime('%d', mktime(0, 0, 0, ($month == 12 ? 1 : $month + 1), 0, ($month == 12 ? $year + 1 : $year))));

    $dates = array();


    for ($i = 1; $i <= 31; $i++) {
        $date = $year.'-'.str_pad($month, 2, '0', STR_PAD_LEFT).'-'.str_pad($i, 2, '0', STR_PAD_LEFT);

        $sql = "SELECT * FROM reservation WHERE date='".$date."'";

        mysqli_query($link, 'SET CHARACTER SET utf8');  // 送出Big5編碼的MySQL指令

        mysqli_query($link, "SET collation_connection = utf8_general_ci");

        $result = mysqli_query($link,$sql); // 執行SQL查詢

        $total_fields=mysqli_num_fields($result); // 取得欄位數

        $total_records=mysqli_num_rows($result);  // 取得記錄數

        $data = null;
        for ($j=0; $j < $total_records; $j++) {
            $data[$j] = mysqli_fetch_assoc($result);
        }

        $people_num = 0;
        if(!empty($data)){
            foreach ($data as $key => $value) {
                if($value['status'] == 1)
                    $people_num += $value['people'];
            }
        }

        $date_end = date('Y-m-d',strtotime(date('Y-m-d')."+7 day"));

        $weekday  = date('w', strtotime($date));
//var_dump($date);

        if( $weekday == 1 || $weekday == 2 || in_array($date, $close_day)){
            $dates[$i] = array(
                'date' => $date,
                'badge' => false,
                'classname' => 'closed'
            );
        } else {
            if(strtotime($date_end)>strtotime($date)){
                $dates[$i] = array(
                    'date' => $date,
                    'badge' => false,
                    'classname' => 'capped'
                );
            }
        }

        if($people_num >= 200) {
            $dates[$i] = array(
                'date' => $date,
                'badge' => false,
                'classname' => 'fulled'
            );
        }

        if((strtotime($date) > strtotime($date_limit))  && $weekday != 1 && $weekday != 2  ) {
                $dates[$i] = array(
                    'date' => $date,
                    'badge' => false,
                    'classname' => 'capped'
                );
        }

        if(!empty($_GET['dd'])){
            if($date == $_GET['dd'])
            $dates[$i] = array(
                'date' => $_GET['dd'],
                'badge' => false,
                'classname' => 'current'
            );
        }
    }


    //mysql_close();
    echo json_encode($dates);

} else {
    echo json_encode(array());
}


/*
        if (!empty($_REQUEST['grade'])) {
            $dates[$i]['badge'] = false;
            $dates[$i]['classname'] = 'capped';
        }

        if (!empty($_REQUEST['action'])) {
            $dates[$i]['title'] = 'Action for ' . $date;
            $dates[$i]['body'] = '<p>The footer of this modal window consists of two buttons. One button to close the modal window without further action.</p>';
            $dates[$i]['body'] .= '<p>The other button [Go ahead!] fires myFunction(). The content for the footer was obtained with the AJAX request.</p>';
            $dates[$i]['body'] .= '<p>The ID needed for the function can be retrieved with jQuery: <code>dateId = $(this).closest(\'.modal\').attr(\'dateId\');</code></p>';
            $dates[$i]['body'] .= '<p>The second argument is true in this case, so the function can handle closing the modal window: <code>myFunction(dateId, true);</code></p>';
            $dates[$i]['footer'] = '
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="dateId = $(this).closest(\'.modal\').attr(\'dateId\'); myDateFunction(dateId, true);">Go ahead!</button>
            ';
        }
 */