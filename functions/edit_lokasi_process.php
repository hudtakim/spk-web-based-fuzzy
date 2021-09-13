<?php 
session_start();
include"functions.php";
include"fungsi_keanggotaan.php";

if($_SESSION['legitUser'] != 'qwerty'){
    die(header("location: ../pages/404.html"));
}else{
    if(isset($_POST['submit'])){
        $id_lokasi = $_POST['id_lokasi'];
        $ob_wis = $_POST['nama'];

        $result = mysqli_query($conn, "SELECT * FROM tempat_wisata_tb WHERE (id != '$id_lokasi' AND obyek_wisata = '$ob_wis')");
        $rowcount = mysqli_num_rows($result);
        if($rowcount > 0){
            $message = "Gagal, nama lokasi sudah tersedia di database.";
            echo "<script>alert('$message'); window.location.replace('../pages/edit_lokasi.php?id=$id_lokasi');</script>";
        }else{
            $arr_kriteria = mysqli_query($conn,"SELECT * from daftar_kriteria_static");
            $jumlah_kriteria = mysqli_num_rows($arr_kriteria);
            $input_kriteria = array();
            $list_labelkrit = array();
            $list_nama_kriteria = array();
            $list_kategori = array();
            while($data = mysqli_fetch_array($arr_kriteria)):
                $kriteria = strtolower($data['kriteria']);
                array_push($input_kriteria, $_POST[$kriteria]);
                array_push($list_labelkrit, $kriteria);
                array_push($list_nama_kriteria, $data['kriteria']);
                array_push($list_kategori, $data['kategori']);
            endwhile;
            //Update tempat wisata tb
            $input_kriteria2 = $input_kriteria;
            for($x=0; $x<count($list_kategori); $x++){
                $get_kategori = mysqli_query($conn,"SELECT * FROM daftar_kriteria_static WHERE (kriteria = '$list_nama_kriteria[$x]')");
                $row = $get_kategori->fetch_assoc();

                if($list_kategori[$x] == "non_fuzzy"){
                    $val = $input_kriteria[$x];
                    if($val == "sub1"){$valu = $row['sub1'];}
                    if($val == "sub2"){$valu = $row['sub2'];}
                    if($val == "sub3"){$valu = $row['sub3'];}
                    if($val == "sub4"){$valu = $row['sub4'];}
                    if($val == "sub5"){$valu = $row['sub5'];}
                    $input_kriteria[$x] = $valu;
                }
            }
            
            if(count($list_labelkrit) == 1){
                $result = mysqli_query($conn, "UPDATE tempat_wisata_tb 
                SET obyek_wisata='$ob_wis', {$list_labelkrit[0]}='$input_kriteria[0]' 
                WHERE id = $id_lokasi");
                $krit_used = 1;
            }elseif(count($list_labelkrit) == 2){
                $result = mysqli_query($conn, "UPDATE tempat_wisata_tb 
                SET obyek_wisata='$ob_wis', {$list_labelkrit[0]}='$input_kriteria[0]',  {$list_labelkrit[1]}='$input_kriteria[1]' 
                WHERE id = $id_lokasi");
                $krit_used = 2;
            }elseif(count($list_labelkrit) == 3){
                $result = mysqli_query($conn, "UPDATE tempat_wisata_tb 
                SET obyek_wisata='$ob_wis', {$list_labelkrit[0]}='$input_kriteria[0]',  {$list_labelkrit[1]}='$input_kriteria[1]', {$list_labelkrit[2]}='$input_kriteria[2]'
                WHERE id = $id_lokasi");
                $krit_used = 3;
            }elseif(count($list_labelkrit) == 4){
                $result = mysqli_query($conn, "UPDATE tempat_wisata_tb 
                SET obyek_wisata='$ob_wis', {$list_labelkrit[0]}='$input_kriteria[0]',  {$list_labelkrit[1]}='$input_kriteria[1]', {$list_labelkrit[2]}='$input_kriteria[2]',{$list_labelkrit[3]}='$input_kriteria[3]'
                WHERE id = $id_lokasi");
                $krit_used = 4;
            }elseif(count($list_labelkrit) == 5){
                $result = mysqli_query($conn, "UPDATE tempat_wisata_tb 
                SET obyek_wisata='$ob_wis', {$list_labelkrit[0]}='$input_kriteria[0]',  {$list_labelkrit[1]}='$input_kriteria[1]', {$list_labelkrit[2]}='$input_kriteria[2]',{$list_labelkrit[3]}='$input_kriteria[3]', {$list_labelkrit[4]}='$input_kriteria[4]'
                WHERE id = $id_lokasi");
                $krit_used = 5;
            }elseif(count($list_labelkrit) == 6){
                $result = mysqli_query($conn, "UPDATE tempat_wisata_tb 
                SET obyek_wisata='$ob_wis', {$list_labelkrit[0]}='$input_kriteria[0]',  {$list_labelkrit[1]}='$input_kriteria[1]', {$list_labelkrit[2]}='$input_kriteria[2]',{$list_labelkrit[3]}='$input_kriteria[3]', {$list_labelkrit[4]}='$input_kriteria[4]', {$list_labelkrit[5]}='$input_kriteria[5]'
                WHERE id = $id_lokasi");
                $krit_used = 6;
            }elseif(count($list_labelkrit) == 7){
                $result = mysqli_query($conn, "UPDATE tempat_wisata_tb 
                SET obyek_wisata='$ob_wis', {$list_labelkrit[0]}='$input_kriteria[0]',  {$list_labelkrit[1]}='$input_kriteria[1]', {$list_labelkrit[2]}='$input_kriteria[2]',{$list_labelkrit[3]}='$input_kriteria[3]', {$list_labelkrit[4]}='$input_kriteria[4]', {$list_labelkrit[5]}='$input_kriteria[5]', {$list_labelkrit[6]}='$input_kriteria[6]'
                WHERE id = $id_lokasi");
                $krit_used = 7;
            }elseif(count($list_labelkrit) == 8){
                $result = mysqli_query($conn, "UPDATE tempat_wisata_tb 
                SET obyek_wisata='$ob_wis', {$list_labelkrit[0]}='$input_kriteria[0]',  {$list_labelkrit[1]}='$input_kriteria[1]', {$list_labelkrit[2]}='$input_kriteria[2]',{$list_labelkrit[3]}='$input_kriteria[3]', {$list_labelkrit[4]}='$input_kriteria[4]', {$list_labelkrit[5]}='$input_kriteria[5]', {$list_labelkrit[6]}='$input_kriteria[6]',{$list_labelkrit[7]}='$input_kriteria[7]'
                WHERE id = $id_lokasi");
                $krit_used = 8;
            }elseif(count($list_labelkrit) == 9){
                $result = mysqli_query($conn, "UPDATE tempat_wisata_tb 
                SET obyek_wisata='$ob_wis', {$list_labelkrit[0]}='$input_kriteria[0]',  {$list_labelkrit[1]}='$input_kriteria[1]', {$list_labelkrit[2]}='$input_kriteria[2]',{$list_labelkrit[3]}='$input_kriteria[3]', {$list_labelkrit[4]}='$input_kriteria[4]', {$list_labelkrit[5]}='$input_kriteria[5]', {$list_labelkrit[6]}='$input_kriteria[6]',{$list_labelkrit[7]}='$input_kriteria[7]',{$list_labelkrit[8]}='$input_kriteria[8]' 
                WHERE id = $id_lokasi");
                $krit_used = 9;
            }elseif(count($list_labelkrit) == 10){
                $result = mysqli_query($conn, "UPDATE tempat_wisata_tb 
                SET obyek_wisata='$ob_wis', {$list_labelkrit[0]}='$input_kriteria[0]',  {$list_labelkrit[1]}='$input_kriteria[1]', {$list_labelkrit[2]}='$input_kriteria[2]',{$list_labelkrit[3]}='$input_kriteria[3]', {$list_labelkrit[4]}='$input_kriteria[4]', {$list_labelkrit[5]}='$input_kriteria[5]', {$list_labelkrit[6]}='$input_kriteria[6]',{$list_labelkrit[7]}='$input_kriteria[7]',{$list_labelkrit[8]}='$input_kriteria[8]',{$list_labelkrit[9]}='$input_kriteria[9]' 
                WHERE id = $id_lokasi");
                $krit_used = 10;
            }else{
                echo "<script>alert('Banyak Kriteria Melebihi Batas (5)')</script>";
                die(header("location: ../pages/404.html"));
            }
            //Update tabel2 bobotnya
            if($result){
                $it = 0;
                foreach($list_nama_kriteria as &$nilai_krit){
                    $get_kategori = mysqli_query($conn,"SELECT * from daftar_kriteria_static WHERE (kriteria = '$nilai_krit')");
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
                    $name_krit  = strtolower($row['kriteria']);
                    $valinput = $_POST[$name_krit];
                    $tname = "fuzzy_";
                    $tname .= strtolower($row['kriteria']);
                    $id = $id_lokasi;
                    
                    if($sub3 == ""){
                        if($kategori == "fuzzy"){
                            $v0=(int)$valinput ; $v1= $batas1; $v2= $batas2;
                            $bsub1 = getbobot_fuzzy2($v0, "sub1",$v1, $v2);
                            $bsub2 = getbobot_fuzzy2($v0, "sub2",$v1, $v2);
                            $sukses = mysqli_query($conn, "UPDATE 
                            {$tname} SET obyek_wisata='$ob_wis', {$name_krit}=$v0, {$sub1}=$bsub1, {$sub2}=$bsub2 
                            WHERE (id = $id_lokasi)");

                        }else{
                            $v0=(string)$valinput;
                            if($v0 == "sub1"){$valu = $row['sub1'];}
                            if($v0 == "sub2"){$valu = $row['sub2'];}
                            $bsub1 = getbobot_non_fuzzy($v0)[0];
                            $bsub2 = getbobot_non_fuzzy($v0)[1];
                            $sukses = mysqli_query($conn, "UPDATE 
                            {$tname} SET obyek_wisata='$ob_wis', {$name_krit}='$valu', {$sub1}=$bsub1, {$sub2}=$bsub2
                            WHERE (id = $id_lokasi)");
                        }
                    }if($sub4 ==""){
                        if($kategori == "fuzzy"){
                            $v0=(int)$valinput ; $v1= $batas1; $v2= $batas2; $v3= $batas3;
                            $bsub1 = getbobot_fuzzy3($v0, "sub1",$v1, $v2, $v3);
                            $bsub2 = getbobot_fuzzy3($v0, "sub2",$v1, $v2, $v3);
                            $bsub3 = getbobot_fuzzy3($v0, "sub3",$v1, $v2, $v3);
                            $sukses = mysqli_query($conn, "UPDATE 
                            {$tname} SET obyek_wisata='$ob_wis', {$name_krit}=$v0, {$sub1}=$bsub1, {$sub2}=$bsub2, {$sub3}=$bsub3
                            WHERE (id = $id_lokasi)");
                        }else{
                            $v0=(string)$valinput;
                            if($v0 == "sub1"){$valu = $row['sub1'];}
                            if($v0 == "sub2"){$valu = $row['sub2'];}
                            if($v0 == "sub3"){$valu = $row['sub3'];}
                            $bsub1 = getbobot_non_fuzzy($v0)[0];
                            $bsub2 = getbobot_non_fuzzy($v0)[1];
                            $bsub3 = getbobot_non_fuzzy($v0)[2];

                            $sukses = mysqli_query($conn, "UPDATE 
                            {$tname} SET obyek_wisata='$ob_wis', {$name_krit}='$valu', {$sub1}=$bsub1, {$sub2}=$bsub2, {$sub3}=$bsub3
                            WHERE (id = $id_lokasi)");
                        }
                    }if($sub5==""){
                        if($kategori == "fuzzy"){
                            $v0=(int)$valinput ; $v1= $batas1; $v2= $batas2; $v3= $batas3; $v4=$batas4; $v5=$batas5;
                            $bsub1 = getbobot_fuzzy4($v0, "sub1", $v1, $v2, $v3, $v4);
                            $bsub2 = getbobot_fuzzy4($v0, "sub2",$v1, $v2, $v3, $v4);
                            $bsub3 = getbobot_fuzzy4($v0, "sub3",$v1, $v2, $v3, $v4);
                            $bsub4 = getbobot_fuzzy4($v0, "sub4",$v1, $v2, $v3, $v4);
                            $sukses = mysqli_query($conn, "UPDATE 
                            {$tname} SET obyek_wisata='$ob_wis', {$name_krit}=$v0, {$sub1}=$bsub1, {$sub2}=$bsub2, {$sub3}=$bsub3, {$sub4}=$bsub4
                            WHERE (id = $id_lokasi)");
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
                            $sukses = mysqli_query($conn, "UPDATE 
                            {$tname} SET obyek_wisata='$ob_wis', {$name_krit}='$valu', {$sub1}=$bsub1, {$sub2}=$bsub2, {$sub3}=$bsub3, {$sub4}=$bsub4
                            WHERE (id = $id_lokasi)");
                        }
                    }else{
                        if($kategori == "fuzzy"){
                            $v0=(int)$valinput ; $v1= $batas1; $v2= $batas2; $v3= $batas3; $v4=$batas4; $v5=$batas5;
                            $bsub1 = getbobot_fuzzy5($v0, "sub1",$v1, $v2, $v3, $v4, $v5);
                            $bsub2 = getbobot_fuzzy5($v0, "sub2",$v1, $v2, $v3, $v4, $v5);
                            $bsub3 = getbobot_fuzzy5($v0, "sub3",$v1, $v2, $v3, $v4, $v5);
                            $bsub4 = getbobot_fuzzy5($v0, "sub4",$v1, $v2, $v3, $v4, $v5);
                            $bsub5 = getbobot_fuzzy5($v0, "sub5",$v1, $v2, $v3, $v4, $v5);
                            $sukses = mysqli_query($conn, "UPDATE 
                            {$tname} SET obyek_wisata='$ob_wis', {$name_krit}=$v0, {$sub1}=$bsub1, {$sub2}=$bsub2, {$sub3}=$bsub3, {$sub4}=$bsub4, {$sub5}=$bsub5
                            WHERE (id = $id_lokasi)");
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
                            $sukses = mysqli_query($conn, "UPDATE 
                            {$tname} SET obyek_wisata='$ob_wis', {$name_krit}='$valu', {$sub1}=$bsub1, {$sub2}=$bsub2, {$sub3}=$bsub3, {$sub4}=$bsub4, {$sub5}=$bsub5
                            WHERE (id = $id_lokasi)");
                        }
                    }
                }
                $it++;
            }

                $message = "Edit data berhasil.";
                echo "<script>alert('$message'); window.location.replace('../pages/data_lokasi_wisata.php');</script>";

        }
    }else{
        echo "Submit tidak terdeteksi";
    }
}