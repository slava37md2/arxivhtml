<?php 
    $files = scandir('list'); //находим все файлы и папки в папке list
    for ( $i=2; $files[$i]; $i++) {
        if(pathinfo( $files[$i], PATHINFO_EXTENSION )=='html'){ 
            $htmlfilename = $files[$i];//находим файл c расширением html в папке list
            $html = file_get_contents( 'list/'.$htmlfilename, 2000 );
            $pos = strpos($html, 'href="http://arxiv.org/rss/');
            $html2 = substr($html, $pos);
            $pos2 = strpos($html2, '"/>');
            $rubr = substr($html2, 27, $pos2-27); // возвращает "astro-ph.EP"
            //echo $rubr;
            rename('list/'.$htmlfilename, 'list/'.$rubr.'.html');//переименовываем файл в astro-ph.EP.html
        }    echo $htmlfilename.'<br>';
    }


    
?>
