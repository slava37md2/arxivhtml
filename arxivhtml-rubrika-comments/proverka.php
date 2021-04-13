<?php
//$h = file_get_contents('http://localhost/arxivhtml-rubrika-comments/articles/2011/1/50/63/html.php');
//echo $h;// Проверяем отдаст ли серверу файл html.php



/*$MSSQLdatetime = "2020-11-26 09:48:06";
//$newDatetime = preg_replace('/:[0-9][0-9][0-9]/','',$MSSQLdatetime);
$time = strtotime($MSSQLdatetime);
echo $today = date("Y-m-d H:i:s",$time);*/

echo $_SERVER['REMOTE_ADDR'];
?>
