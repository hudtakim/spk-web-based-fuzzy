<?php 
session_start();
include"functions.php";

if($_SESSION['legitUser'] != 'qwerty'){
    die(header("../pages/location: 404.html"));
}

$id = $_GET['id']; // get id through query string
$item = $_GET['item']; // get id through query string

if($item == 'kriteria'){
    $del = mysqli_query($conn,"DELETE FROM daftar_kriteria where id = '$id'");
}
if($item == 'lokasi'){
    $result = mysqli_query($conn,"SELECT * from tempat_wisata_tb");
    $rowcount=mysqli_num_rows($result);
    if(false){
        $message = "[GAGAL!!!] - Setidaknya harus ada 1 data yang tersimpan pada database.";
        echo "<script>alert('$message'); window.location.replace('../pages/data_lokasi_wisata.php');</script>";
    }else{
        $del = mysqli_query($conn,"DELETE FROM tempat_wisata_tb where id = '$id'");

        $arr_kriteria = mysqli_query($conn,"SELECT * from daftar_kriteria_static");
        while($data = mysqli_fetch_array($arr_kriteria)):
            $tname = "fuzzy_";
            $tname.= strtolower($data['kriteria']);
            $del = mysqli_query($conn,"DELETE FROM {$tname} where id = '$id'");
        endwhile;
    }
}

if($del)
{
    mysqli_close($conn); // Close connection
    if($item == 'kriteria'){
        header("location:../pages/admin_page.php"); // redirects to all records page
    }
    if($item == 'lokasi'){
        $message = "Berhasil menghapus data.";
        echo "<script>alert('$message'); window.location.replace('../pages/data_lokasi_wisata.php');</script>";
        //header("location:data_lokasi_wisata.php"); // redirects to all records page
    }
    exit;	
}
else
{
    echo "Error deleting record"; // display error message if not delete
}
?>