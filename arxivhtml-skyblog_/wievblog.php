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
include "db.php"; 
if (isset($_GET['id'])) {$id = mysqli_real_escape_string($db, $_GET['id']); }

if (isset($_POST['comavtor'])) {$comavtor = mysqli_real_escape_string($db, $_POST['comavtor']); }
if (isset($_POST['comemail'])) {$comemail = mysqli_real_escape_string($db, $_POST['comemail']); }
if (isset($_POST['comtext'])) {$comtext = mysqli_real_escape_string($db, $_POST['comtext']); }
if (isset($_POST['goform'])) {$goform = mysqli_real_escape_string($db, $_POST['goform']); }




//поиск статьи
$skybase01 = mysqli_query($db, "SELECT idarxiv FROM skyblog_blog WHERE id='$id'");
if (!$skybase01)
{   echo "<p>База данных не доступна<br> <strong>Ошибка: </strong></p>";
    exit(mysqli_error($db)); 
}
if (mysqli_num_rows($skybase01) > 0)//Если в базе данных есть такая запись
{  
    $skyrow01 = mysqli_fetch_array($skybase01); 
    $idarxiv = $skyrow01["idarxiv"];
    $Y_m = substr($idarxiv,0,4);//год и месяц, например 2009
    $N1 = substr($idarxiv,5,1);//5 цифр разбиваются на 3 вложенные папки: $N1 - первая цифра 
    $N23 = substr($idarxiv,6,2);//$N23 - вторая и третья цифры
    $N45 = substr($idarxiv,8);//$N45 - четвёртая и пятая цифры и v3
    echo "<meta http-equiv='refresh' content='0; url=articles/".$Y_m."/".$N1."/".$N23."/".$N45."/index.html'>";// редирект на html-файл
}



