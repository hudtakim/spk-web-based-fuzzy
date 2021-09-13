<?php 
session_start();
include"functions.php";
include"fungsi_keanggotaan.php";

function has_dupes($array) {
    $dupe_array = array();
    foreach ($array as $val) {
        if (++$dupe_array[$val] > 1) {
            return true;
        }
    }
    return false;
}

if($_SESSION['legitUser'] != 'qwerty'){
    die(header("location: ../pages/404.html"));
}

if(isset($_POST['submit'])){
    $id_krit = $_POST['id_krit'];
    $kategori = $_POST['kategori'];
    $old_nama_kriteria = $_POST['name_krit'];
    $nama_kriteria = $_POST['nama'];
    $nama_sub1 = $_POST['sub1'];
    $nama_sub2 = $_POST['sub2'];
    $nama_sub3 = $_POST['sub3'];
    $nama_sub4 = $_POST['sub4'];
    $nama_sub5 = $_POST['sub5'];
    $batas1 = (int)$_POST['batas1'];
    $batas2 = (int)$_POST['batas2'];
    $batas3 = (int)$_POST['batas3'];
    $batas4 = (int)$_POST['batas4'];
    $batas5 = (int)$_POST['batas5'];

    $nid= array();
    $datakriteria_id = array();
    $datakritnon_id = array();
    $lokasiarr = array();
    //cek duplicate on nama kriteria or subkrit
    if($nama_sub3 == ""){
        $array_to_check_dup = array(strtolower($nama_kriteria), strtolower($nama_sub1),strtolower($nama_sub2),strtolower($nama_sub3));
    }elseif($nama_sub4 == ""){
        $array_to_check_dup = array(strtolower($nama_kriteria), strtolower($nama_sub1),strtolower($nama_sub2),strtolower($nama_sub3),strtolower($nama_sub4));
    }else{
        $array_to_check_dup = array(strtolower($nama_kriteria), strtolower($nama_sub1),strtolower($nama_sub2),strtolower($nama_sub3),strtolower($nama_sub4),strtolower($nama_sub5));
    }
    if(has_dupes($array_to_check_dup) == false){
        //cek dulu apakah kriteria sudah ada di database
        $result = mysqli_query($conn,"SELECT * from daftar_kriteria_static WHERE (kriteria = '$nama_kriteria' AND id != '$id_krit')");
        $rowcount = mysqli_num_rows($result);
        $result = mysqli_query($conn,"SELECT * from daftar_kriteria_static");
        $kriteria_tersimpan = mysqli_num_rows($result);
        if($rowcount > 0 ){
            $message = "Gagal, nama kriteria sudah tersedia di database.";
            echo "<script>alert('$message'); window.location.replace('../pages/edit.php?nama_krit=$old_nama_kriteria');</script>";
        }elseif($kriteria_tersimpan > 10){
            $message = "Gagal, batas kriteria yang dapat disimpan telah mencapai batas maksimal (10). Silahkan hapus kriteria terlebih dahulu atau upgrade ke versi pro dengan menghubungi developer: hudtakim@gmail.com";
            echo "<script>alert('$message'); window.location.replace('../pages/edit.php?nama_krit=$old_nama_kriteria');</script>";
        }
        else{
            $data_array = mysqli_query($conn,"SELECT * from tempat_wisata_tb");
            while($data = mysqli_fetch_array($data_array)):
                $id = (string)$data['id'];
                if($kategori == "fuzzy"){
                    $namecol = "datakriteria";
                } else{
                    $namecol = "datakritnon";
                }
                $namecol.=$id;
                array_push($nid, $data['id']);
                array_push($datakriteria_id, $_POST[$namecol]);
                array_push($lokasiarr, $data['obyek_wisata']);
            endwhile;

            $result = mysqli_query($conn, "UPDATE daftar_kriteria_static SET kriteria='$nama_kriteria', sub1='$nama_sub1', sub2='$nama_sub2', sub3='$nama_sub3', sub4='$nama_sub4', sub5='$nama_sub5', batas1='$batas1', batas2='$batas2', batas3='$batas3', batas4='$batas4', batas5='$batas5' WHERE id = $id_krit");
            if($result){ 
                
                $data_array = mysqli_query($conn,"SELECT * from tempat_wisata_tb");
                while($data = mysqli_fetch_array($data_array)):
                    array_push($lokasiarr, $data['obyek_wisata']);
                endwhile;

                $nkriter_lowered = strtolower($old_nama_kriteria);
                $tnamed = "fuzzy_";
                $tnamed.=$nkriter_lowered;
                $del = mysqli_query($conn,"DROP TABLE {$tnamed}");
                $del = mysqli_query($conn, "ALTER TABLE tempat_wisata_tb DROP COLUMN {$nkriter_lowered};");

                $nk_lowered = strtolower($nama_kriteria);
                if($kategori == "fuzzy"){
                    mysqli_query($conn ,"ALTER TABLE tempat_wisata_tb  ADD {$nk_lowered} float(20)" ) or die(mysqli_error($conn));
                }else{
                    mysqli_query($conn ,"ALTER TABLE tempat_wisata_tb ADD {$nk_lowered} VARCHAR(20) NOT NULL" ) or die(mysqli_error($conn));
                }
                if($kategori == "fuzzy"){
                    $it = 0;
                    foreach ($datakriteria_id as &$value) {
                        mysqli_query($conn, "UPDATE tempat_wisata_tb SET {$nk_lowered} = $value WHERE id = $nid[$it]");
                        $it++;
                    }
                }else{
                    $it = 0;
                    foreach ($datakriteria_id as &$value) {
                        $val = (string)$datakriteria_id[$it];
                        if($val == "sub1"){$valu = $nama_sub1;}
                        if($val == "sub2"){$valu = $nama_sub2;}
                        if($val == "sub3"){$valu = $nama_sub3;}
                        if($val == "sub4"){$valu = $nama_sub4;}
                        if($val == "sub5"){$valu = $nama_sub5;}
                        $valu = (string)$valu;
                        mysqli_query($conn, "UPDATE tempat_wisata_tb SET {$nk_lowered} = '$valu' WHERE id = $nid[$it]");
                        $it++;
                    }
                }
                
                $tname = "fuzzy_";
                $tname.=$nk_lowered;
                if($nama_sub3 == ""){
                    $nsub1_lowered = strtolower($nama_sub1);
                    $nsub2_lowered = strtolower($nama_sub2);
                    if($kategori == "fuzzy"){
                        $result = mysqli_query($conn, "CREATE TABLE {$tname}(
                            id INT NOT NULL AUTO_INCREMENT,
                            obyek_wisata VARCHAR(30) NOT NULL,
                            {$nk_lowered} float(20) NOT NULL,
                            {$nsub1_lowered} float(20) NOT NULL,
                            {$nsub2_lowered} float(20) NOT NULL,
                            PRIMARY KEY ( id )
                        )");
                    }else{
                        $result = mysqli_query($conn, "CREATE TABLE {$tname}(
                            id INT NOT NULL AUTO_INCREMENT,
                            obyek_wisata VARCHAR(30) NOT NULL,
                            {$nk_lowered} VARCHAR(20) NOT NULL,
                            {$nsub1_lowered} float(20) NOT NULL,
                            {$nsub2_lowered} float(20) NOT NULL,
                            PRIMARY KEY ( id )
                        )");
                    }
                    if($kategori == "fuzzy"){
                        $it=0;
                        $batas3 = 2 * $batas2;
                        $batas4 = 2 * $batas3;
                        $batas5 = 2 * $batas4;
                        foreach ($nid as &$value) {
                            $val = (float)$datakriteria_id[$it];
                            $sub1 = getbobot_fuzzy2($val, "sub1", $batas1, $batas2);
                            $sub2 = getbobot_fuzzy2($val, "sub2", $batas1, $batas2);
                            $result = mysqli_query($conn, "INSERT INTO {$tname}(id, obyek_wisata, {$nk_lowered},{$nsub1_lowered}, {$nsub2_lowered}) 
                            VALUES('$value', '$lokasiarr[$it]', '$datakriteria_id[$it]','$sub1', '$sub2')");
                            $it++;
                        }
                    }else{
                        $it=0;
                        foreach ($nid as &$value) {
                            $val = (string)$datakriteria_id[$it];
                            if($val == "sub1"){$valu = $nama_sub1;}
                            if($val == "sub2"){$valu = $nama_sub2;}
                            if($val == "sub3"){$valu = $nama_sub3;}
                            $sub1 = getbobot_non_fuzzy($val)[0];
                            $sub2 = getbobot_non_fuzzy($val)[1];
                            $result = mysqli_query($conn, "INSERT INTO {$tname}(id, obyek_wisata, {$nk_lowered},{$nsub1_lowered}, {$nsub2_lowered}) 
                            VALUES('$value', '$lokasiarr[$it]', '$valu','$sub1', '$sub2')");
                            $it++;
                        }
                    }
                }elseif($nama_sub4== ""){
                    $nsub1_lowered = strtolower($nama_sub1);
                    $nsub2_lowered = strtolower($nama_sub2);
                    $nsub3_lowered = strtolower($nama_sub3);
                    if($kategori == "fuzzy"){
                        $result = mysqli_query($conn, "CREATE TABLE {$tname}(
                            id INT NOT NULL AUTO_INCREMENT,
                            obyek_wisata VARCHAR(30) NOT NULL,
                            {$nk_lowered} float(20) NOT NULL,
                            {$nsub1_lowered} float(20) NOT NULL,
                            {$nsub2_lowered} float(20) NOT NULL,
                            {$nsub3_lowered} float(20) NOT NULL,
                            PRIMARY KEY ( id )
                        )");
                    }else{
                        $result = mysqli_query($conn, "CREATE TABLE {$tname}(
                            id INT NOT NULL AUTO_INCREMENT,
                            obyek_wisata VARCHAR(30) NOT NULL,
                            {$nk_lowered} VARCHAR(20) NOT NULL,
                            {$nsub1_lowered} float(20) NOT NULL,
                            {$nsub2_lowered} float(20) NOT NULL,
                            {$nsub3_lowered} float(20) NOT NULL,
                            PRIMARY KEY ( id )
                        )");
                    }
                    if($kategori == "fuzzy"){
                        $it=0;
                        $batas4 = 2 * $batas3;
                        $batas5 = 2 * $batas4;
                        foreach ($nid as &$value) {
                            $val = (float)$datakriteria_id[$it];
                            $sub1 = getbobot_fuzzy3($val, "sub1", $batas1, $batas2, $batas3);
                            $sub2 = getbobot_fuzzy3($val, "sub2", $batas1, $batas2, $batas3);
                            $sub3 = getbobot_fuzzy3($val, "sub3", $batas1, $batas2, $batas3);
                            $result = mysqli_query($conn, "INSERT INTO {$tname}(id, obyek_wisata, {$nk_lowered},{$nsub1_lowered}, {$nsub2_lowered}, {$nsub3_lowered}) 
                            VALUES('$value', '$lokasiarr[$it]', '$datakriteria_id[$it]','$sub1', '$sub2', '$sub3')");
                            $it++;
                        }
                    }else{
                        $it=0;
                        foreach ($nid as &$value) {
                            $val = (string)$datakriteria_id[$it];
                            if($val == "sub1"){$valu = $nama_sub1;}
                            if($val == "sub2"){$valu = $nama_sub2;}
                            if($val == "sub3"){$valu = $nama_sub3;}
                            $sub1 = getbobot_non_fuzzy($val)[0];
                            $sub2 = getbobot_non_fuzzy($val)[1];
                            $sub3 = getbobot_non_fuzzy($val)[2];
                            $result = mysqli_query($conn, "INSERT INTO {$tname}(id, obyek_wisata, {$nk_lowered},{$nsub1_lowered}, {$nsub2_lowered}, {$nsub3_lowered}) 
                            VALUES('$value', '$lokasiarr[$it]', '$valu','$sub1', '$sub2', '$sub3')");
                            $it++;
                        }
                    }
                }elseif($nama_sub5==""){
                    $nsub1_lowered = strtolower($nama_sub1);
                    $nsub2_lowered = strtolower($nama_sub2);
                    $nsub3_lowered = strtolower($nama_sub3);
                    $nsub4_lowered = strtolower($nama_sub4);
                    if($kategori == "fuzzy"){
                        $result = mysqli_query($conn, "CREATE TABLE {$tname}(
                            id INT NOT NULL AUTO_INCREMENT,
                            obyek_wisata VARCHAR(30) NOT NULL,
                            {$nk_lowered} float(20) NOT NULL,
                            {$nsub1_lowered} float(20) NOT NULL,
                            {$nsub2_lowered} float(20) NOT NULL,
                            {$nsub3_lowered} float(20) NOT NULL,
                            {$nsub4_lowered} float(20) NOT NULL,
                            PRIMARY KEY ( id )
                        )");
                    }else{
                        $result = mysqli_query($conn, "CREATE TABLE {$tname}(
                            id INT NOT NULL AUTO_INCREMENT,
                            obyek_wisata VARCHAR(30) NOT NULL,
                            {$nk_lowered} VARCHAR(20) NOT NULL,
                            {$nsub1_lowered} float(20) NOT NULL,
                            {$nsub2_lowered} float(20) NOT NULL,
                            {$nsub3_lowered} float(20) NOT NULL,
                            {$nsub4_lowered} float(20) NOT NULL,
                            PRIMARY KEY ( id )
                        )");
                    }
                    if($kategori == "fuzzy"){
                        $it=0;
                        $batas5 = 2 * $batas4;
                        foreach ($nid as &$value) {
                            $val = (float)$datakriteria_id[$it];
                            $sub1 = getbobot_fuzzy4($val, "sub1", $batas1, $batas2, $batas3, $batas4);
                            $sub2 = getbobot_fuzzy4($val, "sub2", $batas1, $batas2, $batas3, $batas4);
                            $sub3 = getbobot_fuzzy4($val, "sub3", $batas1, $batas2, $batas3, $batas4);
                            $sub4 = getbobot_fuzzy4($val, "sub4", $batas1, $batas2, $batas3, $batas4);
                            $result = mysqli_query($conn, "INSERT INTO {$tname}(id, obyek_wisata, {$nk_lowered},{$nsub1_lowered}, {$nsub2_lowered}, {$nsub3_lowered}, {$nsub4_lowered}) 
                            VALUES('$value', '$lokasiarr[$it]', '$datakriteria_id[$it]','$sub1', '$sub2', '$sub3', '$sub4')");
                            $it++;
                        }
                    }else{
                        $it=0;
                        foreach ($nid as &$value) {
                            $val = (string)$datakriteria_id[$it];
                            if($val == "sub1"){$valu = $nama_sub1;}
                            if($val == "sub2"){$valu = $nama_sub2;}
                            if($val == "sub3"){$valu = $nama_sub3;}
                            if($val == "sub4"){$valu = $nama_sub4;}
                            $sub1 = getbobot_non_fuzzy($val)[0];
                            $sub2 = getbobot_non_fuzzy($val)[1];
                            $sub3 = getbobot_non_fuzzy($val)[2];
                            $sub4 = getbobot_non_fuzzy($val)[3];
                            $result = mysqli_query($conn, "INSERT INTO {$tname}(id, obyek_wisata, {$nk_lowered},{$nsub1_lowered}, {$nsub2_lowered}, {$nsub3_lowered}, {$nsub4_lowered}) 
                            VALUES('$value', '$lokasiarr[$it]', '$valu','$sub1', '$sub2', '$sub3', '$sub4')");
                            $it++;
                        }
                    }
                }else{
                    $nsub1_lowered = strtolower($nama_sub1);
                    $nsub2_lowered = strtolower($nama_sub2);
                    $nsub3_lowered = strtolower($nama_sub3);
                    $nsub4_lowered = strtolower($nama_sub4);
                    $nsub5_lowered = strtolower($nama_sub5);
                    if($kategori == "fuzzy"){
                        $result = mysqli_query($conn, "CREATE TABLE {$tname}(
                            id INT NOT NULL AUTO_INCREMENT,
                            obyek_wisata VARCHAR(30) NOT NULL,
                            {$nk_lowered} float(20) NOT NULL,
                            {$nsub1_lowered} float(20) NOT NULL,
                            {$nsub2_lowered} float(20) NOT NULL,
                            {$nsub3_lowered} float(20) NOT NULL,
                            {$nsub4_lowered} float(20) NOT NULL,
                            {$nsub5_lowered} float(20) NOT NULL,
                            PRIMARY KEY ( id )
                        )");
                    }else{
                        $result = mysqli_query($conn, "CREATE TABLE {$tname}(
                            id INT NOT NULL AUTO_INCREMENT,
                            obyek_wisata VARCHAR(30) NOT NULL,
                            {$nk_lowered} VARCHAR(20) NOT NULL,
                            {$nsub1_lowered} float(20) NOT NULL,
                            {$nsub2_lowered} float(20) NOT NULL,
                            {$nsub3_lowered} float(20) NOT NULL,
                            {$nsub4_lowered} float(20) NOT NULL,
                            {$nsub5_lowered} float(20) NOT NULL,
                            PRIMARY KEY ( id )
                        )");
                    }
                    if($kategori == "fuzzy"){
                        $it=0;
                        foreach ($nid as &$value) {
                            $val = (float)$datakriteria_id[$it];
                            $sub1 = getbobot_fuzzy5($val, "sub1", $batas1, $batas2, $batas3, $batas4, $batas5);
                            $sub2 = getbobot_fuzzy5($val, "sub2", $batas1, $batas2, $batas3, $batas4, $batas5);
                            $sub3 = getbobot_fuzzy5($val, "sub3", $batas1, $batas2, $batas3, $batas4, $batas5);
                            $sub4 = getbobot_fuzzy5($val, "sub4", $batas1, $batas2, $batas3, $batas4, $batas5);
                            $sub5 = getbobot_fuzzy5($val, "sub5", $batas1, $batas2, $batas3, $batas4, $batas5);
                            $result = mysqli_query($conn, "INSERT INTO {$tname}(id, obyek_wisata, {$nk_lowered},{$nsub1_lowered}, {$nsub2_lowered}, {$nsub3_lowered}, {$nsub4_lowered}, {$nsub5_lowered}) 
                            VALUES('$value', '$lokasiarr[$it]', '$datakriteria_id[$it]','$sub1', '$sub2', '$sub3', '$sub4', '$sub5')");
                            $it++;
                        }
                    }else{
                        $it=0;
                        foreach ($nid as &$value) {
                            $val = (string)$datakriteria_id[$it];
                            if($val == "sub1"){$valu = $nama_sub1;}
                            if($val == "sub2"){$valu = $nama_sub2;}
                            if($val == "sub3"){$valu = $nama_sub3;}
                            if($val == "sub4"){$valu = $nama_sub4;}
                            if($val == "sub5"){$valu = $nama_sub5;}
                            $sub1 = getbobot_non_fuzzy($val)[0];
                            $sub2 = getbobot_non_fuzzy($val)[1];
                            $sub3 = getbobot_non_fuzzy($val)[2];
                            $sub4 = getbobot_non_fuzzy($val)[3];
                            $sub5 = getbobot_non_fuzzy($val)[4];
                            $result = mysqli_query($conn, "INSERT INTO {$tname}(id, obyek_wisata, {$nk_lowered},{$nsub1_lowered}, {$nsub2_lowered}, {$nsub3_lowered}, {$nsub4_lowered}, {$nsub5_lowered}) 
                            VALUES('$value', '$lokasiarr[$it]', '$valu','$sub1', '$sub2', '$sub3', '$sub4', '$sub5')");
                            $it++;
                        }
                    }
                }          
                $message = "Update data kriteria berhasil.";
                echo "<script>alert('$message'); window.location.replace('../pages/admin_page.php');</script>";
            }
        } 
    }else{
        $message = "GAGAL - Nama kriteria atau subkriteria harus unik.";
        echo "<script>alert('$message'); window.location.replace('../pages/admin_page.php');</script>";
    }
}
?>