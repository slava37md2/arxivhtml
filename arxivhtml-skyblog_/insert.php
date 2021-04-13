<?php
    include "db.php"; //$file = '2009.12339';
    $Y_m = substr($file,0,4);    $N1 = substr($file,5,1);    $N23 = substr($file,6,2);    $N45 = substr($file,8); chdir( "articles/$Y_m/$N1/$N23/$N45" );echo $file." in insert.php";

    $catid=1;$kslova='';$descript='';$cortext='';$text='';$avtor='';$data='';$filename='';
    $page = file_get_contents( 'index.html', FALSE, NULL, 0, 20000 );//$filename

    $pos = strpos($tex, '/title{');
    if($pos>0){
        $pagetex = substr($tex, $pos); // возвращает $page начиная с /title{
        $pos2 = strpos($pagetex, '}');
        $title = substr($pagetex, 7, $pos2-7); // возвращает "Locality and general vacua in quantum field theory"
        $title = mysqli_real_escape_string($db, $title);
        echo $title.'<br>';
    }
    if($title==''){
        $pos = strpos($page, '<title>');
        $page = substr($page, $pos); // возвращает $page начиная с <title">
        $pos2 = strpos($page, '</title>');
        $title = substr($page, 7, $pos2-7); // возвращает "Locality and general vacua in quantum field theory"
        $title = mysqli_real_escape_string($db, $title);
        echo $title.'<br>';
    }

    $pos = strpos($tex, '\author{');
    if($pos>0){
        $pagetex = substr($tex, $pos); // возвращает $page начиная с /author{
        $pos2 = strpos($pagetex, '}');
        $avtor = substr($pagetex, 8, $pos2-8); // возвращает "Locality and general vacua in quantum field theory"
        $avtor = substr($avtor, 0, 99);
        $avtor = mysqli_real_escape_string($db, $avtor);
        echo $avtor.'<br>';
    }
    if($avtor==''){
        $pos = strpos($page, '<div class="author');
        $page = substr($page, $pos); // возвращает $page начиная с  <div class="author" >
        $pos2 = strpos($page, '</div>');
        $avtor = substr($page, 18, $pos2-18); // возвращает "Daniele Colosi и т.д."
        $avtor = strip_tags($avtor);
        $avtor = substr($avtor, 0, 99);
        $avtor = mysqli_real_escape_string($db, $avtor);echo $avtor.'<br>';
    }

    $pos = strpos($tex, '\begin{abstract}');
    if($pos>0){
        $pagetex = substr($tex, $pos); // возвращает $page начиная с \begin{abstract}
        $pos2 = strpos($pagetex, '\end{abstract}');
        $cortext = substr($pagetex, 16, $pos2-16); // возвращает "Locality and general vacua in quantum field theory и т.д."
        //$cortext = substr($cortext, 0, 599);
        $cortext = mysqli_real_escape_string($db, $cortext);
        echo $cortext.'<br>';echo '---'.$pos.'---';
    }
    if($cortext==''){
        $pos = strpos($page, 'class="abstract"');
        $page = substr($page, $pos); // возвращает $page начиная с  <div class="abstract" >
        $pos2 = strpos($page, '</div>');
        $page = substr($page, $pos2+6); // возвращает $page после </div>
        $pos3 = strpos($page, '</div>');
        $cortext = substr($page, 0, $pos3); // возвращает "We extend the framework of general boundary quantum field theory (GBQFT) to achieve и т.д."
        $cortext = strip_tags($cortext);
        $cortext = mysqli_real_escape_string($db, $cortext);echo $cortext;
    }

    $skybaseaddblog = mysqli_query ($db, "INSERT INTO skyblog_blog (cat,idarxiv,title,kslova,descript,cortext,text,avtor,data,pic) VALUES ('$catid','$file','$title','$kslova','$descript','$cortext','$text','$avtor','$data','$filename')");
									
	if (!$skybaseaddblog){
		echo "<br><div class=alert>Статья не добавлена.<br> <strong>Ошибка: </strong></div>";
		exit(mysqli_error($db));
	}

?>
