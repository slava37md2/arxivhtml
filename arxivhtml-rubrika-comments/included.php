<?php
    $t = strtolower($_SERVER['HTTP_USER_AGENT']); // Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko

    // If the string *starts* with the string, strpos returns 0 (i.e., FALSE). Do a ghetto hack and start with a space.
    // "[strpos()] may return Boolean FALSE, but may also return a non-Boolean value which evaluates to FALSE."
    //     http://php.net/manual/en/function.strpos.php
    $t = " " . $t; //echo $t;

     // Humans / Regular Users     
     if(!(strpos($t, 'opera'     ) || strpos($t, 'opr/') ||    //) return 'Opera'            ;
          strpos($t, 'edge'      ) ||                          //) return 'Edge'             ;
          strpos($t, 'chrome'    ) ||                          //) return 'Chrome'           ;
          strpos($t, 'safari'    ) ||                          //) return 'Safari'           ;
          strpos($t, 'firefox'   ) ||                          //) return 'Firefox'          ;
          strpos($t, 'msie'      ) || strpos($t, 'trident/7') ) )// return 'Internet Explorer';
        exit('You can see only in browser');//Если зашли не с браузера



    $url = $_SERVER['REQUEST_URI'];//получить текущий URL
    $pos1 = strpos($url, 'articles/');
    $pos5 = strrpos($url, '/');//Возвращает позицию последнего вхождения подстроки в строке
    $url = substr($url,$pos1+9,$pos5-$pos1-9);
    $url = substr_replace($url, '.', 4, 1);//заменяем первый / на точку
    $id = str_replace('/', '', $url);
    //echo $id;
    //statisticfile($id);


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
input {
margin-top:10px;
border:1px solid #f199bf;
color:#666666;
background-color:#fef3f7;
}

textarea {
margin-top:10px;
border:1px solid #f199bf;
color:#666666;
}
.avote {
color:#FF3333;
cursor: pointer;
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
    $comments = show_comments($url);
    if(strpos($html, '</body>' ))
        $html = str_replace('</body>', $comments.'</div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br></body>', $html);
    else $html = $html.$comments.'</div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br></body></html>';



    echo $html; 

function show_comments($url){
    $url = substr_replace($url, '/', 4, 1);//заменяем точку на первый /
    $commentsfromfile = file_get_contents('comments.txt');
    $stroki = explode("\n", $commentsfromfile);// 0 - ip; 1 - автор; 2 - плюсы; 3 - минусы; 4 - дата и время; 5 - текст комментария

    for( $i=0; $i<count($stroki)-1; $i++ ){//перебираем все строки
        $elems = explode('@$@', $stroki[$i]);//разбиваем строку на элементы по @$@
        $plus_minus = $elems[2]-$elems[3];
        $html .= $elems[1].' '. $elems[4].' <a class="avote" onclick="ajax_vote('.$i.',\'+\');" title="pluses: '.$elems[2].'">+</a> '
                             .$plus_minus.' <a class="avote" onclick="ajax_vote('.$i.',\'-\');" title="minuses: '.$elems[3].'">-</a> ' .'<br>'.$elems[5].'<br><br>';//
    }
    return '<center><div id="comms"><br><br>'.$html.'</div>
<form action="" method="post" id="form">
Author:* <input id="comavtor" type="text" maxlength="30" /><br>
Text:*
<textarea maxlength="500" style="WIDTH: 370px; HEIGHT: 50px" id="comtext" cols="" rows=""></textarea><br>Max number of characters - 500<br>
<input type="button" onclick="addComment()" value="Comment" />
</form></center>


<script>
function addComment() {
    if(document.getElementById("comavtor").value == "" || document.getElementById("comtext").value == "" ){
        alert("Please fill in all fields");return false;}
    if(/^[a-z0-9!@#\$%\^&\*\(\)\[\]:;\'",\.?/{}~`+-<>\=|_ ]+$/i.test(document.getElementById("comavtor").value) && /^[a-z0-9!@#\$%\^&\*\(\)\[\]:;\'",\.?/{}~`+-<>\=|_ \n]+$/i.test(document.getElementById("comtext").value)){
        ajax(); //Если на английском
    }
    else alert("Comment in English, please.");
}
function ajax(){
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      //document.getElementById("demo").innerHTML = this.responseText;
        if(this.responseText=="Try in an hour")alert("Try in an hour");
        else document.getElementById("comms").innerHTML += document.getElementById("comavtor").value + "<br>" + document.getElementById("comtext").value + "<br><br>";
      //  alert(this.responseText);
    }
  };
  xhttp.open("POST", "../../../../../ajax_quest.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("url=" + encodeURIComponent("'.$url.'") + "&a=" + encodeURIComponent(document.getElementById("comavtor").value)+"&f=" + encodeURIComponent(document.getElementById("comtext").value));
}

function ajax_vote(i,plus_or_minus){
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        alert(this.responseText);
    }
  };
  xhttp.open("POST", "../../../../../ajax_vote.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("url=" + encodeURIComponent("'.$url.'") + "&plus_or_minus=" + encodeURIComponent(plus_or_minus) + "&i=" + encodeURIComponent(i));
}
</script>';
}

/*function statisticfile($id){
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
}*/
?>
