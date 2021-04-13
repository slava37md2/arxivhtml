<?php
#	....................... ..........................................................
#
#		Скрипт:	Sky Blog, версия: 1.0
#		Автор:	Sky (http://skystudio.ru http://skyscript.ru)
#
#	.................................................................................
require "pass.php";
include "../db.php"; 
if (isset($_GET['id'])) {$id = $_GET['id']; }
if (isset($_GET['catid'])) {$catid = $_GET['catid']; }
if (isset($_POST['catid'])) {$catid = $_POST['catid']; }
if (isset($_POST['catizm'])) {$catizm = $_POST['catizm']; }
if (isset($_POST['act'])) {$act = $_POST['act']; }
if (!isset($catid)) { $catid=1; }

if (isset($_POST['file'])) { $file = $_POST['file']; }
	if (isset($_POST['title'])) { $title = $_POST['title']; }
	if (isset($_POST['cattitle'])) { $cattitle = $_POST['cattitle']; }
	if (isset($_POST['kslova'])) { $kslova = $_POST['kslova']; }
	if (isset($_POST['descript'])) { $descript = $_POST['descript']; }
	if (isset($_POST['textcat'])) { $textcat = $_POST['textcat']; }
	if (isset($_POST['cortext'])) { $cortext = $_POST['cortext']; }
	if (isset($_POST['text'])) { $text = $_POST['text']; }
	if (isset($_POST['avtor'])) { $avtor = $_POST['avtor']; }
	
	
	
function russian_date() {
   $translation = array(
      "am" => "дп",
      "pm" => "пп",
      "AM" => "ДП",
      "PM" => "ПП",
      "Monday" => "Понедельник",
      "Mon" => "Пн",
      "Tuesday" => "Вторник",
      "Tue" => "Вт",
      "Wednesday" => "Среда",
      "Wed" => "Ср",
      "Thursday" => "Четверг",
      "Thu" => "Чт",
      "Friday" => "Пятница",
      "Fri" => "Пт",
      "Saturday" => "Суббота",
      "Sat" => "Сб",
      "Sunday" => "Воскресенье",
      "Sun" => "Вс",
      "January" => "Января",
      "Jan" => "Янв",
      "February" => "Февраля",
      "Feb" => "Фев",
      "March" => "Марта",
      "Mar" => "Мар",
      "April" => "Апреля",
      "Apr" => "Апр",
      "May" => "Мая",
      "May" => "Мая",
      "June" => "Июня",
      "Jun" => "Июн",
      "July" => "Июля",
      "Jul" => "Июл",
      "August" => "Августа",
      "Aug" => "Авг",
      "September" => "Сентября",
      "Sep" => "Сен",
      "October" => "Октября",
      "Oct" => "Окт",
      "November" => "Ноября",
      "Nov" => "Ноя",
      "December" => "Декабря",
      "Dec" => "Дек",
      "st" => "ое",
      "nd" => "ое",
      "rd" => "е",
      "th" => "ое",
      );
   if (func_num_args() > 1) {
      $timestamp = func_get_arg(1);
      return strtr(date(func_get_arg(0), $timestamp), $translation);
   } else {
      return strtr(date(func_get_arg(0)), $translation);
   };
}
$data = russian_date("j F, Y года, H:i");   


?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>SkyScript — Простые бесплатные PHP-скрипты</title>
<link rel="shortcut icon" href="pic/skyico.ico">
<link href="../st.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../scripts/forma.js"></script>
</head>
<body>
<?php 
if (isset($_GET['act'])) { $act = $_GET['act']; }
if (isset($_POST['act'])) { $act = $_POST['act']; }
if (isset($_POST['cattitle'])) { $cattitle = $_POST['cattitle']; 
$cattitle = trim($cattitle); $cattitle = stripslashes($cattitle); $cattitle = htmlspecialchars($cattitle);
}
//добавление категорий
if (isset($act) && $act=="addcat" && !empty($cattitle))
{
$skybaseaddcat = mysqli_query ($db, "INSERT INTO skyblog_cat (cattitle) VALUES ('$cattitle')");
}
//удаление категорий
if (isset($act) && $act=="delcat" && !empty($catid))
{
		//проверка заполненноти категории
		$skybasepicpr = mysqli_query($db,"SELECT * FROM skyblog_blog WHERE cat='$catid' ORDER BY id");
		if (!$skybasepicpr)
		{
		echo "<p>Запрос к базе неудачен.<br> <strong>Ошибка: </strong></p>";
		exit(mysqli_error($db));
		}
		
			if (mysqli_num_rows($skybasepicpr) > 0)
			
			{
			echo "<center><br><div class=alert>Раздел содержит статьи, удалите сначала их</div></center>"; 
			}
			
			else
			{
				if ($catid == 1) { echo "<center><br><div class=alert>Основной раздел удалить нельзя!</div></center>"; }
				else { $skybasedelcat = mysqli_query ($db, "DELETE FROM skyblog_cat WHERE id='$catid'"); }
			}
}

