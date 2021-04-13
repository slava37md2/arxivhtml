<?php

    $dates = file_get_contents('articles/'.$_POST[url].'/comments.txt');
    $stroki = explode("\n", $dates);
    $ip = $_SERVER['REMOTE_ADDR'];

    for( $i=0; $i<count($stroki); $i++ ){//перебираем все строки
        $elems = explode('@$@', $stroki[$i]);//разбиваем строку на элементы по @$@
        if( $elems[0] == $ip and floor( time()-strtotime( $elems[4] ) ) / ( 60 ) < 60 ){ // если в строке есть 201.123.12.45  и меньше 60 минут прошло то
            exit('Try in an hour');
        }
    }

    $POSTf = str_replace("\n", '<br>', $_POST[f]);
    $dates = $dates.$ip.'@$@'.$_POST[a].'@$@0@$@0@$@'.date("Y-m-d H:i:s").'@$@'.$POSTf."\n"; // 0 - ip; 1 - автор; 2 - плюсы; 3 - минусы; 4 - дата и время; 5 - текст комментария

    file_put_contents('articles/'.$_POST[url].'/comments.txt', $dates );


?>
