<?php
    $url = $_SERVER['REQUEST_URI'];//получить текущий URL
    $pos1 = strpos($url, 'articles/');
    $pos5 = strrpos($url, '/');//Возвращает позицию последнего вхождения подстроки в строке
    $url = substr($url,$pos1+9,$pos5-$pos1-9);
    $url = substr_replace($url, '.', 4, 1);//заменяем первый / на точку
    $id = str_replace("/", "", $url);
    //echo $id;
    statisticfile($id);

    $html = file_get_contents("index.html");
    echo $html;

function statisticfile($id){
    $dates = file_get_contents("../../../../../prosmotry.txt");
    $stroki = explode("\n", $dates);
    $esti_takaia_stranitsa = false;
    for( $i=0; $i<count($stroki); $i++ )//перебираем все строки
        if( strpos($stroki[$i], $id) ){// если в строке есть 2010.12339
            $esti_takaia_stranitsa = true; //
            $elems = explode(" ", $stroki[$i]);//разбиваем строку на элементы по пробелу
            $elems[4] = date("Y-m-d");//0 - пустой, 1 элемент массива - id статьи, 2 - кол. просмотров, 3 - дата конвертации статьи, 4 - дата последнего просмотра
            $elems[2]++;
            $stroki[$i] = implode(" ", $elems);
        }
    $dates = implode("\n", $stroki);
    if( $esti_takaia_stranitsa == false ){
        $dates = ' '.$id.' 1 '.date("Y-m-d").' '.date("Y-m-d")."\n".$dates;
    }
    file_put_contents("../../../../../prosmotry.txt", $dates );
}
?>
