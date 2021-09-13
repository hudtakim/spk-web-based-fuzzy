<?php 
session_start();
include "../functions/functions.php";

if($_SESSION['legitUser'] != 'qwerty'){
    die(header("location: 404.html"));
}
if(isset($_GET['nama_krit'])==false){
	die(header("location: admin_page.php"));
}
$nama_kriteria = $_GET['nama_krit'];
//cek apakah kriteria ada di db apa tidak
$result = mysqli_query($conn, "SELECT * FROM daftar_kriteria_static WHERE (kriteria = '$nama_kriteria')");
$rowcount = mysqli_num_rows($result);
if($rowcount == 0){
    $message = "Mohon maaf, kriteria yang anda pilih tidak tersedia di database.";
    echo "<script>alert('$message'); window.location.replace('admin_page.php');</script>";
}
//Cek kriteria sedang Aktif atau tidak, jika ya maka jangan diupdate
$result = mysqli_query($conn, "SELECT * FROM daftar_kriteria WHERE (kriteria = '$nama_kriteria')");
$rowcount = mysqli_num_rows($result);
if($rowcount > 0){
    $message = "Mohon maaf, kriteria yang anda pilih masih aktif, mohon non-aktifkan terlebih dahulu.";
    echo "<script>alert('$message'); window.location.replace('admin_page.php');</script>";
}
$data_kriteria = mysqli_query($conn, "SELECT * FROM daftar_kriteria_static WHERE (kriteria = '$nama_kriteria')");
$row = $data_kriteria->fetch_assoc();
$id_krit = $row['id'];
$kategori = $row['kategori'];
$kriteria = $row['kriteria'];
$lowkrit = strtolower($kriteria);
$sub1 = $row['sub1'];
$sub2 = $row['sub2'];
$sub3 = $row['sub3'];
$sub4 = $row['sub4'];
$sub5 = $row['sub5'];
$batas1 = $row['batas1'];
$batas2 = $row['batas2'];
$batas3 = $row['batas3'];
$batas4 = $row['batas4'];
$batas5 = $row['batas5'];
if($sub3==""){$available_krit=2;}
elseif($sub4==""){$available_krit=3;}
elseif($sub5==""){$available_krit=4;}
else{$available_krit=5;}
?>
 <!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Sistem Pendukung Keputusan</title>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<script>
		function validateForm() {
			let nama = document.forms["form-kriteria"]["nama"].value;
			let sub1 = document.forms["form-kriteria"]["sub1"].value;
			let sub2 = document.forms["form-kriteria"]["sub2"].value;
			let sub3 = document.forms["form-kriteria"]["sub3"].value;
			let sub4 = document.forms["form-kriteria"]["sub4"].value;
			let sub5 = document.forms["form-kriteria"]["sub5"].value;
			if(nama.indexOf(' ') >= 0 || sub1.indexOf(' ') >= 0 || sub2.indexOf(' ') >= 0 || sub3.indexOf(' ') >= 0 || sub4.indexOf(' ') >= 0 || sub5.indexOf(' ') >= 0){
				alert("Nama kriteria dan sub-kriteria tidak boleh mengandung spasi, gunakan underscore ' _ ' sebagai pengganti.");
				return false;
			}
			if(nama.indexOf('&') >= 0 || sub1.indexOf('&') >= 0 || sub2.indexOf('&') >= 0 || sub3.indexOf('&') >= 0 || sub4.indexOf('&') >= 0 || sub5.indexOf('&') >= 0){
				alert("Nama kriteria dan sub-kriteria tidak boleh mengandung simbol '&'.");
				return false;
			}
		}
	</script>
</head>

<style type="text/css">
	#home{
		text-align: center;
		background-size: cover;
	}
	p{
		font-size: 20px;
	}
	
	input[type="reset"]{
	margin-bottom: 28px;
	width: 120px;
	height: 32px;
	background: #F44336;
	border: none;
	border-radius: 2px;
	color: #fff;
	font-family: sans-serif;
	text-transform: uppercase;
	transition: 0.2s ease;
	cursor: pointer;
	}
	input[type="submit"]{
	margin-bottom: 28px;
	width: 120px;
	height: 32px;
	background: #39f436;
	border: none;
	border-radius: 2px;
	color: #fff;
	font-family: sans-serif;
	text-transform: uppercase;
	transition: 0.2s ease;
	cursor: pointer;
	}
	font2{
		font-size: 17px;
		padding-left: 50px;
	}

	h1{
		text-shadow: 5px 2px blue;
	}
	a { color: inherit; }
	a:hover { color: inherit; } 

</style>
<?php
    $result = mysqli_query($conn, "SELECT DISTINCT warna_bg FROM setting_tampilan");
    $row = $result->fetch_row();
    $value = $row[0] ?? false;
?>
<body style="background: <?=$value?>;">
<?php
    $result = mysqli_query($conn, "SELECT DISTINCT link_gambar FROM setting_tampilan");
    $row = $result->fetch_row();
    $value = $row[0] ?? false;
