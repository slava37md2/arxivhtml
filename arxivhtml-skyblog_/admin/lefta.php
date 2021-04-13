<?php
#	....................... ..........................................................
#
#		Скрипт:	Sky Blog, версия: 1.0
#		Автор:	Sky (http://skystudio.ru http://skyscript.ru)
#
#	.................................................................................
require "pass.php";
?>

<meta http-equiv="Content-Type" content="text/html; charset=UTF8" />
<link href="st.css" rel="stylesheet" type="text/css">
 
    
    <div class="okno_verh"></div>
    	<div class="okno_bg">
		  <div class="okno_title">Категории</div> 
  			<div class="okno_int">
      
<?php
//изменение настроек
if (isset($act) && $act=="opt")
{

if (isset($_POST['name'])) { $name = $_POST['name']; }
if (isset($_POST['pass'])) { $pass = $_POST['pass']; }
if (isset($_POST['na_str'])) { $na_str = $_POST['na_str']; }

$skybaseopt = mysqli_query ($db, "UPDATE skyblog_nastr SET name='$name', pass='$pass', na_str='$na_str'");
}

if (!isset($catid) and !isset($id) and !isset($poisk)) { $catid=1; }

// выбор всех категорий            
$skybase = mysqli_query($db, "SELECT id,cattitle FROM skyblog_cat");
if (!$skybase)
{ echo "<p>База данных не доступна<br> <strong>Ошибка: </strong></p>";
exit(mysqli_error($db)); }
if (mysqli_num_rows($skybase) > 0)
{  $skyrowcat = mysqli_fetch_array($skybase); }
else {
echo "<p>В таблице нет записей.</p>";
exit(); }		
	
// вывод всех категорий  

do {

printf ("<table><tr><td align=left width=170><div class=cat><a class=cat href=index.php?catid=%s>%s</a></div></td>
	
	<td><a title='редактировать категорию %s' href='index.php?act=redcat&catid=%s'><img border=0 src='pic/red.png' width='20' height='20' /></a></td>
	<td><a title='удалить категорию %s' href='index.php?act=delcat&catid=%s'><img border=0 src='pic/del.png' width='20' height='20' /></a></td>
	</tr></table>
	
	",$skyrowcat["id"],$skyrowcat["cattitle"],$skyrowcat["cattitle"],$skyrowcat["id"],$skyrowcat["cattitle"],$skyrowcat["id"]);


}


while ($skyrowcat = mysqli_fetch_array($skybase));

	
?>
<center><form action="index.php?act=addcat" method="post" name="catform">
<input class=bginp2 onblur=inputBG(this,0)  onfocus=inputBG(this,1) name="cattitle" type="text" />
<input name="" type="submit" value="добавить" />
</form>            
</center>           

</div> 
    	</div>
    <div class="okno_niz"></div>
    
  

    <br>
    
    <div class="okno_verh"></div>
    	<div class="okno_bg">
		  <div class="okno_title">Последние темы</div> 
  			<div class="okno_int">
            
            
            
<?php
// выбор последних статей           
$skybase2 = mysqli_query($db, "SELECT id,title FROM skyblog_blog ORDER BY id DESC LIMIT 5");
if (!$skybase2)
{ echo "<p>База данных не доступна<br> <strong>Ошибка: </strong></p>";
exit(mysqli_error($db)); }
if (mysqli_num_rows($skybase2) > 0)
{  $skyrow2 = mysqli_fetch_array($skybase2); }
else {
echo "<p>статей нет</p>";
}			


do {

printf ("<div class=catsm><a class=catsm href=redblog.php?id=%s>%s</a></div>", $skyrow2["id"], $skyrow2["title"]);

}
while ($skyrow2 = mysqli_fetch_array($skybase2));

			
?>
            
            

</div> 
    	</div>
    <div class="okno_niz"></div>

    <br>
    
    
       <div class="okno_verh"></div>
    	<div class="okno_bg">
		  <div class="okno_title">Настройки</div> 
  			<div class="okno_int">
<?php   

// настройки
$skybaseopt = mysqli_query($db, "SELECT * FROM skyblog_nastr");
if (!$skybaseopt)
{
echo "<br><div class=alert>Запрос к базе неудачен.<br> <strong>Ошибка: </strong></div>";
exit(mysqli_error($db));
}

if (mysqli_num_rows($skybaseopt) > 0)

{
$skyrowopt = mysqli_fetch_array($skybaseopt); 
}

$name = $skyrowopt["name"];
$pass = $skyrowopt["pass"];
$na_str = $skyrowopt["na_str"];
?> 
<center>
<form action="index.php" method="post" name="options">
логин:<br>
<input class=bginp2 onblur=inputBG(this,0)  onfocus=inputBG(this,1) name="name" type="text" value="<?php echo "$name"; ?>" /><br><br>
пароль:<br>
<input value="<?php echo "$pass"; ?>" class=bginp2 onblur=inputBG(this,0)  onfocus=inputBG(this,1) name="pass" type="text" /><br><br>
статей на странице:<br>
<input value="<?php echo "$na_str"; ?>" class=bginp2 onblur=inputBG(this,0)  onfocus=inputBG(this,1) name="na_str" type="text" /><br><br>
<input name="act" type="hidden" value="opt" />
<input value="изменить" type="submit" /><br>


</form>
 </center>            
           
		</div> 
    	</div>
    <div class="okno_niz"></div>
    
     </form>
