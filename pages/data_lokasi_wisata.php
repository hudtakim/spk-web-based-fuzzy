<?php 
session_start();
include "../functions/functions.php";

if($_SESSION['legitUser'] != 'qwerty'){
    die(header("location: 404.html"));
}

?>

<?php

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
	.container{
		overflow:auto;
	}
	table{
		font-size:12px;
	} 

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
    <a href="index.php" class="navbar-brand">SPK Wisata</a>
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
		<p align="center"><b>Pengaturan Data</b></p>
		<a href="admin.php"><button type="button" class="btn btn-info btn-lg btn-block mt-4 mb-4">Kembali ke Menu Utama</button></a>
        <message>
            Isi form berikut untuk menambah data.
        <message>

		<div class="tambah-lokasi mt-4">
			<form method='POST' action="../functions/tambah_lokasi.php">
				<div class="form-row align-items-center">
					<div class="col-auto my-1 input-group">
                        <input type="text" name="nama"  placeholder="Nama" class="mr-1 mt-3" required>
						<?php
							$daftar_kriteria = mysqli_query($conn,"SELECT * from daftar_kriteria_static WHERE (kategori = 'non_fuzzy')");
							while($data = mysqli_fetch_array($daftar_kriteria)):
						?>
						<select name="<?= strtolower($data['kriteria']) ?>" class=" mr-1 mt-3" id="inlineFormCustomSelect" required>
							<option value=""><?=$data['kriteria']?></option>
                            <option value="sub1"><?=$data['sub1']?></option>
                            <option value="sub2"><?=$data['sub2']?></option>
                            			
							<?php 
            if($data['sub3'] != ""){
          
          ?>
          <option value="sub3"><?=$data['sub3']?></option>
              <?php    
            }
          ?>
          <?php 
            if($data['sub4'] != ""){
          
          ?>
          <option value="sub4"><?=$data['sub4']?></option>
              <?php    
            }
          ?>
          <?php 
            if($data['sub5'] != ""){
          
          ?>
          <option value="sub5"><?=$data['sub5']?></option>
              <?php    
            }
          ?>
						</select>
						<?php endwhile;?>
						<?php
							$daftar_kriteria = mysqli_query($conn,"SELECT * from daftar_kriteria_static WHERE (kategori = 'fuzzy')");
							while($data = mysqli_fetch_array($daftar_kriteria)):
						?>
							<input name="<?= strtolower($data['kriteria']) ?>" type="number" placeholder="<?=$data['kriteria'];?>" class="mr-1 mt-3" required>
						<?php endwhile;?>
					</div>
                    <div class="col-12 my-1">
                        <button type="submit" class="btn btn-success btn-block float mt-3" name="submit">Tambah Data</button>
                    </div>
				</div>
			</form>
		</div>
		<?php 

		$result = mysqli_query($conn,"SELECT * from tempat_wisata_tb ORDER BY obyek_wisata");
		$jumlah_wisata = mysqli_num_rows($result);
		if($jumlah_wisata == 0){
			echo "<div class='m-5'>";
			echo "<h5>Belum ada data di database, silahkan tambahkan data.</h5>";
			echo "</div>";
		}else{

		?>
        <div class="mt-4">
			Berikut adalah data yang sudah terdaftar pada sistem:
        </div>

		<div class="data-lokasi mt-4">
            <table class='table table-bordered mt-4 mb-5'>
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
						<?php
							$daftar_kriteria = mysqli_query($conn,"SELECT * from daftar_kriteria_static");
							while($data = mysqli_fetch_array($daftar_kriteria)):
						?>
						<th><?=$data['kriteria'];?></th>
						<?php endwhile;?>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                <?php
                    $num = 1;
                    while($data = mysqli_fetch_array($result)):
                ?>
                    <tr>
                        <th><?=$num;?></th>
                        <th><?=$data['obyek_wisata'];?></th>
						<?php
							$daftar_kriteria = mysqli_query($conn,"SELECT * from daftar_kriteria_static");
							while($dakrit = mysqli_fetch_array($daftar_kriteria)):
						?>
						<th><?=$data[strtolower($dakrit['kriteria'])];?></th>
						<?php endwhile;?>
                        <th>
						<a href="edit_lokasi.php?id=<?php echo $data['id']; ?>"><button class="btn btn-primary btn-sm" style="width:100%">Edit</button></a>
						<a href="../functions/delete.php?id=<?php echo $data['id']; ?>&item=lokasi"><button class="btn btn-danger btn-sm mt-1" style="width:100%" onclick="return confirmAction('<?=$data['obyek_wisata'];?>')">Delete</button></a>
						</th>
					</tr>

                <?php $num++; endwhile; }?>

                </tbody>
            </table>
		</div>

	</div>
</body>
</html>

<script>
      // The function below will start the confirmation dialog
      function confirmAction(data) {
		var cek = document.getElementById("inlineFormCustomSelect");
        let confirmAction = confirm("Anda yakin ingin menghapus data " + data + "?");
        if (confirmAction) {
			 return true;
        } else {
			return false;
        }
      }
    </script>