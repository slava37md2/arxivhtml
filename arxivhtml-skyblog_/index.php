<?php
#	....................... ..........................................................
#
#		Скрипт:	Sky Blog, версия: 1.0
#		Автор:	Sky (http://skystudio.ru http://skyscript.ru)
#
#	.................................................................................
include "db.php"; 
if (isset($_GET['id'])) {$id = mysqli_real_escape_string($db, $_GET['id']); }
if (isset($_GET['catid'])) {$catid = mysqli_real_escape_string($db, $_GET['catid']); }
if (!isset($catid)) { $catid=1; }

// выбор категории            
$skybase01 = mysqli_query($db,"SELECT * FROM skyblog_cat  WHERE id='$catid'");
if (!$skybase01)
{ echo "<p>База данных не доступна<br> <strong>Ошибка: </strong></p>";
exit(mysqli_error($db)); }
if (mysqli_num_rows($skybase01) > 0)
{  $skyrow01 = mysqli_fetch_array($skybase01); 
$kslova = $skyrow01["kslova"];
$descript = $skyrow01["descript"];
$textcat = $skyrow01["textcat"];
}
else {
echo "<p>Категорий нет</p>";
 }	
		
?>
<html>
<head>
<link rel="shortcut icon" href="pic/skyico.ico">
<meta http-equiv="Content-Type" content="text/html; charset=UTF8" />
<meta name="keywords" content="<?php echo $kslova; ?>" />
<meta name="description" content="<?php echo $descript; ?>"  />
<title>SkyScript — Простые бесплатные PHP-скрипты</title>
<link href="st.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="scripts/form.js"></script>
</head>
<body>
<?php include("verh.php"); ?>

<table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="220" valign="top">
<?php include("left.php"); ?>    
    </td>
    <td width="20">&nbsp;</td>
    <td valign="top">
    
    
<?php
//постраничная навигация 
$skybasenav = mysqli_query($db, "SELECT na_str FROM skyblog_nastr");
$skyrow5 = mysqli_fetch_array($skybasenav);
$num = $skyrow5["na_str"];
@$page = $_GET['page'];
$skybase1 = mysqli_query($db, "SELECT COUNT(*) FROM skyblog_blog WHERE cat='$catid'");
$temp = mysqli_fetch_array($skybase1);
$posts = $temp[0];
$total = (($posts - 1) / $num) + 1;
$total =  intval($total);
$page = intval($page);
if(empty($page) or $page < 0) $page = 1;
if($page > $total) $page = $total;
$start = $page * $num - $num;
if ($start < 0) { $start = 0;}

// Проверяем нужны ли стрелки назад
if ($page != 1) $pervpage = '<a href=index.php?catid='.$catid.'&page=1>первая</a> | <a title=предидущая  href=index.php?catid='.$catid.'&page='. ($page - 1) .'><--</a> | ';
if ($total > 5 and $page > 6) { $toch = ' .... | '; }
$page2 = $total - $page;
if ($total > 5 and $page2 >= 6) { $toch2 = ' | .... '; }

// Проверяем нужны ли стрелки вперед
if ($page != $total) $nextpage = ' | <a title=следующая href=index.php?catid='.$catid.'&page='. ($page + 1) .'>--></a> | <a href=index.php?catid='.$catid.'&page=' .$total. '>последняя</a>';

// Находим две ближайшие станицы с обоих краев, если они есть
if($page - 5 > 0) $page5left = ' <a href=index.php?catid='.$catid.'&page='. ($page - 5) .'>'. ($page - 5) .'</a> | ';
if($page - 4 > 0) $page4left = ' <a href=index.php?catid='.$catid.'&page='. ($page - 4) .'>'. ($page - 4) .'</a> | ';
if($page - 3 > 0) $page3left = ' <a href=index.php?catid='.$catid.'&page='. ($page - 3) .'>'. ($page - 3) .'</a> | ';
if($page - 2 > 0) $page2left = ' <a href=index.php?catid='.$catid.'&page='. ($page - 2) .'>'. ($page - 2) .'</a> | ';
if($page - 1 > 0) $page1left = '<a href=index.php?catid='.$catid.'&page='. ($page - 1) .'>'. ($page - 1) .'</a> | ';

if($page + 5 <= $total) $page5right = ' | <a href=index.php?catid='.$catid.'&page='. ($page + 5) .'>'. ($page + 5) .'</a>';
if($page + 4 <= $total) $page4right = ' | <a href=index.php?catid='.$catid.'&page='. ($page + 4) .'>'. ($page + 4) .'</a>';
if($page + 3 <= $total) $page3right = ' | <a href=index.php?catid='.$catid.'&page='. ($page + 3) .'>'. ($page + 3) .'</a>';
if($page + 2 <= $total) $page2right = ' | <a href=index.php?catid='.$catid.'&page='. ($page + 2) .'>'. ($page + 2) .'</a>';
if($page + 1 <= $total) $page1right = ' | <a href=index.php?catid='.$catid.'&page='. ($page + 1) .'>'. ($page + 1) .'</a>';

// выбор статей из выбранной категории   
echo "<div class=zag>".$textcat."</div>";       
$skybase3 = mysqli_query($db, "SELECT * FROM skyblog_blog  WHERE cat='$catid' ORDER BY id DESC LIMIT $start, $num");
if (!$skybase3)
{ echo "<p>База данных не доступна<br> <strong>Ошибка: </strong></p>";
exit(mysqli_error($db)); }
if (mysqli_num_rows($skybase3) > 0)
{  $skyrow3 = mysqli_fetch_array($skybase3); 

do {
if (!empty($skyrow3["pic"])) { $picbl = "<img style='margin-right:10px;' border=0 src='picblog/".$skyrow3["pic"]."' align=left />"; }
else { $picbl = "";}
printf ("<div class='bolokno_verh'></div>
    	<div class='bolokno_bg'>
		  <div class='bolokno_title'><a href=wievblog.php?id=%s>%s %s</a></div> 
  			<div class='bolokno_int'>%s %s<br><br><span class=sm>%s |  Добавил: <b>%s</b> | Просмотров: <b>%s</b></span></div> 
			
    	</div>
    <div class='bolokno_niz'></div>", $skyrow3["id"], $skyrow3["idarxiv"], $skyrow3["title"], $picbl, $skyrow3["cortext"], $skyrow3["data"], $skyrow3["avtor"], $skyrow3["prosmotr"]);

}
while ($skyrow3 = mysqli_fetch_array($skybase3));

}
else {

$skybase_cat = mysqli_query($db, "SELECT cattitle FROM skyblog_cat WHERE id='$catid'");
$skyrow_cat = mysqli_fetch_array($skybase_cat);

echo "<div>Категория <b>".$skyrow_cat["cattitle"]."</b> не содержит статей.</div>";

}			
		
// Вывод меню если страниц больше одной
if ($total > 1)
{
Error_Reporting(E_ALL & ~E_NOTICE);
echo "<center><div class=\"pstrnav\">";
echo $pervpage.$toch.$page5left.$page4left.$page3left.$page2left.$page1left.'<b>'.$page.'</b>'.$page1right.$page2right.$page3right.$page4right.$page5right.$toch2.$nextpage;
echo "</div><br>";
}			
			
?>   

    </td>
  </tr>
</table>


<br><br><br><br><br>

<?php include("niz.php"); ?>
</body>
</html>
