<?php
include "db.php";
$idarxiv = mysqli_real_escape_string( $db, $_POST['poisk'] );

//поиск статьи
$skybase01 = mysqli_query($db, "SELECT * FROM skyblog_blog WHERE idarxiv='$idarxiv'");
if (!$skybase01)
{   echo "<p>База данных не доступна<br> <strong>Ошибка: </strong></p>";
    exit(mysqli_error($db)); 
}
if (mysqli_num_rows($skybase01) > 0)//Если в базе данных есть такая запись
{  
    $Y_m = substr($idarxiv,0,4);//год и месяц, например 2009
    $N1 = substr($idarxiv,5,1);//5 цифр разбиваются на 3 вложенные папки: $N1 - первая цифра 
    $N23 = substr($idarxiv,6,2);//$N23 - вторая и третья цифры
    $N45 = substr($idarxiv,8);//$N45 - четвёртая и пятая цифры и v3
    echo "<meta http-equiv='refresh' content='0; url=articles/".$Y_m."/".$N1."/".$N23."/".$N45."/index.html'>";// редирект на html-файл
}else{ ?>


Сначала Вам надо <a href="https://arxiv.org/e-print/<?php echo $idarxiv; ?>">скачать файл <?php echo $idarxiv; ?></a> на свой компьютер, а затем загрузить его на наш сервер. Это необходимо, потому что сайт  arxiv.org запрещает скачивать tex-файлы непосредственно на наш сервер со своего.
<!--You need <a href="https://arxiv.org/e-print/<?php echo $idarxiv; ?>">to download file <?php echo $idarxiv; ?></a> on your computer and then to upload it to our server. It is necessary because the site arxiv.org disallows to download tex-files on our server directly.-->

<form action="readtargz.php" method="post" enctype="multipart/form-data">
  <div>
    <label for="texarchive">Выберите файл <?php echo $idarxiv; ?> чтобы загрузить его из папки "Загрузки" на наш сервер. <!--Choose file <?php echo $idarxiv; ?> to upload from folder "Downloads" to our server.-->  </label>
    <input type="hidden" name="MAX_FILE_SIZE" value="40000000" />
    <input type="hidden" name="file" value="<?php echo $idarxiv; ?>" />
    <input type="file" id="texarchive" name="texarchive"
          accept=".<?php echo pathinfo( $idarxiv, PATHINFO_EXTENSION ); ?>">
  </div>
  <div>
    <button>Отправить</button>
  </div>
</form>
<?php 
}
    



?>
