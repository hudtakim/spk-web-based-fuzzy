<?php 
session_start();
include"functions.php";

if($_SESSION['legitUser'] != 'qwerty'){
    die(header("location: ../pages/404.html"));
}else{
    $nama_wilayah = $_POST['nama_wilayah'];

    $result = mysqli_query($conn, "UPDATE setting_tampilan SET nama_wilayah = '$nama_wilayah'");
    if($result){
        $message = "Deskripsi Website berhasil diperbaharui.";
        echo "<script>alert('$message'); window.location.replace('../pages/pengaturan_tampilan.php');</script>";
    }else{
        $message = "Update Deskripsi Website gagal.";
        echo "<script>alert('$message'); window.location.replace('../pages/pengaturan_tampilan.php');</script>";
    }
}
?>