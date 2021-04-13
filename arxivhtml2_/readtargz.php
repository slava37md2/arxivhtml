<?php
    
    $file = $_POST['file'];
    //$file = '2004.05106';

    $uploaddir = '/var/www/html/arxivhtml/';
    $uploadfile = $uploaddir . basename($_FILES['texarchive']['name']).'.tar.gz'; echo $file, $_FILES['texarchive']['error'], $uploadfile;
    if (move_uploaded_file($_FILES['texarchive']['tmp_name'], $uploadfile)) {
        echo "Файл корректен и был успешно загружен.\n";
    } else {
        echo "Возможная атака с помощью файловой загрузки!\n";
    }



    $tex_or_targz = file_get_contents( $uploadfile );// проверяем, это .tex или .tar.gz файл
    if( strpos( $tex_or_targz, '\00\00') ){ // если tar.gz, который содержит \00\00
        $p = new PharData($file.'.tar.gz');
        $p->decompress(); // creates /path/to/my.tar
        // распаковка из tar
        $phar = new PharData("$file.tar");//echo $phar;
        if (!file_exists("$file.dir"))$phar->extractTo("$file.dir");
        
        if (!unlink("$file.tar"))  echo " $file.tar cannot be deleted due to an error";  
        else echo " $file.tar has been deleted";  
    }
    else{
        mkdir("$file.dir", 0755); // создаём папку $file.dir
        rename($uploadfile, "$file.dir/".pathinfo( $uploadfile, PATHINFO_BASENAME ).".tex");// переносим tex-файл в папку $file.dir
    }


    $files = scandir("$file.dir"); //находим все файлы и папки в папке $file.dir
    for ( $i=0; $files[$i]; $i++) {
        if(pathinfo( $files[$i], PATHINFO_EXTENSION )=="tex"){ $texfilename = $files[$i];//находим файл c расширением tex в папке $file.dir
            $tex = file_get_contents( "/var/www/html/arxivhtml/$file.dir/".$texfilename );
            if( strpos( $tex, '\begin{document}') ) break;
        }
    }

    chdir( "$file.dir" );
    exec("make4ht < ../data-file $texfilename",$out);//вместо клавиатуры ввод производится из файла data-file, а там 200 пустых строк
    //print_r($out);

    $filename = substr($texfilename, 0, strlen($texfilename)-4);// определяем имя файла без .tex
    /*$htmlfile = file_get_contents( $filename.'.html' );// добавляем к нему .html  и считываем html-файл
    $htmlfile = str_replace($filename, "$file.dir/$filename", $htmlfile); // чтобы картинки показывались добавляем $file.dir/ в адреса картинок
    echo $htmlfile;*/
    
    if(file_exists("$filename.html")){ //если файл существует, то редиректим на него
        rename("$filename.html", "index.html");// переименовываем в index.html
        echo "<meta http-equiv='refresh' content='0; url=$file.dir/index.html'>";// редирект на html-файл
    }
    else echo "Converting failed.";
?>
