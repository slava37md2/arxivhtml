<?php

    $dates = file_get_contents("prosmotry.txt");
    $stroki = explode("\n", $dates);
    for( $i=0; $i<count($stroki); $i++ ){//перебираем все строки
        $elems = explode(" ", $stroki[$i]);//разбиваем строку на элементы по пробелу //0 - пустой, 1 элемент массива - id статьи, 2 - кол. просмотров, 3 - дата конвертации статьи, 4 - дата последнего просмотра

        $now = time(); // текущее время (метка времени)
        $your_date = strtotime($elems[4]); // какая-то дата в строке (1 января 2017 года)
        $datediff = $now - $your_date; // получим разность дат (в секундах)
        echo " ".floor($datediff / (60 * 60 * 24)); // вычислим количество дней из разности дат

        if( floor($datediff / (60 * 60 * 24)) > 30 ){//$interval->d Разница в днях между двух дат
            unset($stroki[$i]);
            $file = $elems[1];//'2009.12345';
            $Y_m = substr($file,0,4);//год и месяц, например 2009
            $N1 = substr($file,5,1);//5 цифр разбиваются на 3 вложенные папки: $N1 - первая цифра 
            $N23 = substr($file,6,2);//$N23 - вторая и третья цифры
            $N45 = substr($file,8);//$N45 - четвёртая и пятая цифры и v3
            $path = "articles/".$Y_m."/".$N1."/".$N23."/".$N45."/";// /var/www/html/arxivhtml-poisk/ 
            dirDel($path);// удаляем папку
        }
    }
    $dates = implode("\n", $stroki);

    file_put_contents("prosmotry.txt", $dates );





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