?>
<div class="jumbotron" id='home' mb-0 style="background-image:url(<?=$value?>)">
    <div style="margin-top:60px;margin-bottom:20px;">
			<h1 class="text-light shadow-lg"><a href="../index.php">Sistem Pendukung Keputusan</a></h1>
			<?php
				$result = mysqli_query($conn, "SELECT DISTINCT nama_wilayah FROM setting_tampilan");
				$row = $result->fetch_row();
				$value = $row[0] ?? false;
			?>
			<p class="h3 text-light shadow-lg" style="text-shadow: 2px 2px red;"><?=$value?></p>
</div>
	</div>
  

  <nav class="navbar navbar-expand-md navbar-dark bg-dark mt-0 fixed-top">
    <div class="container">
    <a href="../index.php" class="navbar-brand">SPK Wisata</a>
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
        <div class="navbar-nav">
            <a href="#" class="nav-item nav-link active"></a>
            <a href="../index.php" class="nav-item nav-link">Sistem Rekomendasi</a>
            <?php
            if(isset($_SESSION['legitUser'])){
              echo '<a href="admin.php" class="nav-item nav-link">Pengaturan</a>';
            }
            ?> 
        </div>
        <?php
      if(isset($_SESSION['legitUser'])){
      
      echo '<div class="navbar-nav"><a href="../functions/logout.php" class="nav-item nav-link">Logout</a></div>';
      }else{
      
        echo '<div class="navbar-nav"><a href="login_form.html" class="nav-item nav-link">Login Admin</a></div>';
   
      }
      ?>   
    </div>
