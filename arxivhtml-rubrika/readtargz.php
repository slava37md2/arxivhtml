<?php
    $file = $_POST["file"];//'2009.12345';
    $Y_m = substr($file,0,4);//год и месяц, например 2009
    $N1 = substr($file,5,1);//5 цифр разбиваются на 3 вложенные папки: $N1 - первая цифра 
    $N23 = substr($file,6,2);//$N23 - вторая и третья цифры
    $N45 = substr($file,8);//$N45 - четвёртая и пятая цифры и v3
    $uploaddir = 'articles/'.$Y_m.'/'.$N1.'/'.$N23.'/'.$N45.'/'; // /var/www/html/arxivhtml-poisk-ru-blog-on-files/
    mkdir("$uploaddir", 0755, true); // создаём папку $uploaddir


    $uploadfile = $uploaddir . basename($_FILES['texarchive']['name']).'.tar.gz'; echo $file, $_FILES['texarchive']['error'], $uploadfile;
    if (move_uploaded_file($_FILES['texarchive']['tmp_name'], $uploadfile)) {
        echo 'The file is correct and has been uploaded successfully.';//Файл корректен и был успешно загружен
    } else {
        exit('Possible file upload attack! The file may be too large');//Возможная атака с помощью файловой загрузки!
    }

    $tex_or_targz = urlencode(file_get_contents( $uploadfile, FALSE, NULL, 0, 200 ));// проверяем, это .tex или .tar.gz файл, Читаем 200 символов, начиная с 0 символа 
    //echo $tex_or_targz;
    if( strpos( $tex_or_targz, '%00%00') ){ // если tar.gz, который содержит \00\00
        $p = new PharData($uploaddir . $file.'.tar.gz');
        $p->decompress(); // creates /path/to/my.tar
        // распаковка из tar
        $phar = new PharData("$uploaddir$file.tar");//echo $phar;
        //if (!file_exists("$uploaddir . $file.dir"))
        $phar->extractTo("$uploaddir");
        
        if (!unlink("$uploaddir$file.tar"))  echo " $uploaddir$file.tar cannot be deleted due to an error";  
        else echo " $uploaddir$file.tar has been deleted";  
    }
    else rename($uploadfile, "$uploaddir/".pathinfo( $uploadfile, PATHINFO_BASENAME ).'.tex');// переносим tex-файл в папку $uploaddir



    $files = scandir("$uploaddir"); //находим все файлы и папки в папке $uploaddir
    for ( $i=0; $files[$i]; $i++) {
        if(pathinfo( $files[$i], PATHINFO_EXTENSION )=='tex'){ 
            $texfilename = $files[$i];//находим файл c расширением tex в папке $uploaddir
            $tex = file_get_contents( $uploaddir.$texfilename );
            if( strpos( $tex, '\begin{document}') ) break; // Находим главный tex-файл
        }
    }    echo $texfilename;

    chdir( "articles/$Y_m/$N1/$N23/$N45" );echo getcwd();
    exec("make4ht < ../../../../../data-file -u $texfilename",$out);//вместо клавиатуры ввод производится из файла data-file, а там 200 пустых строк
    //print_r($out);

    $filename = substr($texfilename, 0, strlen($texfilename)-4);// определяем имя файла без .tex
    
    if(file_exists("$filename.html")){ //если файл существует, то редиректим на него
        rename("$filename.html", 'index.html');// переименовываем в index.html
        if (!copy('../../../../../html.php', 'html.php')) //копируем html.php из корневой папки в папку статьи
            exit('не удалось скопировать html.php...');

        $dates = file_get_contents('../../../../../prosmotry.txt');
        $title = str_replace("\n", " ", $title);//0 - пустой, 1 элемент массива - id статьи, 2 - кол. просмотров, 3 - дата конвертации статьи, 4 - дата последнего просмотра
        $dates = ' '.$file.' 0 '.date("Y-m-d").' '.date("Y-m-d")."\n".$dates;
        file_put_contents('../../../../../prosmotry.txt', $dates );

        echo "<meta http-equiv='refresh' content='0; url=articles/$Y_m/$N1/$N23/$N45/html.php'>";// редирект на html.php-файл
    }
    else{ //if(file_exists("$filename.html")) если $filename.html не существует
        echo '<br>Converting failed.';
        $files2 = scandir('.'); //находим все файлы и папки в текущей папке
        for( $i=2; $files2[$i]; $i++){ // удаляем все файлы и папки
            if(is_dir($files2[$i]))dirDel($files2[$i]);
            else unlink($files2[$i]);//echo $files2[$i];
        }
    }

    for( $i=2; $files[$i]; $i++) // удаляем файлы tex и tar.gz
        if(pathinfo( $files[$i], PATHINFO_EXTENSION )!='png' and pathinfo( $files[$i], PATHINFO_EXTENSION )!='jpg' and pathinfo( $files[$i], PATHINFO_EXTENSION )!='jpeg' and !is_dir($files[$i]))
            unlink($files[$i]);






function dirDel ($dir) // удаляем папку
{  
    $d=opendir($dir);  
    while(($entry=readdir($d))!==false) 
    { 
        if ($entry != "." && $entry != "..") 
        { 
            if (is_dir($dir."/".$entry)) 
            {  
                dirDel($dir."/".$entry);  
            } 
            else 
            {  
                unlink ($dir."/".$entry);  
            } 
        } 
    } 
    closedir($d);  
    rmdir ($dir);  
 }
?>
