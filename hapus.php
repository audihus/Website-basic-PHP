<?php 
session_start();

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}
include "functions.php";
$id = $_GET["id"];

$hasil_query = hapus($id);
if($hasil_query>0){
    echo "<script>
    alert('Data berhasil dihapus!');
    document.location.href = 'index.php';
    </script>";
}else{
    echo "<script>
    alert('Data berhasil dihapus!');
    document.location.href = 'index.php';
    </script>";
}

?>