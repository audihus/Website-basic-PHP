<?php 

session_start();
session_unset(); //agar lebih yakin
$_SESSION = []; //agar lebih yakin
session_destroy();

if(isset($_COOKIE['id']) or isset($_COOKIE['key'])){
    setcookie('id','', time()-3600);
    setcookie('key','', time()-3600);
}


header("Location: login.php");
exit;
?>