</div>
</nav>
	<div class='container mt-5'>
		<p align="center"><b>Edit Data Kriteria <?=$kriteria?></b></p>
		<a href="admin_page.php"><button type="button" class="btn btn-info btn-lg btn-block mt-4 mb-4">Kembali ke Pengaturan Kriteria</button></a>  

		<div class="tambah-lokasi mt-4">
			<form method='POST' action="../functions/edit_kriteria_process.php" name="form-kriteria" onsubmit="return validateForm()">
				<div class="form-row align-items-center">
					<input name="id_krit" type="text" value="<?=$id_krit?>" style="display:none;">
					<input name="name_krit" type="text" value="<?=$nama_kriteria?>" style="display:none;">
					<input name="kategori" type="text" value="<?=$kategori?>" style="display:none;">
				<div class="mt-3"> Jenis kriteria: </div>
					<div class="col-auto my-1 input-group">
						<select disabled name="kategorix" class="custom-select mr-sm-1" id="inlineFormCustomSelect" onChange="myFunction()" required>
							<option value="">Choose...</option>
						<?php
						if($kategori == "fuzzy"){ ?>
							<option value="fuzzy" selected>Kriteria Fuzzy</option>
							<option value="non_fuzzy">Kriteria Non-Fuzzy</option>
						<?php } else { ?>
							<option value="fuzzy">Kriteria Fuzzy</option>
							<option value="non_fuzzy" selected>Kriteria Non-Fuzzy</option>
						<?php } ?>	
						</select>
                    </div>
					<div class="mt-3"> Edit jumlah sub-kriteria yang akan digunakan: </div>
					<div class="col-auto my-1 input-group">
						<?php if($available_krit == 2){ ?>
							<select name="jumlah_sub" class="custom-select mr-sm-1" id="jumlah_subs" onChange="myFunction2()" required>
								<option class="numkrit" value="" hidden disabled></option>
								<option value="2" selected>2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
							</select>
							<?php } if($available_krit == 3){?>
							<select name="jumlah_sub" class="custom-select mr-sm-1" id="jumlah_subs" onChange="myFunction2()" required>
								<option class="numkrit" value="" hidden disabled></option>
								<option value="2">2</option>
								<option value="3" selected>3</option>
								<option value="4">4</option>
								<option value="5">5</option>
							</select>
							<?php } if($available_krit == 4) { ?>
							<select name="jumlah_sub" class="custom-select mr-sm-1" id="jumlah_subs" onChange="myFunction2()" required>
								<option class="numkrit" value="" hidden disabled></option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4"selected>4</option>
								<option value="5">5</option>
							</select>
							<?php } if($available_krit == 5) { ?>
							<select name="jumlah_sub" class="custom-select mr-sm-1" id="jumlah_subs" onChange="myFunction2()" required>
								<option class="numkrit" value="" hidden disabled></option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5" selected>5</option>
							</select>
							<?php } ?>
                    </div>
                    <div class="mt-3"> Edit nama kriteria dan sub-kriteria: <span style="color:red; font-size: 16px;" class="ml-2">*hanya menerima input a-z, A-Z, 0-9, _</span></div>
					<div class="col-auto my-1 input-group">
					<?php if($available_krit == 2){ ?>
                        <input type="text" value="<?=$kriteria?>" name="nama"  placeholder="Nama Kriteria" class="mr-2 mb-3" onChange="updateSubText()" pattern="[a-zA-Z_0-9]{1,50}" required>
                        <input type="text" value="<?=$sub1?>" id="sub1" name="sub1"  placeholder="Sub Kriteria 1" class="mr-2 mb-3" onChange="updateSubText()" pattern="[a-zA-Z_0-9]{1,30}" required>
                        <input type="text" value="<?=$sub2?>" id="sub2" name="sub2"  placeholder="Sub Kriteria 2" class="mr-2 mb-3" onChange="updateSubText()" pattern="[a-zA-Z_0-9]{1,30}" required>
						<input type="text" value="<?=$sub3?>" id="sub3" name="sub3"  placeholder="Sub Kriteria 3" class="mr-2 mb-3" onChange="updateSubText()" pattern="[a-zA-Z_0-9]{1,30}" style="display: none;">
						<input type="text" value="<?=$sub4?>" id="sub4" name="sub4"  placeholder="Sub Kriteria 4" class="mr-2 mb-3" onChange="updateSubText()" pattern="[a-zA-Z_0-9]{1,30}" style="display: none;">
						<input type="text" value="<?=$sub5?>" id="sub5" name="sub5"  placeholder="Sub Kriteria 5" class="mr-2 mb-3" onChange="updateSubText()" pattern="[a-zA-Z_0-9]{1,30}" style="display: none;">
							<?php } if($available_krit == 3){?>
						<input type="text" value="<?=$kriteria?>" name="nama"  placeholder="Nama Kriteria" class="mr-2 mb-3" onChange="updateSubText()" pattern="[a-zA-Z_0-9]{1,50}" required>
                        <input type="text" value="<?=$sub1?>" id="sub1" name="sub1"  placeholder="Sub Kriteria 1" class="mr-2 mb-3" onChange="updateSubText()" pattern="[a-zA-Z_0-9]{1,30}" required>
                        <input type="text" value="<?=$sub2?>" id="sub2" name="sub2"  placeholder="Sub Kriteria 2" class="mr-2 mb-3" onChange="updateSubText()" pattern="[a-zA-Z_0-9]{1,30}" required>
						<input type="text" value="<?=$sub3?>" id="sub3" name="sub3"  placeholder="Sub Kriteria 3" class="mr-2 mb-3" onChange="updateSubText()" pattern="[a-zA-Z_0-9]{1,30}" required>
						<input type="text" value="<?=$sub4?>" id="sub4" name="sub4"  placeholder="Sub Kriteria 4" class="mr-2 mb-3" onChange="updateSubText()" pattern="[a-zA-Z_0-9]{1,30}" style="display: none;">
						<input type="text" value="<?=$sub5?>" id="sub5" name="sub5"  placeholder="Sub Kriteria 5" class="mr-2 mb-3" onChange="updateSubText()" pattern="[a-zA-Z_0-9]{1,30}" style="display: none;">
							<?php } if($available_krit == 4) { ?>
						<input type="text" value="<?=$kriteria?>" name="nama"  placeholder="Nama Kriteria" class="mr-2 mb-3" onChange="updateSubText()" pattern="[a-zA-Z_0-9]{1,50}" required>
                        <input type="text" value="<?=$sub1?>" id="sub1" name="sub1"  placeholder="Sub Kriteria 1" class="mr-2 mb-3" onChange="updateSubText()" pattern="[a-zA-Z_0-9]{1,30}" required>
                        <input type="text" value="<?=$sub2?>" id="sub2" name="sub2"  placeholder="Sub Kriteria 2" class="mr-2 mb-3" onChange="updateSubText()" pattern="[a-zA-Z_0-9]{1,30}" required>
						<input type="text" value="<?=$sub3?>" id="sub3" name="sub3"  placeholder="Sub Kriteria 3" class="mr-2 mb-3" onChange="updateSubText()" pattern="[a-zA-Z_0-9]{1,30}" required>
						<input type="text" value="<?=$sub4?>" id="sub4" name="sub4"  placeholder="Sub Kriteria 4" class="mr-2 mb-3" onChange="updateSubText()" pattern="[a-zA-Z_0-9]{1,30}" required>
						<input type="text" value="<?=$sub5?>" id="sub5" name="sub5"  placeholder="Sub Kriteria 5" class="mr-2 mb-3" onChange="updateSubText()" pattern="[a-zA-Z_0-9]{1,30}" style="display: none;">
							<?php } if($available_krit == 5) { ?>
								<input type="text" value="<?=$kriteria?>" name="nama"  placeholder="Nama Kriteria" class="mr-2 mb-3" onChange="updateSubText()" pattern="[a-zA-Z_0-9]{1,50}" required>
                        <input type="text" value="<?=$sub1?>" id="sub1" name="sub1"  placeholder="Sub Kriteria 1" class="mr-2 mb-3" onChange="updateSubText()" pattern="[a-zA-Z_0-9]{1,30}" required>
                        <input type="text" value="<?=$sub2?>" id="sub2" name="sub2"  placeholder="Sub Kriteria 2" class="mr-2 mb-3" onChange="updateSubText()" pattern="[a-zA-Z_0-9]{1,30}" required>
						<input type="text" value="<?=$sub3?>" id="sub3" name="sub3"  placeholder="Sub Kriteria 3" class="mr-2 mb-3" onChange="updateSubText()" pattern="[a-zA-Z_0-9]{1,30}" required>
						<input type="text" value="<?=$sub4?>" id="sub4" name="sub4"  placeholder="Sub Kriteria 4" class="mr-2 mb-3" onChange="updateSubText()" pattern="[a-zA-Z_0-9]{1,30}" required>
						<input type="text" value="<?=$sub5?>" id="sub5" name="sub5"  placeholder="Sub Kriteria 5" class="mr-2 mb-3" onChange="updateSubText()" pattern="[a-zA-Z_0-9]{1,30}" required>
							<?php } ?>

                    </div>
					<?php if($kategori == "fuzzy") { ?>
					<div id="coba">
					<?php } else { ?>
						<div id="coba" style="display: none;">
					<?php } ?>
						<div class="mt-3"> Edit nilai batas:</div>
						<div class="col-auto my-1 input-group">
						<?php if($available_krit == 2){ ?>
							<input value="<?=$batas1?>" name="batas1" type="number" id="v1" placeholder="Batas 1" class="mr-2" required>
							<input value="<?=$batas2?>" name="batas2" type="number" id="v2" placeholder="Batas 2" class="mr-2" required>
							<input name="batas3" type="number" id="v3" placeholder="Batas 3" class="mr-2" style="display: none;"> 
							<input name="batas4" type="number" id="v4" placeholder="Batas 4" class="mr-2" style="display: none;"> 
							<input name="batas5" type="number" id="v5" placeholder="Batas 5" class="mr-2" style="display: none;">  
							<?php } if($available_krit == 3){?>
							<input value="<?=$batas1?>" name="batas1" type="number" id="v1" placeholder="Batas 1" class="mr-2" required>
							<input value="<?=$batas2?>" name="batas2" type="number" id="v2" placeholder="Batas 2" class="mr-2" required>
							<input value="<?=$batas3?>" name="batas3" type="number" id="v3" placeholder="Batas 3" class="mr-2" required"> 
							<input name="batas4" type="number" id="v4" placeholder="Batas 4" class="mr-2" style="display: none;"> 
							<input name="batas5" type="number" id="v5" placeholder="Batas 5" class="mr-2" style="display: none;">  
							<?php } if($available_krit == 4) { ?>
							<input value="<?=$batas1?>" name="batas1" type="number" id="v1" placeholder="Batas 1" class="mr-2" required>
							<input value="<?=$batas2?>" name="batas2" type="number" id="v2" placeholder="Batas 2" class="mr-2" required>
							<input value="<?=$batas3?>" name="batas3" type="number" id="v3" placeholder="Batas 3" class="mr-2" required> 
							<input value="<?=$batas4?>" name="batas4" type="number" id="v4" placeholder="Batas 4" class="mr-2" required> 
							<input name="batas5" type="number" id="v5" placeholder="Batas 5" class="mr-2" style="display: none;">  
							<?php } if($available_krit == 5) { ?>
							<input value="<?=$batas1?>" name="batas1" type="number" id="v1" placeholder="Batas 1" class="mr-2" required>
							<input value="<?=$batas2?>" name="batas2" type="number" id="v2" placeholder="Batas 2" class="mr-2" required>
							<input value="<?=$batas3?>" name="batas3" type="number" id="v3" placeholder="Batas 3" class="mr-2" required> 
							<input value="<?=$batas4?>" name="batas4" type="number" id="v4" placeholder="Batas 4" class="mr-2" required> 
							<input value="<?=$batas5?>" name="batas5" type="number" id="v5" placeholder="Batas 5" class="mr-2" required>  
							<?php } ?>            
						</div>
					</div>

                    <div class="mt-3"> Edit data kriteria untuk masing-masing data: </div>
                    <div class="col-auto my-1 input-group"> 
                    <?php if($kategori == "fuzzy") {?>
					<table class='table table-bordered mt-2' id="tabel_fuzzyx">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th class="label-kriteria">Data Kriteria</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                            $result = mysqli_query($conn,"SELECT * from tempat_wisata_tb");
                            $num = 1;
                            while($data = mysqli_fetch_array($result)):
                        ?>
                            <tr>
                                <th><?=$num;?></th>
                                <th><?=$data['obyek_wisata'];?></th>
                                <th><input value="<?=$data[$lowkrit];?>" name="datakriteria<?=$data['id'];?>" type="number" placeholder="Nilai Kriteria" class="datakriteria" required></th>
                            </tr>

                        <?php $num++; endwhile;?>

                        </tbody>
                    </table>
					<?php } else { ?>
					<table class='table table-bordered mt-2' id="tabel_nonx">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th class="label-kriteria">Data Kriteria</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                            $result = mysqli_query($conn,"SELECT * from tempat_wisata_tb");
                            $num = 1;
                            while($data = mysqli_fetch_array($result)):
                        ?>
                            <tr>
                                <th><?=$num;?></th>
                                <th><?=$data['obyek_wisata'];?></th>
								<th>
								<select name="datakritnon<?=$data['id'];?>" class="custom-select mr-sm-1 datakritnon" required>
									<option value="" class="s0">Choose...</option>
									<?php if($data[$lowkrit] == $sub1) { ?>
									<?php if($available_krit == 2) {?>
									<option value="sub1" class="s1" selected><?=$sub1?></option>
									<option value="sub2" class="s2"><?=$sub2?></option>
									<option value="sub3" class="s3" disabled><?=$sub3?></option>
									<option value="sub4" class="s4" disabled><?=$sub4?></option>
									<option value="sub5" class="s5" disabled><?=$sub5?></option>
									<?php } if($available_krit == 3){ ?>
									<option value="sub1" class="s1" selected><?=$sub1?></option>
									<option value="sub2" class="s2"><?=$sub2?></option>
									<option value="sub3" class="s3"><?=$sub3?></option>
									<option value="sub4" class="s4" disabled><?=$sub4?></option>
									<option value="sub5" class="s5" disabled><?=$sub5?></option>
									<?php } if ($available_krit == 4) { ?>
									<option value="sub1" class="s1" selected><?=$sub1?></option>
									<option value="sub2" class="s2"><?=$sub2?></option>
									<option value="sub3" class="s3"><?=$sub3?></option>
									<option value="sub4" class="s4"><?=$sub4?></option>
									<option value="sub5" class="s5" disabled><?=$sub5?></option>
									<?php } if($available_krit == 5) { ?>
									<option value="sub1" class="s1" selected><?=$sub1?></option>
									<option value="sub2" class="s2"><?=$sub2?></option>
									<option value="sub3" class="s3"><?=$sub3?></option>
									<option value="sub4" class="s4"><?=$sub4?></option>
									<option value="sub5" class="s5"><?=$sub5?></option>
									<?php } } ?>
									<?php if($data[$lowkrit] == $sub2) { ?>
									<?php if($available_krit == 2) {?>
									<option value="sub1" class="s1"><?=$sub1?></option>
									<option value="sub2" class="s2" selected><?=$sub2?></option>
									<option value="sub3" class="s3" disabled><?=$sub3?></option>
									<option value="sub4" class="s4" disabled><?=$sub4?></option>
									<option value="sub5" class="s5" disabled><?=$sub5?></option>
									<?php } if($available_krit == 3){ ?>
									<option value="sub1" class="s1"><?=$sub1?></option>
									<option value="sub2" class="s2" selected><?=$sub2?></option>
									<option value="sub3" class="s3"><?=$sub3?></option>
									<option value="sub4" class="s4" disabled><?=$sub4?></option>
									<option value="sub5" class="s5" disabled><?=$sub5?></option>
									<?php } if ($available_krit == 4) { ?>
									<option value="sub1" class="s1"><?=$sub1?></option>
									<option value="sub2" class="s2" selected><?=$sub2?></option>
									<option value="sub3" class="s3"><?=$sub3?></option>
									<option value="sub4" class="s4"><?=$sub4?></option>
									<option value="sub5" class="s5" disabled><?=$sub5?></option>
									<?php } if($available_krit == 5) { ?>
									<option value="sub1" class="s1"><?=$sub1?></option>
									<option value="sub2" class="s2" selected><?=$sub2?></option>
									<option value="sub3" class="s3"><?=$sub3?></option>
									<option value="sub4" class="s4"><?=$sub4?></option>
									<option value="sub5" class="s5"><?=$sub5?></option>
									<?php } } ?>
									<?php if($data[$lowkrit] == $sub3) { ?>
									<?php if($available_krit == 2) {?>
									<option value="sub1" class="s1"><?=$sub1?></option>
									<option value="sub2" class="s2"><?=$sub2?></option>
									<option value="sub3" class="s3" disabled><?=$sub3?></option>
									<option value="sub4" class="s4" disabled><?=$sub4?></option>
									<option value="sub5" class="s5" disabled><?=$sub5?></option>
									<?php } if($available_krit == 3){ ?>
									<option value="sub1" class="s1"><?=$sub1?></option>
									<option value="sub2" class="s2"><?=$sub2?></option>
									<option value="sub3" class="s3" selected><?=$sub3?></option>
									<option value="sub4" class="s4" disabled><?=$sub4?></option>
									<option value="sub5" class="s5" disabled><?=$sub5?></option>
									<?php } if ($available_krit == 4) { ?>
									<option value="sub1" class="s1"><?=$sub1?></option>
									<option value="sub2" class="s2"><?=$sub2?></option>
									<option value="sub3" class="s3"selected><?=$sub3?></option>
									<option value="sub4" class="s4"><?=$sub4?></option>
									<option value="sub5" class="s5" disabled><?=$sub5?></option>
									<?php } if($available_krit == 5) { ?>
									<option value="sub1" class="s1"><?=$sub1?></option>
									<option value="sub2" class="s2"><?=$sub2?></option>
									<option value="sub3" class="s3" selected><?=$sub3?></option>
									<option value="sub4" class="s4"><?=$sub4?></option>
									<option value="sub5" class="s5"><?=$sub5?></option>
									<?php } } ?>
									<?php if($data[$lowkrit] == $sub4) { ?>
									<?php if($available_krit == 2) {?>
									<option value="sub1" class="s1"><?=$sub1?></option>
									<option value="sub2" class="s2"><?=$sub2?></option>
									<option value="sub3" class="s3" disabled><?=$sub3?></option>
									<option value="sub4" class="s4" disabled><?=$sub4?></option>
									<option value="sub5" class="s5" disabled><?=$sub5?></option>
									<?php } if($available_krit == 3){ ?>
									<option value="sub1" class="s1"><?=$sub1?></option>
									<option value="sub2" class="s2"><?=$sub2?></option>
									<option value="sub3" class="s3"><?=$sub3?></option>
									<option value="sub4" class="s4" disabled><?=$sub4?></option>
									<option value="sub5" class="s5" disabled><?=$sub5?></option>
									<?php } if ($available_krit == 4) { ?>
									<option value="sub1" class="s1"><?=$sub1?></option>
									<option value="sub2" class="s2"><?=$sub2?></option>
									<option value="sub3" class="s3"><?=$sub3?></option>
									<option value="sub4" class="s4" selected><?=$sub4?></option>
									<option value="sub5" class="s5" disabled><?=$sub5?></option>
									<?php } if($available_krit == 5) { ?>
									<option value="sub1" class="s1"><?=$sub1?></option>
									<option value="sub2" class="s2"><?=$sub2?></option>
									<option value="sub3" class="s3"><?=$sub3?></option>
									<option value="sub4" class="s4" selected><?=$sub4?></option>
									<option value="sub5" class="s5"><?=$sub5?></option>
									<?php } } ?>
									<?php if($data[$lowkrit] == $sub5) { ?>
									<?php if($available_krit == 2) {?>
									<option value="sub1" class="s1"><?=$sub1?></option>
									<option value="sub2" class="s2"><?=$sub2?></option>
									<option value="sub3" class="s3" disabled><?=$sub3?></option>
									<option value="sub4" class="s4" disabled><?=$sub4?></option>
									<option value="sub5" class="s5" disabled><?=$sub5?></option>
									<?php } if($available_krit == 3){ ?>
									<option value="sub1" class="s1"><?=$sub1?></option>
									<option value="sub2" class="s2"><?=$sub2?></option>
									<option value="sub3" class="s3"><?=$sub3?></option>
									<option value="sub4" class="s4" disabled><?=$sub4?></option>
									<option value="sub5" class="s5" disabled><?=$sub5?></option>
									<?php } if ($available_krit == 4) { ?>
									<option value="sub1" class="s1"><?=$sub1?></option>
									<option value="sub2" class="s2"><?=$sub2?></option>
									<option value="sub3" class="s3"><?=$sub3?></option>
									<option value="sub4" class="s4"><?=$sub4?></option>
									<option value="sub5" class="s5" disabled><?=$sub5?></option>
									<?php } if($available_krit == 5) { ?>
									<option value="sub1" class="s1"><?=$sub1?></option>
									<option value="sub2" class="s2"><?=$sub2?></option>
									<option value="sub3" class="s3"><?=$sub3?></option>
									<option value="sub4" class="s4"><?=$sub4?></option>
									<option value="sub5" class="s5"selected><?=$sub5?></option>
									<?php } } ?>
								</select>
								</th>
							</tr>

                        <?php $num++; endwhile;?>

                        </tbody>
                    </table>
					<?php } ?>
                    </div>

                    <div class="col-12 my-1">
                        <button type="submit" class="btn btn-success btn-lg btn-block mt-4 mb-4" name="submit">Update Kriteria</button>
                    </div>
				</div>
			</form>
		</div>
	</div>

