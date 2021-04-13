<?php //https://arxiv.org/list/astro-ph.GA/pastweek?skip=0&show=50
    $rubrika = $_GET['r'];

    $page = file_get_contents( 'list/'.$rubrika.'.html' );// считываем html-файл //Programming Languages authors_titles recent submissions
    $page = str_replace('<a href="/', '<a href="https://arxiv.org/', $page); // вставляем https://arxiv.org/ в адреса ссылок

    while( $pos = strpos($page, 'title="Abstract">arXiv:')){
        $html .= substr($page, 0, $pos);
        $page = substr($page, $pos); // возвращает $page начиная с title="Abstract">arXiv:
        $pos2 = strpos($page, '</a>');
        $file = substr($page, 23, $pos2-23); // возвращает "2004.07761"
        $page = substr($page, $pos2); // возвращает $page начиная с </a>

        $html = str_replace('<a href="https://arxiv.org/abs/'.$file, '<a href="poisk.php?file='.$file, $html);//даём ссылку на poisk.php
        $html .= 'title="Abstract">arXiv: to show '.$file.'.html';
    }
    $html .= $page;


    echo $html;

    
?>