//удаление статей
if (isset($act) && $act=="delblog" && !empty($catid))
{

$skybasedelpic = mysqli_query($db, "SELECT pic FROM skyblog_blog WHERE id='$id'");
$skyrowdelpic = mysqli_fetch_array($skybasedelpic);

if (!empty($skyrowdelpic["pic"]))
			{
			$delpic=$skyrowdelpic["pic"];
			$skybasedelpic2 = mysqli_query($db, "SELECT pic FROM skyblog_blog WHERE pic='$delpic'");
				if (mysqli_num_rows($skybasedelpic2) <= 1)
				{
				if (is_file("../picblog/$delpic")) unlink ("../picblog/$delpic"); 
				}
			}
$skybasedelblog = mysqli_query ($db, "DELETE FROM skyblog_blog WHERE id='$id'"); 
$skybasedelcom = mysqli_query ($db, "DELETE FROM skyblog_coment WHERE comblog='$id'"); 


}


include("../verh.php"); 

?>






<table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="220" valign="top">
<?php include("lefta.php"); ?>    
    </td>
    <td width="20">&nbsp;</td>
    <td valign="top">
    
    
<?php
//редактирование категорий
if (isset($act) && $act=="redcat")
{
	if ($catizm == 1)
	{
	$izmenencat = mysqli_query ($db, "UPDATE skyblog_cat SET cattitle='$cattitle',kslova='$kslova',descript='$descript',textcat='$textcat' WHERE id='$catid'");
		if (!$izmenencat)
			{
			echo "<br><div class=alert>Запрос к базе неудачен.<br> <strong>Ошибка: </strong></div>";
			exit(mysqli_error($db));
			}
	}

	$skybaseredcat = mysqli_query($db, "SELECT * FROM skyblog_cat WHERE id='$catid'");
	$skyrowredcat = mysqli_fetch_array($skybaseredcat);

echo "
<center><form name=formredcat action='index.php?act=redcat' method='post'>
<table>  
<tr>
    <td align='left'>Название категории:</td>
    <td align='left'><input maxlength='255' value='".$skyrowredcat["cattitle"]."' class=bginp2 onblur=inputBG(this,0)  onfocus=inputBG(this,1)  name='cattitle' type='text' size='43'/></td>
  </tr>
  
  <tr>
    <td align='left'>Ключевые слова:</td>
    <td align='left'><input maxlength='255' value='".$skyrowredcat["kslova"]."' class=bginp2 onblur=inputBG(this,0)  onfocus=inputBG(this,1)  name='kslova' type='text' size='43'/></td>
  </tr>
  
    <tr>
    <td align='left'>Дискрипшн:</td>
    <td align='left'><textarea class=bginp2 onblur=inputBG(this,0)  onfocus=inputBG(this,1) name='descript' cols='33' rows='3'>".$skyrowredcat["descript"]."</textarea></td>
  </tr>
  
  <tr>
    <td align='left'>Текст приветствия:</td>
    <td align='left'><textarea class=bginp2 onblur=inputBG(this,0)  onfocus=inputBG(this,1) name='textcat' cols='33' rows='3'>".$skyrowredcat["textcat"]."</textarea></td>
  </tr>
  
   <tr>
    <td colspan='2' align='center'><input type='hidden' name='catid' value='".$catid."' />
	<input type='hidden' name='catizm' value='1' />
<input type='submit' value='Внести изменения' /></td>
  </tr></table>
</form><br><br></center>

";

}


