<?php
#	....................... ..........................................................
#
#		Скрипт:	Sky Blog, версия: 1.0
#		Автор:	Sky (http://skystudio.ru http://skyscript.ru)
#
#	.................................................................................
?>

<meta http-equiv="Content-Type" content="text/html; charset=UTF8" />
<link href="st.css" rel="stylesheet" type="text/css">
 
    
    <div class="okno_verh"></div>
    	<div class="okno_bg">
		  <div class="okno_title">Категории</div> 
  			<div class="okno_int">
            
<?php
if (!isset($catid) and !isset($id) and !isset($poisk)) { $catid=1; }
// выбор всех категорий            
$skybase = mysqli_query($db,"SELECT id,cattitle FROM skyblog_cat");
if (!$skybase)
{ echo "<p>База данных не доступна<br> <strong>Ошибка: </strong></p>";
exit(mysqli_error($db)); }
if (mysqli_num_rows($skybase) > 0)
{  $skyrow = mysqli_fetch_array($skybase); }
else {
echo "<p>В таблице нет записей.</p>";
exit(); }		
	
// вывод всех категорий  
do {
if ($catid == $skyrow["id"]) { printf ("<div class=catsel>%s</div>", $skyrow["cattitle"]); }
else { printf ("<div class=cat><a class=cat href=index.php?catid=%s>%s</a></div>", $skyrow["id"], $skyrow["cattitle"]); }

}
while ($skyrow = mysqli_fetch_array($skybase));
?>
            

</div> 
    	</div>
    <div class="okno_niz"></div>
    
  

    <br>
    
    <div class="okno_verh"></div>
    	<div class="okno_bg">
		  <div class="okno_title">Последние темы</div> 
  			<div class="okno_int">
   
            
<?php
// выбор последних блогов           
$skybase2 = mysqli_query($db,"SELECT id,title,idarxiv FROM skyblog_blog ORDER BY id DESC LIMIT 5");
if (!$skybase2)
{ echo "<p>База данных не доступна<br> <strong>Ошибка: </strong></p>";
exit(mysqli_error($db)); }
if (mysqli_num_rows($skybase2) > 0)
{  $skyrow2 = mysqli_fetch_array($skybase2); }
else {
echo "<p>Статей нет</p>";
}			

do {

printf ("<div class=catsm><a class=catsm href=wievblog.php?id=%s>%s %s</a></div>", $skyrow2["id"],$skyrow2["idarxiv"], $skyrow2["title"]);

}
while ($skyrow2 = mysqli_fetch_array($skybase2));
?>

</div> 
    	</div>
    <div class="okno_niz"></div>

    <br>
 
  <form action="poisk.php" method="post">  
       <div class="okno_verh"></div>
    	<div class="okno_bg">
		  <div class="okno_title">Поиск</div> 
  			<div class="okno_int">
     Например: 2009.12345
     <input  class=bginp2 onblur=inputBG(this,0)  onfocus=inputBG(this,1) name="poisk" type="text" size="20">
      <button class=bginp2>Искать</button>
		</div> 
    	</div>
    <div class="okno_niz"></div>
     </form>
     

