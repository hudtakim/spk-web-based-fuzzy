<?php 
session_start();
include "functions.php";
include "fungsi_keanggotaan.php";

if($_SESSION['legitUser'] != 'qwerty'){
    die(header("location: ../pages/404.html"));
}

if(isset($_POST['submit'])){
    $ob_wis = $_POST['nama'];

    $arr_kriteria = mysqli_query($conn,"SELECT * from daftar_kriteria_static");
    $jumlah_kriteria = mysqli_num_rows($arr_kriteria);
    $input_kriteria = array();
    $list_kriteria = array();
    $list_kriteria2 = array();
    $list_kategori = array();
    while($data = mysqli_fetch_array($arr_kriteria)):
        $kriteria = strtolower($data['kriteria']);
        array_push($input_kriteria, $_POST[$kriteria]);
        array_push($list_kriteria, $kriteria);
        array_push($list_kriteria2, $data['kriteria']);
        array_push($list_kategori, $data['kategori']);
    endwhile;

    //cek dulu apakah sudah ada di database
    $result1 = mysqli_query($conn,"SELECT * from tempat_wisata_tb WHERE (obyek_wisata = '$ob_wis')");
    $rowcount = mysqli_num_rows($result1);
    if($rowcount > 0){
        $message = "Input gagal, data lokasi sudah ada di database!";
        echo "<script>alert('$message'); window.location.replace('../pages/data_lokasi_wisata.php');</script>";
    }else{
        //insert data to tempat_wisata_tb
        if($jumlah_kriteria == 0){
            $sukses = mysqli_query($conn, "INSERT INTO tempat_wisata_tb(obyek_wisata) VALUES('$ob_wis')");
        }
        else{
            for($x=0; $x<$jumlah_kriteria; $x++){
                $krit = $list_kriteria[$x];
                $krit2 = $list_kriteria2[$x];
                $valkrit = $input_kriteria[$x];
                $cek = mysqli_query($conn,"SELECT * from tempat_wisata_tb WHERE (obyek_wisata = '$ob_wis')");
                $count_cek = mysqli_num_rows($cek);
                if($count_cek == 0){
                    if($list_kategori[$x] == "fuzzy"){
                        $sukses = mysqli_query($conn, "INSERT INTO tempat_wisata_tb(obyek_wisata, {$krit}) 
                        VALUES('$ob_wis', '$valkrit')");
                    }else{
                        $get_kategori = mysqli_query($conn,"SELECT * from daftar_kriteria_static WHERE (kriteria = '$krit2')");
                        $row = $get_kategori->fetch_assoc();
                        if($valkrit== "sub1"){$valu = $row['sub1'];}
                        if($valkrit == "sub2"){$valu = $row['sub2'];}
                        if($valkrit == "sub3"){$valu = $row['sub3'];}
                        if($valkrit == "sub4"){$valu = $row['sub4'];}
                        if($valkrit == "sub5"){$valu = $row['sub5'];}
                        $sukses = mysqli_query($conn, "INSERT INTO tempat_wisata_tb(obyek_wisata, {$krit}) 
                        VALUES('$ob_wis', '$valu')");
                    }
                }else{
                    if($list_kategori[$x] == "fuzzy"){
                        $sukses = mysqli_query($conn, "UPDATE tempat_wisata_tb SET {$krit} = $valkrit WHERE (obyek_wisata = '$ob_wis')");
                    }else{
                        $get_kategori = mysqli_query($conn,"SELECT * from daftar_kriteria_static WHERE (kriteria = '$krit2')");
                        $row = $get_kategori->fetch_assoc();
                        if($valkrit== "sub1"){$valu = $row['sub1'];}
                        if($valkrit == "sub2"){$valu = $row['sub2'];}
                        if($valkrit == "sub3"){$valu = $row['sub3'];}
                        if($valkrit == "sub4"){$valu = $row['sub4'];}
                        if($valkrit == "sub5"){$valu = $row['sub5'];}
                        $sukses = mysqli_query($conn, "UPDATE tempat_wisata_tb SET {$krit} = '$valu' WHERE (obyek_wisata = '$ob_wis')");
                    }
                }   
            }
        }

        $getid = mysqli_query($conn,"SELECT DISTINCT(id) from tempat_wisata_tb WHERE (obyek_wisata = '$ob_wis')");
        $row = $getid->fetch_row();
        $nid = $row[0] ?? false;
        $id = (int)$nid;
        $it = 0;
        foreach($list_kriteria2 as &$nilai_krit){
            $get_kategori = mysqli_query($conn,"SELECT kategori, batas1, batas2, batas3, batas4, batas5, sub1, sub2, sub3, sub4, sub5 from daftar_kriteria_static WHERE (kriteria = '$nilai_krit')");
            $row = $get_kategori->fetch_assoc();
            $kategori = $row['kategori'];
            $batas1 = $row['batas1'];
            $batas2 = $row['batas2'];
            $batas3 = $row['batas3'];
            $batas4 = $row['batas4'];
            $batas5 = $row['batas5'];
            $sub1 = strtolower($row['sub1']);
            $sub2 = strtolower($row['sub2']);
            $sub3 = strtolower($row['sub3']);
            $sub4 = strtolower($row['sub4']);
            $sub5 = strtolower($row['sub5']);
            $name_krit  = $list_kriteria[$it];
            $valinput = $input_kriteria[$it];
            $tname = "fuzzy_";
            $tname .= $list_kriteria[$it];

            if($sub3 == ""){
                if($kategori == "fuzzy"){
                    $v0=(int)$valinput ; $v1= $batas1; $v2= $batas2;
                    $bsub1 = getbobot_fuzzy2($v0, "sub1", $v1, $v2);
                    $bsub2 = getbobot_fuzzy2($v0, "sub2",$v1, $v2);
                    $sukses2 = mysqli_query($conn, "INSERT INTO {$tname}(id, obyek_wisata, {$name_krit}, {$sub1}, {$sub2}) 
                    VALUES('$id','$ob_wis', '$v0', '$bsub1','$bsub2')");
                }else{
                    $v0=(string)$valinput;
                    if($v0 == "sub1"){$valu = $row['sub1'];}
                    if($v0 == "sub2"){$valu = $row['sub2'];}
                    $bsub1 = getbobot_non_fuzzy($v0)[0];
                    $bsub2 = getbobot_non_fuzzy($v0)[1];
                    $sukses2 = mysqli_query($conn, "INSERT INTO {$tname}(id, obyek_wisata, {$name_krit}, {$sub1}, {$sub2}) 
                    VALUES('$id','$ob_wis', '$valu', '$bsub1','$bsub2')");
                }
            }if($sub4 ==""){
                if($kategori == "fuzzy"){
                    $v0=(int)$valinput ; $v1= $batas1; $v2= $batas2; $v3= $batas3;
                    $bsub1 = getbobot_fuzzy3($v0, "sub1", $v1, $v2, $v3);
                    $bsub2 = getbobot_fuzzy3($v0, "sub2",$v1, $v2, $v3);
                    $bsub3 = getbobot_fuzzy3($v0, "sub3",$v1, $v2, $v3);
                    $sukses2 = mysqli_query($conn, "INSERT INTO {$tname}(id, obyek_wisata, {$name_krit}, {$sub1}, {$sub2}, {$sub3}) 
                    VALUES('$id','$ob_wis', '$v0', '$bsub1','$bsub2','$bsub3')");
                }else{
                    $v0=(string)$valinput;
                    if($v0 == "sub1"){$valu = $row['sub1'];}
                    if($v0 == "sub2"){$valu = $row['sub2'];}
                    if($v0 == "sub3"){$valu = $row['sub3'];}
                    $bsub1 = getbobot_non_fuzzy($v0)[0];
                    $bsub2 = getbobot_non_fuzzy($v0)[1];
                    $bsub3 = getbobot_non_fuzzy($v0)[2];
                    $sukses2 = mysqli_query($conn, "INSERT INTO {$tname}(id, obyek_wisata, {$name_krit}, {$sub1}, {$sub2}, {$sub3}) 
                    VALUES('$id','$ob_wis', '$valu', '$bsub1','$bsub2','$bsub3')");
                }
            }if($sub5==""){
                if($kategori == "fuzzy"){
                    $v0=(int)$valinput ; $v1= $batas1; $v2= $batas2; $v3= $batas3; $v4=$batas4;
                    $bsub1 = getbobot_fuzzy4($v0, "sub1",$v1, $v2, $v3, $v4);
                    $bsub2 = getbobot_fuzzy4($v0, "sub2",$v1, $v2, $v3, $v4);
                    $bsub3 = getbobot_fuzzy4($v0, "sub3",$v1, $v2, $v3, $v4);
                    $bsub4 = getbobot_fuzzy4($v0, "sub4",$v1, $v2, $v3, $v4);
                    $sukses2 = mysqli_query($conn, "INSERT INTO {$tname}(id, obyek_wisata, {$name_krit}, {$sub1}, {$sub2}, {$sub3},{$sub4}) 
                    VALUES('$id','$ob_wis', '$v0', '$bsub1','$bsub2','$bsub3','$bsub4')");
                }else{
                    $v0=(string)$valinput;
                    if($v0 == "sub1"){$valu = $row['sub1'];}
                    if($v0 == "sub2"){$valu = $row['sub2'];}
                    if($v0 == "sub3"){$valu = $row['sub3'];}
                    if($v0 == "sub4"){$valu = $row['sub4'];}
                    $bsub1 = getbobot_non_fuzzy($v0)[0];
                    $bsub2 = getbobot_non_fuzzy($v0)[1];
                    $bsub3 = getbobot_non_fuzzy($v0)[2];
                    $bsub4 = getbobot_non_fuzzy($v0)[3];
                    $sukses2 = mysqli_query($conn, "INSERT INTO {$tname}(id, obyek_wisata, {$name_krit}, {$sub1}, {$sub2}, {$sub3},{$sub4}) 
                    VALUES('$id','$ob_wis', '$valu', '$bsub1','$bsub2','$bsub3','$bsub4')");
                }
            }else{
                if($kategori == "fuzzy"){
                    $v0=(int)$valinput ; $v1= $batas1; $v2= $batas2; $v3= $batas3; $v4=$batas4; $v5=$batas5;
                    $bsub1 = getbobot_fuzzy5($v0, "sub1", $v1, $v2, $v3, $v4, $v5);
                    $bsub2 = getbobot_fuzzy5($v0, "sub2",$v1, $v2, $v3, $v4, $v5);
                    $bsub3 = getbobot_fuzzy5($v0, "sub3",$v1, $v2, $v3, $v4, $v5);
                    $bsub4 = getbobot_fuzzy5($v0, "sub4",$v1, $v2, $v3, $v4, $v5);
                    $bsub5 = getbobot_fuzzy5($v0, "sub5",$v1, $v2, $v3, $v4, $v5);
                    $sukses2 = mysqli_query($conn, "INSERT INTO {$tname}(id, obyek_wisata, {$name_krit}, {$sub1}, {$sub2}, {$sub3},{$sub4},{$sub5}) 
                    VALUES('$id','$ob_wis', '$v0', '$bsub1','$bsub2','$bsub3','$bsub4','$bsub5')");
                }else{
                    $v0=(string)$valinput;
                    if($v0 == "sub1"){$valu = $row['sub1'];}
                    if($v0 == "sub2"){$valu = $row['sub2'];}
                    if($v0 == "sub3"){$valu = $row['sub3'];}
                    if($v0 == "sub4"){$valu = $row['sub4'];}
                    if($v0 == "sub5"){$valu = $row['sub5'];}
                    $bsub1 = getbobot_non_fuzzy($v0)[0];
                    $bsub2 = getbobot_non_fuzzy($v0)[1];
                    $bsub3 = getbobot_non_fuzzy($v0)[2];
                    $bsub4 = getbobot_non_fuzzy($v0)[3];
                    $bsub5 = getbobot_non_fuzzy($v0)[4];
                    $sukses2 = mysqli_query($conn, "INSERT INTO {$tname}(id, obyek_wisata, {$name_krit}, {$sub1}, {$sub2}, {$sub3},{$sub4},{$sub5}) 
                    VALUES('$id','$ob_wis', '$valu', '$bsub1','$bsub2','$bsub3','$bsub4','$bsub5')");
                }
            }
            $it++;
        }
        
        //$result = mysqli_query($conn, "ALTER TABLE tempat_wisata_tb AUTO_INCREMENT = 1");
        
        //if($result){ 
        $message = "Berhasil menambahkan data.";
        echo "<script>alert('$message'); window.location.replace('../pages/data_lokasi_wisata.php');</script>";
        //}
            //echo "<h1>WARNING !!!</h1> <br>";
            //echo $sukses;
            //echo "<br>---------------------------<br>";
            //echo $sukses2;
        //} 
    }
}

?>