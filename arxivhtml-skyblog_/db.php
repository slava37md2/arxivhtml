<?php
//$db = mysql_connect ("127.0.0.1","юзербд","пароль");
//mysql_select_db("skyblogdb",$db);

$db = mysqli_connect("127.0.0.1", "slava37md2", "37v37v37d@$", "arxivhtmldb");

if (!$db) {
    echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
    echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

?>
