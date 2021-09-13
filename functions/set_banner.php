<?php 
session_start();
include"functions.php";

if($_SESSION['legitUser'] != 'qwerty'){
    die(header("location: ../pages/404.html"));
}else{
    $link_gambar = $_POST['url'];

    $result = mysqli_query($conn, "UPDATE setting_tampilan SET link_gambar = '$link_gambar'");
    if($result){
        $message = "Banner berhasil diperbaharui.";
        echo "<script>alert('$message'); window.location.replace('../pages/pengaturan_tampilan.php');</script>";
    }else{
        $message = "Update banner gagal.";
        echo "<script>alert('$message'); window.location.replace('../pages/pengaturan_tampilan.php');</script>";
    }
}
?>