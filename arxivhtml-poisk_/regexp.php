<?php

$idarxiv = "2009.12340v5";
if(preg_match("/(\d{4}\.\d{5})([v]\d)?$/",$idarxiv))//4 цифры, точка, 5 цифр и версия 0 или 1 раз, и $ - конец строки
    echo "работает";

/*$counter = file_get_contents("prosmotry.txt");
$counter++;echo $counter;
file_put_contents("prosmotry.txt", $counter );*/

$now = time(); // текущее время (метка времени)
$your_date = strtotime("2020-11-01"); // какая-то дата в строке (1 января 2017 года)
$datediff = $now - $your_date; // получим разность дат (в секундах)

echo floor($datediff / (60 * 60 * 24)); // вычислим количество дней из разности дат
?>