//добавление статьи
if (isset($act) && $act=="addblog")
{       

	if (!empty($title) && !empty($cortext) && !empty($text) && !empty($avtor)) 
	{
	$filename = $_FILES['file']['name'];
	
	if (isset($filename) && $filename != "") {
			//изменение картинки
			function file_sm2($bil, $stal, $width, $height, $quality=100)
					{
					  if (!file_exists($bil)) return false;
					  $size = getimagesize($bil);
					  if ($size === false) return false;
					
					  $icfunc = imagecreatefromstring(file_get_contents($bil));
						
					  $x_ratio = $width / $size[0];
					  $y_ratio = $height / $size[1];
					
					  $ratio       = min($x_ratio, $y_ratio);
					  $use_x_ratio = ($x_ratio == $ratio);
					
					  $new_width   = $use_x_ratio  ? $width  : floor($size[0] * $ratio);
					  $new_height  = !$use_x_ratio ? $height : floor($size[1] * $ratio);
					
					  $isrc = $icfunc;
					  $idest = imagecreatetruecolor($new_width, $new_height);
								
					  imagecopyresampled($idest, $isrc, 0, 0, 0, 0, 
					  $new_width, $new_height, $size[0], $size[1]);
					
					  imagejpeg($idest, $stal, $quality);
					
					  imagedestroy($isrc);
					  imagedestroy($idest);
					
					  return true;
					}
					
			//добавление изображений
			
				$filedir = "picblog";
				$filename = $_FILES['file']['name'];
				$filesize = $_FILES['file']['size'];
				$dopus=array("gif","jpg","jpeg","png"); 
				$rash = strtolower(substr($filename, 1 + strrpos($filename, ".")));
				
					if (!in_array($rash, $dopus)) { 
					echo "<center><div class=alert>Разрешены изображения с расширениями: gif, jpg, jpeg, png</div><br></center>"; $osh=1; }
			
				$filedir2 = "../$filedir";	
			
				$tochka = substr_count($filename, "."); 
				if ($tochka > 1) 
				{ echo "<center><div class=alert>Запрещенный файл! Более одной точки</div><br></center>\r\n"; $osh=1; }
				
				if (!preg_match("/^[a-z0-9\.\-_]+\.(jpg|gif|png|)+$/is",$filename)) 
				{ echo "<center><div class=alert>Название изображения содержит запрещенные символы</div><br></center>"; $osh=1; }
			
			//	$smfile = "sm_$filename";
			//	$filename2 = "b_$filename";
			
//				if (file_exists("$filedir2/$filename")) 
//				{ echo "<br><div class=alert>Такое имя файла уже существует!</div>"; }
			
			
				$filekb = round($filesize/10.24)/100;
				$filexy=getimagesize($_FILES['file']['tmp_name']);
				$gor = $filexy[0];
				$ver = $filexy[1];
				
				if ($filesize > "0" && $osh != 1) {
				copy ($_FILES['file']['tmp_name'], $filedir2."/".$filename);
				}
				else { echo "<center><div class=alert>Изображение не загружено!</div><br></center>"; 
			
				}
			
					if (file_sm2("$filedir2/$filename", "$filedir2/$filename", 100, 100))
					{ echo ''; }
					else  
					{ echo '<center><div class=alert>Ошибка маштабирования</div><br></center>'; }
	
	
	
		}
	

	
						if ($osh!=1) 
						{	
	

			$skybaseaddblog = mysqli_query ($db, "INSERT INTO skyblog_blog (cat,title,kslova,descript,cortext,text,avtor,data,pic) VALUES ('$catid','$title','$kslova','$descript','$cortext','$text','$avtor','$data','$filename')");
									
							if (!$skybaseaddblog)
							{
							echo "<br><div class=alert>Статья не добавлена.<br> <strong>Ошибка: </strong></div>";
							exit(mysqli_error($db));
							}
			
						}
			
			
		
			

	
	}
	else { echo "<center><br><div class=alert>Заполнены должны быть все поля помеченные звездочкой</div></center>"; }
	
}


?>



<TABLE cellSpacing=1 cellPadding=1 width=500 align=center border=0>
<TBODY>
  <TR>
    <TD align=middle>
    
    <div class="dob"><a style="CURSOR: hand" id=SmilesText onclick=SmilesTable() class="dob">Добавить статью</a></div>
     
      
      </TD></TR>
  <TR id=SmilesTr style="DISPLAY: none">
    <TD align=middle>
    
    
      <TABLE border=0 cellspacing="0" width="600px"></TR>
        <TBODY>
     
