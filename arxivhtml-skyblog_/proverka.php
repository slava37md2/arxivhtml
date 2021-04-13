<?php
include "db.php";
$skybase2 = mysqli_query($db,"SELECT name,pass FROM skyblog_nastr");
if (!$skybase2)
{ echo "<p>База данных не доступна<br> <strong>Ошибка: </strong></p>";
exit(mysqli_error($db)); }
if (mysqli_num_rows($skybase2) > 0)
{  $skyrow2 = mysqli_fetch_array($skybase2); }
else {
echo "<p>Статей нет</p>";
}			


printf ("%s %s", $skyrow2["name"],$skyrow2["pass"]);

//while ($skyrow2 = mysqli_fetch_array($skybase2));
?>
