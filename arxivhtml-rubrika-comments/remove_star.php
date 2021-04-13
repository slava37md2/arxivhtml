<?php

$dirsY_m = scandir('articles'); //находим все файлы и папки в папке $articles
for ( $i=2; $dirsY_m[$i]; $i++) {
    $dirsN1 = scandir('articles/'.$dirsY_m[$i]);  //находим все файлы и папки в папке $dirsY_m[$i]
    for ( $j=2; $dirsN1[$j]; $j++) {
        $dirsN23 = scandir('articles/'.$dirsY_m[$i].'/'.$dirsN1[$j]); //находим все файлы и папки в папке $dirsN1[$i]
        for ( $k=2; $dirsN23[$k]; $k++) {
            $dirsN45 = scandir('articles/'.$dirsY_m[$i].'/'.$dirsN1[$j].'/'.$dirsN23[$k]); echo '.'.$dirsN23[$k];//находим все файлы и папки в папке $dirsN23[$i]
            for ( $l=2; $dirsN45[$l]; $l++) {
                $dirsfiles = scandir($dirsN45[$l]); //находим все файлы и папки в папке $dirsN23[$i]
                $path = 'articles/'.$dirsY_m[$i].'/'.$dirsN1[$j].'/'.$dirsN23[$k].'/'.$dirsN45[$l].'/';
                if(file_exists($path.'index.html')){ 
                     
                    $now = time(); // текущее время (метка времени)
                    $your_date = fileatime($path.'index.html');//strtotime($elems[4]); // какая-то дата в строке (1 января 2017 года)
                    $datediff = $now - $your_date; // получим разность дат (в секундах)
                    echo '<br>'.floor($datediff / (60 * 60 * 24)).' '.$path; // вычислим количество дней из разности дат

                    if( floor($datediff / (60 * 60 * 24)) > 30 ) // Разница в днях между двух дат
                        dirDel($path);
                }
            }
        }
    }
}    







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
