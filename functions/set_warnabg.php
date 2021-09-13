<?php 
session_start();
include"functions.php";

if($_SESSION['legitUser'] != 'qwerty'){
    die(header("location: ../pages/404.html"));
}else{
    $warna_bg = $_POST['warna'];

    $result = mysqli_query($conn, "UPDATE setting_tampilan SET warna_bg = '$warna_bg'");
    if($result){
        $message = "Warna background berhasil diperbaharui.";
        echo "<script>alert('$message'); window.location.replace('../pages/pengaturan_tampilan.php');</script>";
    }else{
        $message = "Update warna background gagal.";
        echo "<script>alert('$message'); window.location.replace('../pages/pengaturan_tampilan.php');</script>";
    }
}
?>