<!-- Footer -->
<footer class="bg-dark text-center text-white mt-5">
  <!-- Grid container -->
  <div class="container p-4">

    <!-- Section: Text -->
    <section class="m-3">
      <p>
        "Sistem Pendukung Keputusan Berbasis Web ini merupakan aplikasi web yang dapat membantu para pengguna dalam menentukan suatu keputusan dengan memberikan rekomendasi terbaik berdasarkan kriteria yang diinginkan."
      </p>
    </section>
    <!-- Section: Text -->

  </div>
  <!-- Grid container -->

  <!-- Copyright -->
  <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
    © 2021 Copyright:
    <a class="text-white" href="#">HDM-Vision - hudtakim@gmail.com</a>
  </div>
  <!-- Copyright -->
</footer>
<!-- Footer -->

</body>
</html>

<script>
	function updateSubText(){
		let s0 = document.querySelectorAll(".s0");
		var s1 = document.querySelectorAll(".s1");
		var s2 = document.querySelectorAll(".s2");
		var s3 = document.querySelectorAll(".s3");
		var s4 = document.querySelectorAll(".s4");
		var s5 = document.querySelectorAll(".s5");
		var label = document.querySelectorAll(".label-kriteria");
		let nama = document.forms["form-kriteria"]["nama"].value;
		let sub1 = document.forms["form-kriteria"]["sub1"].value;
		let sub2 = document.forms["form-kriteria"]["sub2"].value;
		let sub3 = document.forms["form-kriteria"]["sub3"].value;
		let sub4 = document.forms["form-kriteria"]["sub4"].value;
		let sub5 = document.forms["form-kriteria"]["sub5"].value;

		for (let i = 0; i < s0.length; i++){
			s1[i].innerHTML = sub1;
			s2[i].innerHTML = sub2;
			s3[i].innerHTML = sub3;
			s4[i].innerHTML = sub4;
			s5[i].innerHTML = sub5;
		}
		var v1 = document.getElementById("v1");
		var v2 = document.getElementById("v2");
		var v3 = document.getElementById("v3");
		var v4 = document.getElementById("v4");
		var v5 = document.getElementById("v5");

		label[0].innerHTML = "Data " + nama;
		label[1].innerHTML = "Data " + nama;
	}
	function myFunction2(){
		var select= document.getElementById("jumlah_subs");
		var v1 = document.getElementById("v1");
		var v2 = document.getElementById("v2");
		var v3 = document.getElementById("v3");
		var v4 = document.getElementById("v4");
		var v5 = document.getElementById("v5");

		var sub1 = document.getElementById("sub1");
		var sub2 = document.getElementById("sub2");
		var sub3 = document.getElementById("sub3");
		var sub4 = document.getElementById("sub4");
		var sub5 = document.getElementById("sub5");

		let s0 = document.querySelectorAll(".s0");
		var s1 = document.querySelectorAll(".s1");
		var s2 = document.querySelectorAll(".s2");
		var s3 = document.querySelectorAll(".s3");
		var s4 = document.querySelectorAll(".s4");
		var s5 = document.querySelectorAll(".s5");

		for(let x=0; x<s0.length; x++){
			s0[x].selected = true;
		}

		var kategori = document.getElementById("inlineFormCustomSelect");
		if(kategori.value == "non_fuzzy"){
			v1.required = false
			v2.required = false;
			v3.required = false;
			v4.required = false;
			v5.required = false;
			
			if(select.value == "2"){
				v2.style.display = "block";
				v3.style.display = "none";
				v4.style.display = "none";
				v5.style.display = "none";

				sub3.style.display = "none";
				sub4.style.display = "none";
				sub5.style.display = "none";
				sub2.required = true;
				sub3.required = false;
				sub4.required = false;
				sub5.required = false;
				sub3.value = "";
				sub4.value = "";
				sub5.value = "";

				for (let i = 0; i < s0.length; i++){
					s3[i].disabled = true;
					s4[i].disabled = true;
					s5[i].disabled = true;

					s3[i].hidden = true;
					s4[i].hidden = true;
					s5[i].hidden = true;
				}
		}if(select.value == "3"){
				v2.style.display = "block";
				v3.style.display = "block";
				v4.style.display = "none";
				v5.style.display = "none";

				sub2.style.display = "block";
				sub3.style.display = "block";
				sub4.style.display = "none";
				sub5.style.display = "none";
				sub2.required = true;
				sub3.required = true;
				sub4.required = false;
				sub5.required = false;
				sub4.value = "";
				sub5.value = "";

				for (let i = 0; i < s0.length; i++){
					s3[i].disabled = false;
					s4[i].disabled = true;
					s5[i].disabled = true;

					s3[i].hidden = false;
					s4[i].hidden = true;
					s5[i].hidden = true;
				}
		}
		if(select.value == "4"){
			v2.style.display = "block";
			v3.style.display = "block";
			v4.style.display = "block";
			v5.style.display = "none";

			sub2.style.display = "block";
			sub3.style.display = "block";
			sub4.style.display = "block";
			sub5.style.display = "none";
			sub2.required = true;
			sub3.required = true;
			sub4.required = true;
			sub5.required = false;
			sub5.value = "";

			for (let i = 0; i < s0.length; i++){
					s3[i].disabled = false;
					s4[i].disabled = false;
					s5[i].disabled = true;

					s3[i].hidden = false;
					s4[i].hidden = false;
					s5[i].hidden = true;
				}

		}if(select.value == "5"){
			v2.style.display = "block";
			v3.style.display = "block";
			v4.style.display = "block";
			v5.style.display = "block";

			sub2.style.display = "block";
			sub3.style.display = "block";
			sub4.style.display = "block";
			sub5.style.display = "block";
			sub2.required = true;
			sub3.required = true;
			sub4.required = true;
			sub5.required = true;
			for (let i = 0; i < s0.length; i++){
					s3[i].disabled = false;
					s4[i].disabled = false;
					s5[i].disabled = false;

					s3[i].hidden = false;
					s4[i].hidden = false;
					s5[i].hidden = false;
				}
		}
		}else{

		if(select.value == "2"){
			v2.style.display = "block";
				v3.style.display = "none";
				v4.style.display = "none";
				v5.style.display = "none";
				v2.required = true;
				v3.required = false;
				v4.required = false;
				v5.required = false;
				v3.value = "";
				v4.value = "";
				v5.value = "";

				sub3.style.display = "none";
				sub4.style.display = "none";
				sub5.style.display = "none";
				sub2.required = true;
				sub3.required = false;
				sub4.required = false;
				sub5.required = false;
				sub3.value = "";
				sub4.value = "";
				sub5.value = "";

				for (let i = 0; i < s0.length; i++){
					s3[i].disabled = true;
					s4[i].disabled = true;
					s5[i].disabled = true;

					s3[i].hidden = true;
					s4[i].hidden = true;
					s5[i].hidden = true;
				}
		}if(select.value == "3"){
				v2.style.display = "block";
				v3.style.display = "block";
				v4.style.display = "none";
				v5.style.display = "none";
				v2.required = true;
				v3.required = true;
				v4.required = false;
				v5.required = false;
				v4.value = "";
				v5.value = "";

				sub2.style.display = "block";
				sub3.style.display = "block";
				sub4.style.display = "none";
				sub5.style.display = "none";
				sub2.required = true;
				sub3.required = true;
				sub4.required = false;
				sub5.required = false;
				sub4.value = "";
				sub5.value = "";

				for (let i = 0; i < s0.length; i++){
					s3[i].disabled = false;
					s4[i].disabled = true;
					s5[i].disabled = true;

					s3[i].hidden = false;
					s4[i].hidden = true;
					s5[i].hidden = true;
				}
		}
		if(select.value == "4"){
			v2.style.display = "block";
			v3.style.display = "block";
			v4.style.display = "block";
			v5.style.display = "none";
			v2.required = true;
			v3.required = true;
			v4.required = true;
			v5.required = false;
			v5.value = "";

			sub2.style.display = "block";
			sub3.style.display = "block";
			sub4.style.display = "block";
			sub5.style.display = "none";
			sub2.required = true;
			sub3.required = true;
			sub4.required = true;
			sub5.required = false;
			sub5.value = "";

			for (let i = 0; i < s0.length; i++){
					s3[i].disabled = false;
					s4[i].disabled = false;
					s5[i].disabled = true;

					s3[i].hidden = false;
					s4[i].hidden = false;
					s5[i].hidden = true;
				}

		}if(select.value == "5"){
			v2.style.display = "block";
			v3.style.display = "block";
			v4.style.display = "block";
			v5.style.display = "block";
			v2.required = true;
			v3.required = true;
			v4.required = true;
			v5.required = true;

			sub2.style.display = "block";
			sub3.style.display = "block";
			sub4.style.display = "block";
			sub5.style.display = "block";
			sub2.required = true;
			sub3.required = true;
			sub4.required = true;
			sub5.required = true;
			for (let i = 0; i < s0.length; i++){
					s3[i].disabled = false;
					s4[i].disabled = false;
					s5[i].disabled = false;

					s3[i].hidden = false;
					s4[i].hidden = false;
					s5[i].hidden = false;
				}
		}
	}
	}
	function myFunction() {
		var x = document.getElementById("coba");
		var y = document.getElementById("inlineFormCustomSelect");
		var t1 = document.getElementById("tabel_fuzzy");
		var t2 = document.getElementById("tabel_non");
		var v1 = document.getElementById("v1");
		var v2 = document.getElementById("v2");
		var v3 = document.getElementById("v3");
		var v4 = document.getElementById("v4");
		var v5 = document.getElementById("v5");

		var input_fuzzy = document.querySelectorAll(".datakriteria");
		var input_nonfuzzy = document.querySelectorAll(".datakritnon");

		if(y.value == "fuzzy"){
			if (x.style.display === "none") {
				x.style.display = "block";
				v1.value = ""; v2.value = ""; v3.value = "";v4.value = "";v5.value = "";
				for (let i = 0; i < input_fuzzy.length; i++) {
					input_fuzzy[i].required = true;
					input_nonfuzzy[i].required = false;
				}
			} else {
				x.style.display = "block";
				v1.value = ""; v2.value = ""; v3.value = "";v4.value = "";v5.value = "";
				for (let i = 0; i < input_fuzzy.length; i++) {
					input_fuzzy[i].required = true;
					input_nonfuzzy[i].required = false;
				}
			}
		}else{
			if (x.style.display === "none") {
				x.style.display = "none";
				v1.value = 0; v2.value = 0; v3.value = 0;v4.value = 0;v5.value = 0;
				for (let i = 0; i < input_nonfuzzy.length; i++) {
					input_fuzzy[i].required = false;
					input_nonfuzzy[i].required = true;
				}
			} else {
				x.style.display = "none";
				v1.value = 0; v2.value = 0; v3.value = 0;v4.value = 0;v5.value = 0;
				for (let i = 0; i < input_nonfuzzy.length; i++) {
					input_fuzzy[i].required = false;
					input_nonfuzzy[i].required = true;
				}
			}
		}
		if(y.value == "fuzzy"){
			if (t1.style.display === "none") {
				t1.style.display = "table";
				t2.style.display = "none";
				v1.value = ""; v2.value = ""; v3.value = "";v4.value = "";v5.value = "";
			} else {
				t1.style.display = "table";
				t2.style.display = "none";
				v1.value = ""; v2.value = ""; v3.value = "";v4.value = "";v5.value = "";
			}
		}else{
			if (t2.style.display === "none") {
				t2.style.display = "table";
				t1.style.display = "none";
				v1.value = 0; v2.value = 0; v3.value = 0;v4.value = 0; v5.value = 0;
			} else {
				t2.style.display = "table";
				t1.style.display = "none";
				v1.value = 0; v2.value = 0; v3.value = 0;
			}
		}
	}
</script>					 