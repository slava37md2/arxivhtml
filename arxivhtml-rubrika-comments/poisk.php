<?php
if($_GET['file']!='')$idarxiv = $_GET['file']; // вызов из rubrika.php
else $idarxiv = $_POST['poisk']; // вызов из index.php


if(!preg_match("/(\d{4}\.\d{4,5})([v]\d)?$/",$idarxiv)){//4 цифры, точка, 5 цифр и версия 0 или 1 раз(?), и $ - конец строки
    exit('You can search only by id of article. For example: 2009.12338');
}

$Y_m = substr($idarxiv,0,4);//год и месяц, например 2009
$N1 = substr($idarxiv,5,1);//5 цифр разбиваются на 3 вложенные папки: $N1 - первая цифра 
$N23 = substr($idarxiv,6,2);//$N23 - вторая и третья цифры
$N45 = substr($idarxiv,8);//$N45 - четвёртая и пятая цифры и v3



if (file_exists('articles/'.$Y_m.'/'.$N1.'/'.$N23.'/'.$N45.'/index.html')) {
    echo "<meta http-equiv='refresh' content='0; url=articles/".$Y_m.'/'.$N1.'/'.$N23.'/'.$N45."/html.php'>";// редирект на html.php-файл
}else{ 
    if (file_exists('articles/'.$Y_m.'/'.$N1.'/'.$N23.'/'.$N45)){
        echo 'Converting failed';
    }
    else{
?>

<html>
<head>
<link rel="shortcut icon" href="skyico.ico">
<meta http-equiv="Content-Type" content="text/html; charset=UTF8" />
<meta name="keywords" content="arxiv, html, google, translate, converting" />
<meta name="description" content="Website arxiv.org in HTML. It is easy for Google Translator."  />
<link href="st.css" rel="stylesheet" type="text/css">
<title>arxivhtml - Converting of articles from arxiv.org in HTML-format.</title>
</head>
<body>

You need <a href="https://arxiv.org/e-print/<?php echo $idarxiv; ?>">to download file <?php echo $idarxiv; ?></a> on your computer and then to upload it to our server. It is necessary because the site arxiv.org disallows to download tex-files on our server directly.

<form action="readtargz.php" method="post" enctype="multipart/form-data">
  <div>
    <label for="texarchive"> Choose file <?php echo $idarxiv; ?> to upload from folder "Downloads" to our server.  </label>
    <input type="hidden" name="MAX_FILE_SIZE" value="40000000" />
    <input type="hidden" name="file" value="<?php echo $idarxiv; ?>" />
    <input type="file" id="texarchive" name="texarchive"
          accept=".<?php echo pathinfo( $idarxiv, PATHINFO_EXTENSION ); ?>">
  </div>
  <div>
    <button>Convert</button> It can take more than 1 minute. Please, press convert and wait.
  </div>
</form>

</body>
</html>
<?php 
    }
}
    

?>