/*

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
$comdate = russian_date("j F, Y года, H:i");    

//извлечение данных о статье
$skybase01 = mysqli_query($db, "SELECT title,kslova,descript FROM skyblog_blog WHERE id='$id'");
if (!$skybase01)
{ echo "<p>База данных не доступна<br> <strong>Ошибка: </strong></p>";
exit(mysqli_error($db)); }
if (mysqli_num_rows($skybase01) > 0)
{  
$skyrow01 = mysqli_fetch_array($skybase01); 
$kslova = $skyrow01["kslova"];
$descript = $skyrow01["descript"];
$title = $skyrow01["title"];
}

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF8" />
<meta name="keywords" content="<?php echo $kslova; ?>" />
<meta name="description" content="<?php echo $descript; ?>"  />
<title><?php echo $title; ?></title>
<link rel="shortcut icon" href="pic/skyico.ico">
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

printf ("<div class='bolokno_verh'></div>
    	<div class='bolokno_bg'>
		  <div class='bolokno_title'>%s</div> 
  			<div class='bolokno_int'>%s<br><br><span class=sm>%s | Добавил: <b>%s</b> | Просмотров: <b>%s</b></span></div>
			
    	</div>
    <div class='bolokno_niz'></div>", $skyrow3["title"], str_replace("\n","<br>",$skyrow3["text"]), $skyrow3["data"], $skyrow3["avtor"], $skyrow3["prosmotr"]);

$pr = $skyrow3["prosmotr"];
$pr++;
$skybase_pr = mysqli_query($db,"UPDATE skyblog_blog SET prosmotr='$pr' WHERE id='$id'");
unset ($pr);

// проверка ввода комментария и добавление в базу
if (!empty($goform)){

	if (empty($comavtor)){
	echo("<center><div class=alert>Обязательно введите свое имя</div></center>");
	unset ($comavtor);
	}
	else {$na = 1;}
	
	if (empty($comtext)){
	echo("<center><div class=alert>Обязательно введите текст комментария</div></center>");
	unset ($comtext);
	}
	else {$me = 1;}
		
	if (!empty($comemail)){
		//if (eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)+$", $comemail))
        if(filter_var($comemail, FILTER_VALIDATE_EMAIL))
		{ 
		
		}
		else
		{
		print("<center><div class=alert>Правильно напишите свой e-mail адрес</div></center>");
		$na = 0;
		}
	}
	
	if(count($_POST)>0){
	if(isset($_SESSION['captcha_keystring']) && $_SESSION['captcha_keystring'] == $_POST['keystring']){
		$kap = 1;
	}else{
		echo "<center><div class=alert>Правильно введите цифры защитного кода</div></center>";
	}
	}
	unset($_SESSION['captcha_keystring']);
	
	if ($na==1 and $me==1 and $kap == 1){
	
$comavtor = trim($comavtor);
//$comavtor = stripslashes($comavtor);
$comavtor = htmlspecialchars($comavtor);

$comemail = trim($comemail);
$comemail = stripslashes($comemail);
$comemail = htmlspecialchars($comemail);

$comtext = trim($comtext);
//$comtext = stripslashes($comtext);
$comtext = htmlspecialchars($comtext);	
	
	$dobavka = mysqli_query ($db, "INSERT INTO skyblog_coment (comblog,comavtor,comemail,comdate,comtext,comotvet) VALUES ('$id', '$comavtor','$comemail','$comdate','$comtext','')");


	if ($dobavka == 'true') {
	echo "<center><div class=ok>Комментарий добавлен</div></center>"; }
	else { echo "<center><div class=alert>Комментарий не добавлен</div></center>"; }
	}
unset ($goform);	
}
?>

<TABLE cellSpacing=1 cellPadding=1 width=700 align=center border=0>
<TBODY>
  <TR>
    <TD align=middle align="right">
      <div class="dob" align="right"><a style="CURSOR: hand" id=SmilesText onclick=SmilesTable() class="dob">Добавить комментарий</a></div>
     
      </TD></TR>
  <TR id=SmilesTr style="DISPLAY: none">
    <TD align=middle>
    
    
      <TABLE border=0 width="700px"></TR>
        <TBODY>
       
<form name=guestbook action="wievblog.php?id=<?php echo "$id"; ?>" method="post" id="form">
  <tr>
    <td width='50' align="left">Имя:<span class="name">*</span> </td>
    <td width='180' align="left"><input class=bginp2 onblur=inputBG(this,0)  onfocus=inputBG(this,1)  name="comavtor" type="text" /></td>
    <td rowspan='2'>
    <label>Текст:<span class="name">*</span> </label>
    <textarea class=bginp2 onblur=inputBG(this,0)  onfocus=inputBG(this,1) style="WIDTH: 370px; HEIGHT: 50px" name="comtext" cols="" rows=""></textarea>
    </td>
  </tr>
  <tr>
    <td align="left">Почта: </td>
    <td align="left"><input   class=bginp2 onblur=inputBG(this,0)  onfocus=inputBG(this,1) name="comemail" type="text" /></td>
  </tr>

  <tr>
    <td align="left" valign="top"><br>

<input name="goform" type="hidden" value="1" />
<img src="k/?<?php echo session_name()?>=<?php echo session_id()?>"></td><td> --> 
<input name="keystring" type="text" class=bginp2  onfocus=inputBG(this,1) onblur=inputBG(this,0) size="5" maxlength="5">



</td>

<td>
<input name="" type="submit" value="Комментировать" /></center></td>
  </tr>

</form>
        
</TBODY></TABLE></TD></TR></TBODY></TABLE><br>

<?php

// комментарии 
$skybase5 = mysqli_query($db, "SELECT * FROM skyblog_coment WHERE comblog='$id' ORDER BY id DESC ");
if (!$skybase5)
{ echo "<p>База данных не доступна<br> <strong>Ошибка: </strong></p>";
exit(mysqli_error($db)); }
if (mysqli_num_rows($skybase5) > 0)
{  $skyrow5 = mysqli_fetch_array($skybase5);
do {
if (!empty($skyrow5["comotvet"])) { $otvet = "<br><br><span class=otvet>Ответ: </span>".$skyrow5["comotvet"];  } else { $otvet = ""; }
printf ("	<div class='bolokno_int'>  <div class='name'><strong>%s</strong></div> 
  			%s %s
			
			
			<br><br><span class=sm>%s</span></div> 
			
    	
    ", $skyrow5["comavtor"], $skyrow5["comtext"], $otvet, $skyrow5["comdate"]);

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

<?php include("niz.php");*/ ?>
</body>
</html>
