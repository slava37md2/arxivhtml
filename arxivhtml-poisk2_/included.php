<?php
    $url = $_SERVER['REQUEST_URI'];//получить текущий URL
    $pos1 = strpos($url, 'articles/');
    $pos5 = strrpos($url, '/');//Возвращает позицию последнего вхождения подстроки в строке
    $url = substr($url,$pos1+9,$pos5-$pos1-9);
    $url = substr_replace($url, '.', 4, 1);//заменяем первый / на точку
    $id = str_replace('/', '', $url);
    //echo $id;
    statisticfile($id);


    $index_html = file_get_contents('index.html');
    $pos = strpos($index_html, '<body');
    $html = substr($index_html,0,$pos).'<body>
<style>
   .pdf-frame iframe {
    position: fixed; /* Фиксированное положение */
    top: 50%; /* Расстояние сверху */
    border: 1px solid #333; /* Параметры рамки */ 
    width:99%;
    height:50%;
    z-index: 9999;
   }
  </style>
  <div class="pdf-frame">
    <iframe src="https://arxiv.org/pdf/'.$id.'" >
    Your browser does not support iframes!
    </iframe>
  </div>
  
<div id="bodyofthedocument">';
    $pos2 = strpos($index_html, '>', $pos );
    $html .= substr($index_html,$pos2+1);
    if(strpos($html, '</body>' ))
        $html = str_replace('</body>', '</div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br></body>', $html);
    else $html = $html.'</div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br></body></html>';
    echo $html;


function statisticfile($id){
    $dates = file_get_contents('../../../../../prosmotry.txt');
    $stroki = explode("\n", $dates);
    $esti_takaia_stranitsa = false;
    for( $i=0; $i<count($stroki); $i++ )//перебираем все строки
        if( strpos($stroki[$i], $id) ){// если в строке есть 2010.12339
            $esti_takaia_stranitsa = true; //
            $elems = explode(' ', $stroki[$i]);//разбиваем строку на элементы по @$@
            $elems[4] = date("Y-m-d");//0 - пустой, 1 элемент массива - id статьи, 2 - кол. просмотров, 3 - дата конвертации статьи, 4 - дата последнего просмотра 5 - дата перевода 6 - title
            $elems[2]++;
            $stroki[$i] = implode(' ', $elems);
            break;
        }
    $dates = implode("\n", $stroki);
    if( $esti_takaia_stranitsa == false ){
        $dates = ' '.$id.' 1 '.date("Y-m-d").' '.date("Y-m-d")."\n".$dates;
    }
    file_put_contents('../../../../../prosmotry.txt', $dates );
}
?>