<form name=form action="index.php" method="post" enctype="multipart/form-data">
  <tr>
    <td align="left">Название:<span class="name">*</span></td>
    <td align="left"><input class=bginp2 onblur=inputBG(this,0)  onfocus=inputBG(this,1)  name="title" type="text" size="70"/></td>
  </tr>
  
    <tr>
    <td align="left">Ключевые слова:</td>
    <td align="left"><input class=bginp2 onblur=inputBG(this,0)  onfocus=inputBG(this,1)  name="kslova" type="text" size="70"/></td>
  </tr>
  
    <tr>
    <td align="left">Дискрипшн:</td>
    <td align="left"><input class=bginp2 onblur=inputBG(this,0)  onfocus=inputBG(this,1)  name="descript" type="text" size="70"/></td>
  </tr>
  
      <tr>
    <td align="left">Короткий текст:<span class="name">*</span> </td>
    <td align="left"><textarea style="width:445px; height:70px;" class=bginp2 onblur=inputBG(this,0)  onfocus=inputBG(this,1)  name="cortext" ></textarea></td>
  </tr>
  
        <tr>
    <td align="left">Основной текст:<span class="name">*</span> </td>
    <td align="left"><textarea style="width:445px; height:250px;" class=bginp2 onblur=inputBG(this,0)  onfocus=inputBG(this,1)  name="text" ></textarea></td>
  </tr>
  
    <tr>
    <td align="left">Автор:<span class="name">*</span></td>
    <td align="left"><input class=bginp2 onblur=inputBG(this,0)  onfocus=inputBG(this,1)  name="avtor" type="text" size="70"/></td>
  </tr>

    <tr>
    <td align="left">Изображение, если нужно:</td>
    <td align="left"><input class=bginp2 onblur=inputBG(this,0)  onfocus=inputBG(this,1) type="file" name="file" size="50"/></td>
  </tr>





  <tr>
    <td colspan="2" align="center">
    <input type="hidden" name="act" value="addblog" />
    <input type="hidden" name="catid" value="<?php echo $catid; ?>" />
<input name="" type="submit" value="Добавить статью" /></center><br></td>
  </tr>
  
  
  
  
</form>
        
        
        </TBODY></TABLE></TD></TR></TBODY></TABLE>
<br>



<?php
//постраничная навигация 

$skybasenav = mysqli_query($db, "SELECT na_str FROM skyblog_nastr");
$skyrow5 = mysqli_fetch_array($skybasenav);
$num = $skyrow5["na_str"];
// Извлекаем из URL текущую страницу
@$page = $_GET['page'];
// Определяем общее число сообщений в базе данных
$skybase1 = mysqli_query($db, "SELECT COUNT(*) FROM skyblog_blog WHERE cat='$catid'");
$temp = mysqli_fetch_array($skybase1);
$posts = $temp[0];
// Находим общее число страниц
$total = (($posts - 1) / $num) + 1;
$total =  intval($total);
// Определяем начало сообщений для текущей страницы
$page = intval($page);
// Если значение $page меньше единицы или отрицательно
// переходим на первую страницу
// А если слишком большое, то переходим на последнюю
if(empty($page) or $page < 0) $page = 1;
  if($page > $total) $page = $total;
// Вычисляем начиная с какого номера
// следует выводить сообщения
$start = $page * $num - $num;
if ($start < 0) { $start = 0;}
// Выбираем $num сообщений начиная с номера $start

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






// вывод статей из выбранной категории   
       
$skybase3 = mysqli_query($db, "SELECT * FROM skyblog_blog  WHERE cat='$catid' ORDER BY id DESC LIMIT $start, $num");
if (!$skybase3)
{ echo "<p>База данных не доступна<br> <strong>Ошибка: </strong></p>";
exit(mysqli_error($db)); }
if (mysqli_num_rows($skybase3) > 0)
	{  
	$skyrow3 = mysqli_fetch_array($skybase3); 
	
	do {
if (!empty($skyrow3["pic"])) { $picbl = "<img style='margin-right:10px;' border=0 src='../picblog/".$skyrow3["pic"]."' align=left />"; }
else { $picbl = "";}		
		printf ("<div class='bolokno_verh'></div>
				<div class='bolokno_bg'>
				<a title='удалить статью вместе с комментариями' href='index.php?page=$page&catid=$catid&act=delblog&id=%s'><img align=right border=0 src='pic/del.png' /> </a> 
				  <div class='bolokno_title'><a title=редактировать href=redblog.php?id=%s>%s</a></div>
				  
					<div class='bolokno_int'>%s %s %s<br><br><span class=sm>%s | Добавил: <b>%s</b> | Просмотров: <b>%s</b></span></div> 
					
				</div>
			<div class='bolokno_niz'></div>", $skyrow3["id"], $skyrow3["id"], $skyrow3["idarxiv"], $skyrow3["title"], $picbl, $skyrow3["cortext"], $skyrow3["data"], $skyrow3["avtor"], $skyrow3["prosmotr"]);
		
		}
		while ($skyrow3 = mysqli_fetch_array($skybase3));
	
	}
else {

$skybase_cat = mysqli_query($db, "SELECT cattitle FROM skyblog_cat WHERE id='$catid'");
$skyrow_cat = mysqli_fetch_array($skybase_cat);
echo "<center><div>Категория <b>".$skyrow_cat["cattitle"]."</b> не содержит статей.</div></center>";
// exit();
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


<br><br>








<?php include("../niz.php"); ?>
</body>
</html>
