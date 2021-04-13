<?php
    $file = $_POST["file"];//'2009.12345';
    $Y_m = substr($file,0,4);//год и месяц, например 2009
    $N1 = substr($file,5,1);//5 цифр разбиваются на 3 вложенные папки: $N1 - первая цифра 
    $N23 = substr($file,6,2);//$N23 - вторая и третья цифры
    $N45 = substr($file,8);//$N45 - четвёртая и пятая цифры и v3
    $uploaddir = "/var/www/html/arxivhtml-poisk/articles/".$Y_m."/".$N1."/".$N23."/".$N45."/";
    mkdir("$uploaddir", 0755, true); // создаём папку $uploaddir
    //$uploadfile = $uploaddir . $file.'.tar.gz'; echo " ", $file," ", $uploadfile;

    $uploadfile = $uploaddir . basename($_FILES['texarchive']['name']).'.tar.gz'; echo $file, $_FILES['texarchive']['error'], $uploadfile;
    if (move_uploaded_file($_FILES['texarchive']['tmp_name'], $uploadfile)) {
        echo "The file is correct and has been uploaded successfully.\n";//Файл корректен и был успешно загружен
    } else {
        echo "Possible file upload attack!\n"; exit();//Возможная атака с помощью файловой загрузки!
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
    else{
        //mkdir("$file.dir", 0755); // создаём папку $file.dir
        rename($uploadfile, "$uploaddir/".pathinfo( $uploadfile, PATHINFO_BASENAME ).".tex");// переносим tex-файл в папку $uploaddir
    }


    $files = scandir("$uploaddir"); //находим все файлы и папки в папке $uploaddir
    for ( $i=0; $files[$i]; $i++) {
        if(pathinfo( $files[$i], PATHINFO_EXTENSION )=="tex"){ 
            $texfilename = $files[$i];//находим файл c расширением tex в папке $uploaddir
            $tex = file_get_contents( $uploaddir.$texfilename );
            if( strpos( $tex, '\begin{document}') ) break; // Находим главный tex-файл
        }
    }    echo $texfilename;

    chdir( "articles/$Y_m/$N1/$N23/$N45" );echo getcwd();
    exec("make4ht < ../../../../../data-file $texfilename",$out);//вместо клавиатуры ввод производится из файла data-file, а там 200 пустых строк
    //print_r($out);

    $filename = substr($texfilename, 0, strlen($texfilename)-4);// определяем имя файла без .tex
    
    if(file_exists("$filename.html")){ //если файл существует, то редиректим на него
        rename("$filename.html", "index.html");// переименовываем в index.html
        if (!copy("../../../../../html.php", "html.php")) {//копируем html.php из корневой папки в папку статьи
            exit("не удалось скопировать html.php...\n");
        }
        echo "<meta http-equiv='refresh' content='0; url=articles/$Y_m/$N1/$N23/$N45/html.php'>";// редирект на html.php-файл
    }
    else echo "<br>Converting failed.";
?>
