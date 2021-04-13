<?php
    /*$file = '2004.07610';
    $ar = file_get_contents( '/var/www/html/arxivhtml/'.$file );*/

    $page = file_get_contents( 'Algebraic Topology authors_titles recent submissions.html' );// считываем html-файл //Programming Languages authors_titles recent submissions
    $page = str_replace('<a href="/', '<a href="https://arxiv.org/', $page); // вставляем https://arxiv.org/ в адреса ссылок

    while( $pos = strpos($page, 'title="Abstract">arXiv:')){
        $html .= substr($page, 0, $pos);
        $page = substr($page, $pos); // возвращает $page начиная с title="Abstract">arXiv:
        $pos2 = strpos($page, '</a>');
        $file = substr($page, 23, $pos2-23); // возвращает "2004.07761"
        $page = substr($page, $pos2); // возвращает $page начиная с </a>
        if(file_exists($file.".dir/index.html")) {//если файл существует, даём ссылку на него
            $html .= 'title="Abstract">arXiv:'.$file.".html was generated";
            $html = str_replace('<a href="https://arxiv.org/abs/'.$file, '<a href="'.$file.".dir/index.html", $html);
        }
        else{ 
            if(!file_exists($file.".dir")){ // если папка dir не существует значит ещё не пытались загрузить и конвертировать
                $html = str_replace('<a href="https://arxiv.org/abs/'.$file, '<a href="download.php?file='.$file, $html);
                $html .= 'title="Abstract">arXiv: to generate '.$file.".html";
            }else $html .= 'title="Abstract">arXiv:'.$file;// если папка dir существует значит уже пытались загрузить и конвертировать, но не вышло. Оставляем ссылку на arxiv
        }
        echo $file." ";
    }
    $html .= $page;


    echo $html;

    
?>
