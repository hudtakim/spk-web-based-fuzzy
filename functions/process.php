<?php 
session_start();
include"functions.php";

if($_SESSION['legitUser'] != 'qwerty'){
    die(header("../pages/location: 404.html"));
}

if(isset($_POST['submit'])){
    $kriteria = $_POST['kriteria'];

    //cek dulu apakah ada di database
    $result1 = mysqli_query($conn,"SELECT * from daftar_kriteria_static WHERE (kriteria = '$kriteria')");
    $rowcount=mysqli_num_rows($result1);

    if($rowcount == 0){
        $message = "Data yang anda masukkan tidak ditemukan pada data base!!!";
        echo "<script>alert('$message'); window.location.replace('../pages/admin_page.php');</script>";
    }else{
        $result2 = mysqli_query($conn,"SELECT * from daftar_kriteria WHERE (kriteria = '$kriteria')");
        $rowcount=mysqli_num_rows($result2);
        $jumlah_kriteria_aktif = mysqli_query($conn,"SELECT * from daftar_kriteria");
        $jumlah_kriteria_aktif = mysqli_num_rows($jumlah_kriteria_aktif );
        if($rowcount == 1){
            $message = "Kriteria yang anda pilih sudah aktif.";
                echo "<script>alert('$message'); window.location.replace('../pages/admin_page.php');</script>";
        }else{
            if($jumlah_kriteria_aktif == 6){
                $message = "Gagal mengaktifkan kriteria, Batas jumlah kriteria aktif adalah 6. Silahkan non-aktifkan kriteria terlebih dahulu atau upgrade ke versi pro dengan menghubungi developer: hudtakim@gmail.com";
                echo "<script>alert('$message'); window.location.replace('../pages/admin_page.php');</script>";
            }else{
                while($data = mysqli_fetch_array($result1)):
                    $sub1 = $data['sub1'];
                    $sub2 = $data['sub2'];
                    $sub3 = $data['sub3'];
                    $sub4 = $data['sub4'];
                    $sub5 = $data['sub5'];
                endwhile;
      
                $result = mysqli_query($conn, "INSERT INTO daftar_kriteria(kriteria, sub1, sub2, sub3, sub4, sub5) 
                VALUES('$kriteria', '$sub1','$sub2', '$sub3', '$sub4', '$sub5')");
    
                if($result){ 
                    $message = "Berhasil mengaktifkan kriteria.";
                    echo "<script>alert('$message'); window.location.replace('../pages/admin_page.php');</script>";
                } else {
                    echo $result;
                }
            }
        }
    }
}elseif(isset($_POST['submit-del'])){
    $kriteria = $_POST['kriteria'];
    $result = mysqli_query($conn,"SELECT * from daftar_kriteria WHERE (kriteria = '$kriteria')");
    $rowcount=mysqli_num_rows($result);
    if($rowcount == 0){
        $result = mysqli_query($conn,"SELECT * from daftar_kriteria_static");
        $rowcount=mysqli_num_rows($result);
        if(false){
            $message = "[GAGAL!!!] - Setidaknya harus ada 1 kriteria yang tersimpan pada database.";
            echo "<script>alert('$message'); window.location.replace('../pages/admin_page.php');</script>";
        }else{
            $del = mysqli_query($conn,"DELETE FROM daftar_kriteria_static where kriteria = '$kriteria'");
            $nk_lowered = strtolower($kriteria);
            $tname = "fuzzy_";
            $tname.=$nk_lowered;
            $del = mysqli_query($conn,"DROP TABLE {$tname}");
            $del = mysqli_query($conn, "ALTER TABLE tempat_wisata_tb DROP COLUMN {$nk_lowered};");
            if($del){
                mysqli_close($conn); // Close connection
                $message = "Kriteria berhasil dihapus dari database.";
                echo "<script>alert('$message'); window.location.replace('../pages/admin_page.php');</script>";
            }else {
                echo "Error deleting record"; // display error message if not delete
            }
        }
    }else{
        $message = "[GAGAL!!!] - Kriteria yang akan anda hapus masih aktif, silahkan non-aktifkan terlebih dahulu. ";
        echo "<script>alert('$message'); window.location.replace('../pages/admin_page.php');</script>";
    } 
}
?>