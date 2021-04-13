<?php
include "../db.php";
if (isset($_POST['auth_name'])) {
  $name=mysqli_real_escape_string($db, $_POST['auth_name']);
  $pass=mysqli_real_escape_string($db, $_POST['auth_pass']);
  $query = "SELECT * FROM skyblog_nastr WHERE name='$name' AND pass='$pass'";
  $res = mysqli_query($db, $query) or trigger_error(mysqli_error($db).$query);
  if ($row = mysqli_fetch_assoc($res)) {
    session_start();
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
  }
  header("Location: http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
  echo "<center><div class=alert>Введенный логин/пароль неверны.</div></center>"; 
  exit;
}
if (isset($_COOKIE[session_name()])) session_start();
if (isset($_SESSION['user_id']) AND $_SESSION['ip'] == $_SERVER['REMOTE_ADDR']) return;
else {

?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF8" />
<title>SkyGallery Ver 1.0 — Администрирование</title>
<link href="../st.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../scripts/form.js"></script>
<?php 
include "../verh.php"; 
?>

<br><br><br><br>
<form method="POST">
<table width="350" align="center" border="0" cellspacing="5">
  <tr>
    <td rowspan="3" valign="top"><img src="pic/Login.png"></td>
    <td>Логин:</td>
    <td><input  class=bginp2 onblur=inputBG(this,0)  onfocus=inputBG(this,1) type="text" name="auth_name"></td>
  </tr>
  <tr>
    <td>Пароль:</td>
    <td><input  class=bginp2 onblur=inputBG(this,0)  onfocus=inputBG(this,1) type="password" name="auth_pass"></td>
  </tr>
  <tr>
    
    <td colspan="2" align="center"><input type="submit" value=" войти "></td>
  </tr>
</table>
</form>
<br><br><br><br>
<?php
include "../niz.php";
}
exit;
?> 
