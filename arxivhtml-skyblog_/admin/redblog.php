<?php
session_start();
?>
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
if (isset($_POST['id'])) {$id = $_POST['id']; }
if (isset($_GET['idcom'])) {$idcom = $_GET['idcom']; }
if (isset($_GET['act'])) {$act = $_GET['act']; }


if (isset($_POST['text'])) {$text = $_POST['text']; }
if (isset($_POST['cortext'])) {$cortext = $_POST['cortext']; }
if (isset($_POST['title'])) {$title = $_POST['title']; }
if (isset($_POST['kslova'])) {$kslova = $_POST['kslova']; }
if (isset($_POST['descript'])) {$descript = $_POST['descript']; }

if (isset($_POST['comotvet'])) {$comotvet = $_POST['comotvet']; }
if (isset($_POST['act'])) {$act = $_POST['act']; }
if (isset($_POST['idcom'])) {$idcom = $_POST['idcom']; }
if (isset($_POST['filepic'])) {$filepic = $_POST['filepic']; }

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF8" />
<title>SkyScript — Простые бесплатные PHP-скрипты</title>
<link rel="shortcut icon" href="../pic/skyico.ico">
<link href="../st.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../scripts/form.js"></script>
</head>
<body>
<?php include("../verh.php"); ?>

<table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="220" valign="top">
    
  <?php include("lefta.php"); ?> 
       
    </td>
    <td width="20">&nbsp;</td>
    <td valign="top">

<?php
//удаление картинки
if (isset($act) && $act=="delpic")
{
$skybasedelpic = mysqli_query($db, "SELECT pic FROM skyblog_blog WHERE id='$id'");
$skyrowdelpic = mysqli_fetch_array($skybasedelpic);

			$delpic=$skyrowdelpic["pic"];
			$skybasedelpic2 = mysqli_query($db, "SELECT pic FROM skyblog_blog WHERE pic='$delpic'");
				if (mysqli_num_rows($skybasedelpic2) <= 1)
				{
				if (is_file("../picblog/$delpic")) unlink ("../picblog/$delpic"); 
				}
$skybaseredblog = mysqli_query ($db, "UPDATE skyblog_blog SET pic='' WHERE id='$id'");
}

//редактирование статьи
if (isset($act) && $act=="redblog")
{       

	if (!empty($title) && !empty($cortext) && !empty($text)) 
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
				
				if (!in_array($rash, $dopus)) 
				{ 
					echo "<center><br><div class=alert>Разрешены изображения с расширениями: gif, jpg, jpeg, png</div><br></center>"; $osh=1; }
				
					$filedir2 = "../$filedir";	
				
					$tochka = substr_count($filename, "."); 
					if ($tochka > 1) 
					{ echo "<center><br><div class=alert>Запрещенный файл! Более одной точки</div><br></center>\r\n"; $osh=1; }
					
					if (!preg_match("/^[a-z0-9\.\-_]+\.(jpg|gif|png|)+$/is",$filename)) 
					{ echo "<center><br><div class=alert>Название изображения содержит запрещенные символы</div><br></center>"; $osh=1;}
	
					$filekb = round($filesize/10.24)/100;
					$filexy=getimagesize($_FILES['file']['tmp_name']);
					$gor = $filexy[0];
					$ver = $filexy[1];
					
					if ($filesize > "0" && $osh != 1) {
					copy ($_FILES['file']['tmp_name'], $filedir2."/".$filename);
					
						if (file_sm2("$filedir2/$filename", "$filedir2/$filename", 100, 100))
						{ echo ''; }
						else  
						{ echo '<br><div class=alert>Ошибка маштабирования</div>'; }
			
					}
					else { echo "<center><div class=alert>Изображение не загружено!</div></center>"; 
				
					}

		}


			// вызов названия картинки
			$skybase7 = mysqli_query($db, "SELECT * FROM skyblog_blog WHERE id='$id'");
			if (!$skybase7)
			{ echo "<p>База данных не доступна<br> <strong>Ошибка: </strong></p>";
			exit(mysqli_error($db)); }
			if (mysqli_num_rows($skybase7) > 0)
			{  
			
			$skyrow7 = mysqli_fetch_array($skybase7); 
			
			$pic=$skyrow7["pic"];
						
			if (empty($filename)) { $filename=$filepic; }
			}

						if ($osh!=1) 
						{
						
							$skybaseredblog = mysqli_query ($db, "UPDATE skyblog_blog SET title='$title',kslova='$kslova',descript='$descript',cortext='$cortext',text='$text',pic='$filename' WHERE id='$id'");
							
						
							if (!$skybaseredblog)
							{
							echo "<br><div class=alert>Статья не изменена.<br> <strong>Ошибка: </strong></div>";
							exit(mysqli_error($db));
							}
						}
	
	}
	else { echo "<center><br><div class=alert>Заполнены должны быть все поля</div></center>"; }
	
}


//удаление комментариев
if (isset($act) && $act=="delcom" && !empty($idcom))
{

$skybasedelblog = mysqli_query ($db, "DELETE FROM skyblog_coment WHERE id='$idcom'"); 

}

