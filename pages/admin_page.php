<?php 
session_start();
include "../functions/functions.php";

if($_SESSION['legitUser'] != 'qwerty'){
    die(header("location: 404.html"));
}

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
		font-size:14px;
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
			<h1 class="text-light shadow-lg"><a href="index.php">Sistem Pendukung Keputusan</a></h1>
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
		<p align="center"><b>Pengaturan Kriteria SPK</b></p>
		<a href="admin.php"><button type="button" class="btn btn-info btn-lg btn-block mt-4 mb-4">Kembali ke Menu Utama</button></a>
		<a href="tambah_kriteria.php"><button type="button" class="btn btn-info btn-lg btn-block mt-4 mb-4">Tambah Kriteria Baru</button></a>
		<message>
			Anda dapat menambah, mengaktifkan, edit, dan menghapus kriteria:
        </message>
		<div class="edit-kriteria mt-4">
			<form method='POST' action="../functions/process.php">
				<div class="form-row align-items-center">
					<div class="col-auto my-1 input-group">
						<select name='kriteria' class="custom-select mr-sm-1" id="inlineFormCustomSelect" onChange="myFunction()" required>
							<option value="">Choose...</option>
				<?php
						$daftar_kriteria = mysqli_query($conn,"SELECT * from daftar_kriteria_static ORDER BY kriteria");
							
						while($data = mysqli_fetch_array($daftar_kriteria)):
							$status = "false";
							$daftar_kriteria_aktif = mysqli_query($conn,"SELECT * from daftar_kriteria");
							while($data_aktif = mysqli_fetch_array($daftar_kriteria_aktif)):
								if($data['kriteria'] == $data_aktif['kriteria']){
									$status = "true";
								}
							endwhile;
							if($status == "true"){
				?>
								<option value="<?=$data['kriteria'];?>"><?=$data['kriteria'];?> (Aktif)</option>
				<?php       }else{
 				?>  			<option value="<?=$data['kriteria'];?>"><?=$data['kriteria'];?></option>
				<?php		}
						endwhile;
				?>
						</select>
						<button type="submit" class="btn btn-success float ml-2" name="submit">Aktifkan Kriteria</button>
						<a href="" id="linka"><button id="butt" disabled type="button" class="btn btn-primary float ml-2">Edit Kriteria</button></a>
						<button type="submit" class="btn btn-danger float ml-2" name="submit-del" onclick="return confirmAction()">Hapus Kriteria</button>
					</div>
				</div>
			</form>
		</div>

		<?php 
					$daftar_kriteria = mysqli_query($conn,"SELECT * from daftar_kriteria");
					$jumlah_kriteria = mysqli_num_rows($daftar_kriteria);
					if($jumlah_kriteria == 0){
						echo "<div class='m-5'>";
						echo "<h5>Belum ada kriteria yang aktif, silahkan pilih kriteria dan aktifkan agar SPK Wisata dapat digunakan oleh user.</h5>";
						echo "</div>";
					}else{
		?>

		<div class="daftar-kriteria mt-5 mb-5">
			<table class='table table-bordered'>
				<thead class="thead-dark">
					<tr>
						<th>No</th>
						<th>Kriteria</th>
						<th>Sub-kriteria 1</th>
						<th>Sub-kriteria 2</th>
						<th>Sub-kriteria 3</th>
						<th>Sub-kriteria 4</th>
						<th>Sub-kriteria 5</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>

				<?php
					$num = 1;
					while($data = mysqli_fetch_array($daftar_kriteria)):
				?>
				<tr>
					<th><?=$num;?></th>
					<th><?=$data['kriteria'];?></th>
					<th><?=$data['sub1'];?></th>
					<th><?=$data['sub2'];?></th>
					<th><?=$data['sub3'];?></th>
					<th><?=$data['sub4'];?></th>
					<th><?=$data['sub5'];?></th>
					<th><a href="../functions/delete.php?id=<?php echo $data['id']; ?>&item=kriteria"><button class="btn btn-danger">Non-aktifkan</button></a></th>
				</tr>
				<?php $num++; endwhile; }?>
				</tbody>
			</table>
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
      // The function below will start the confirmation dialog
      function confirmAction() {
		var cek = document.getElementById("inlineFormCustomSelect");
		if(cek.value == ""){
			return true;
		}
        let confirmAction = confirm("Anda yakin ingin menghapus kriteria " + cek.value + "?");
        if (confirmAction) {
			 return true;
        } else {
			return false;
        }
      }

	  function myFunction(){
		var select = document.getElementById("inlineFormCustomSelect");
		var a = document.getElementById("linka");
		var butt = document.getElementById("butt");
		if(butt.disabled = true){
			butt.disabled = false;
		}
		if(select.value == ""){
			butt.disabled = true;
		}
		a.href= "edit.php?nama_krit=" + select.value;
	  }
</script>