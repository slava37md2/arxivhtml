<?php

    $file = "2003.05446";
    $files = scandir("$file.dir"); //находим все файлы и папки в папке $file.dir
    for ( $i=0; $files[$i]; $i++) {
        if(pathinfo( $files[$i], PATHINFO_EXTENSION )=="tex") $texfilename = $files[$i];//находим файл c расширением tex в папке $file.dir
    }
    
    //copy('data-file', "$file.dir/data-file");
    chdir( "$file.dir" );
    exec("make4ht < ../data-file $texfilename",$out);echo $texfilename;
    //print_r($out);

    $filename = substr($texfilename, 0, strlen($texfilename)-4);
    //$htmlfile = file_get_contents( $filename.'.html' );
    //$htmlfile = str_replace($filename, "$file.dir/$filename", $htmlfile); 
    //echo $htmlfile;

    rename("$filename.html", "index.html");

    echo "<meta http-equiv='refresh' content='0; url=$file.dir/index.html'>";

?>