//добавление ответа в комментарий
if (isset($act) && $act=="redcom")
{
$skyredcom = mysqli_query ($db, "UPDATE skyblog_coment SET comotvet='$comotvet' WHERE id='$idcom'");

}

// статья крупно 
$skybase3 = mysqli_query($db, "SELECT * FROM skyblog_blog WHERE id='$id'");
if (!$skybase3)
{ echo "<p>База данных не доступна<br> <strong>Ошибка: </strong></p>";
exit(mysqli_error($db)); }
if (mysqli_num_rows($skybase3) > 0)
{  $skyrow3 = mysqli_fetch_array($skybase3); }
else {
echo "<p>В таблице нет записей.</p>";
exit(); }			
//  
if (empty($skyrow3["pic"])) { $pict = ""; } else { $pict = "<img align=left border=0 src='../picblog/".$skyrow3["pic"]."' />"; }
printf ("<form action='redblog.php' method='post' name='redblog' enctype='multipart/form-data'><div class='bolokno_verh'></div>
    	<div class='bolokno_bg'>
		  <div class='bolokno_title'><a title='удалить статью вместе с комментариями' href='index.php?catid=%s&act=delblog&id=%s'><img align=right border=0 src='pic/del.png' /> </a>название: <input class=bginp2 onblur=inputBG(this,0)  onfocus=inputBG(this,1) name='title' type='text' value='%s' size=70 /></div> 
  			<div class='bolokno_int'> %s</a>заменить/добавить изображение<br><input class=bginp2 onblur=inputBG(this,0)  onfocus=inputBG(this,1) type='file' name='file' size='50' /><br>
			
			
			<a title='удалить картинку' href='redblog.php?act=delpic&id=%s'><img border=0 src='pic/del.png' width=30 height=30/> </a>
			если заменяете картинку, удалите сначала старую
			
			<input type='hidden' name='filepic' value='%s' />
			
			
			
			<br><br><br><br>ключ слова: <input value='%s' class=bginp2 onblur=inputBG(this,0)  onfocus=inputBG(this,1)  name='kslova' type='text' size='70'/>
			<br>дискрипшн: <input value='%s' class=bginp2 onblur=inputBG(this,0)  onfocus=inputBG(this,1)  name='descript' type='text' size='70'/>
			<br><br>короткий текст: <br><textarea style='width:445px; height:70px;' class=bginp2 onblur=inputBG(this,0)  onfocus=inputBG(this,1)  name='cortext' >%s</textarea><br><br>
			
			
			
			основной текст: <br>
			<textarea style='width:445px; height:250px;' class=bginp2 onblur=inputBG(this,0)  onfocus=inputBG(this,1)  name='text' >%s</textarea>			
			<br>
			    <input type='hidden' name='act' value='redblog' />
    <input type='hidden' name='id' value='%s' />
<input type='submit' value='Внести изменения' />
			
			
			<br><br><span class=sm>%s  | Добавил: <b>%s</b> | Просмотров: <b>%s</b></span></div>
			
    	</div>
    <div class='bolokno_niz'></div></form>", $skyrow3["cat"], $id, $skyrow3["title"], $pict, $id, $skyrow3["pic"], $skyrow3["kslova"], $skyrow3["descript"], $skyrow3["cortext"], $skyrow3["text"], $id, $skyrow3["data"], $skyrow3["avtor"], $skyrow3["prosmotr"]);

$pr = $skyrow3["prosmotr"];
$pr++;
$skybase_pr = mysqli_query($db, "UPDATE skyblog_blog SET prosmotr='$pr' WHERE id='$id'");
unset ($pr);
?> 
<br>
<?php

// комментарии 
$skybase5 = mysqli_query($db, "SELECT * FROM skyblog_coment WHERE comblog='$id' ORDER BY id DESC ");
if (!$skybase5)
{ echo "<p>База данных не доступна<br> <strong>Ошибка: </strong></p>";
exit(mysqli_error($db)); }
if (mysqli_num_rows($skybase5) > 0)
{ 
 $skyrow5 = mysqli_fetch_array($skybase5); 
do {
$idcom = $skyrow5["id"];
printf ("<form action='redblog.php' method='post' name='redcom'>
<div class='bolokno_int'>  <div class='name'>%s</div> 
  			<a title='удалить комментарий' href='redblog.php?idcom=%s&act=delcom&id=%s'><img align=right border=0 src='pic/del.png' /> </a>%s<br> 
<textarea style='width:445px; height:50px;' class=bginp2 onblur=inputBG(this,0)  onfocus=inputBG(this,1)  name='comotvet' >%s</textarea>	
<input type='hidden' name='act' value='redcom' />
<input type='hidden' name='id' value='%s' />
<input type='hidden' name='idcom' value='%s' />
<input type='submit' value='ответить' />	<br>		
<br><span class=sm>%s</span></div></form>
			
    	
    ", $skyrow5["comavtor"], $idcom, $id, $skyrow5["comtext"], $skyrow5["comotvet"], $id, $idcom, $skyrow5["comdate"]);

}
while ($skyrow5 = mysqli_fetch_array($skybase5));


}
else {
echo "<p>Комментариев пока нет</p>";
}			

?>     
    
    
    </td>
  </tr>
</table>


<br><br><br><br><br>


<?php include("../niz.php"); ?>
</body>
</html>
