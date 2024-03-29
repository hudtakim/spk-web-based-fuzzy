<?php 
session_start();
include "functions/functions.php";
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
  

  <nav class="navbar navbar-expand-md navbar-dark bg-dark mt-0 fixed-top ">
    <div class="container">
    <a href="index.php" class="navbar-brand">SPK Wisata</a>
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
        <div class="navbar-nav">
            <a href="#" class="nav-item nav-link active"></a>
            <a href="index.php" class="nav-item nav-link">Sistem Rekomendasi</a>
            <?php
            if(isset($_SESSION['legitUser'])){
              echo '<a href="pages/admin.php" class="nav-item nav-link">Pengaturan</a>';
            }
            ?> 
        </div>
        <?php
      if(isset($_SESSION['legitUser'])){
      
      echo '<div class="navbar-nav"><a href="functions/logout.php" class="nav-item nav-link">Logout</a></div>';
      }else{
      
        echo '<div class="navbar-nav"><a href="pages/login_form.html" class="nav-item nav-link">Login Admin</a></div>';
   
      }
      ?>   
    </div>
</div>
</nav>


	<div class='container mt-5'>
    <?php
      $krit_aktif = mysqli_query($conn,"SELECT * from daftar_kriteria");
      $baris=mysqli_num_rows($krit_aktif);
      if($baris == 0){
        echo "<p align='center'><b>Mohon maaf, tidak ada kriteria SPK yang aktif, silahkan hubungi admin.</b></p>";
      }else{
        echo "<p align='center'><b>Silahkan Pilih Kriteria yang Anda Inginkan</b></p>";
    ?>
		<form class="mb-5" method='GET' action="#" onsubmit="myJsFunction();return false">
			<div class="form-row align-items-center">
			<?php
					$daftar_kriteria = mysqli_query($conn,"SELECT * from daftar_kriteria");
					$num = 1;
					while($data = mysqli_fetch_array($daftar_kriteria)):
				?>
				<div class="my-2 input-group batesin"  id="krit<?=$num?>">          
					<select name='<?=strtolower($data['kriteria']);?>' class="form-control custom-select mr-2" id="sel<?=$num?>" required>
						<option value="">--- Pilih Kriteria <?=$data['kriteria'];?> ---</option>
            <option class="inputan" value="<?=strtolower($data['sub1']);?>"><?=$data['sub1'];?></option>
						<option class="inputan" value="<?=strtolower($data['sub2']);?>"><?=$data['sub2'];?></option>
          <?php 
            if($data['sub3'] != ""){
          
          ?>
          <option class="inputan" value="<?=strtolower($data['sub3']);?>"><?=$data['sub3'];?></option>
              <?php    
            }
          ?>
          <?php 
            if($data['sub4'] != ""){
          
          ?>
          <option class="inputan" value="<?=strtolower($data['sub4']);?>"><?=$data['sub4'];?></option>
              <?php    
            }
          ?>
          <?php 
            if($data['sub5'] != ""){
          
          ?>
          <option class="inputan" value="<?=strtolower($data['sub5']);?>"><?=$data['sub5'];?></option>
              <?php    
            }
          ?>
					</select>
          <button id="btn<?=$num?>" type="button" class="btn btn-danger float ml-2" onclick="delkrit(<?=$num?>)">X</button>
				</div>
        
			<?php $num++; endwhile;?>
			</div>
			<!--	<button type="submit" name='submit' class="btn btn-primary btn-lg btn-block mt-4 mb-4" value='and'>Submit - Logika AND</button> -->
			<button type="submit" name='submit' class="btn btn-primary btn-lg btn-block mt-4 mb-5" value='or'>Dapatkan Rekomendasi</button>
		</form>

		<?php
      }
			if(isset($_GET['submit'])){
			  $submit = $_GET['submit'];
        $daftar_wisata = mysqli_query($conn,"SELECT * from tempat_wisata_tb");
        $jumlah_wisata = mysqli_num_rows($daftar_wisata);
        if($jumlah_wisata == 0){
          echo "<div class='m-5'>";
          echo "<h5>Belum ada Data lokasi wisata di database, silahkan menghubungi admin.</h5>";
          echo "</div>";
        }
        else{

        $daftar_kriteria = mysqli_query($conn,"SELECT * from daftar_kriteria");
				$list_kriteria = array();
        $list_kriteria_b = array();
				while($data = mysqli_fetch_array($daftar_kriteria)):
            array_push($list_kriteria, strtolower($data['kriteria']));
            array_push($list_kriteria_b, strtolower($data['kriteria']));
            
        endwhile;
        $resultxx = mysqli_query($conn,"SELECT * from input_user_tb");
        $rowcountxx=mysqli_num_rows($resultxx);
        if($rowcountxx == 0){
        $inputUser = array();
        foreach ($list_kriteria_b as &$value) {
          $vcil = strtolower($value);
          if($_GET[$vcil] != ""){
            $ada = $value;
            array_push($inputUser, $_GET[$value]);
            $result = mysqli_query($conn, "SELECT * FROM daftar_kriteria WHERE (kriteria='$ada')");
            $row = $result->fetch_assoc();
            $kriteria = $row['kriteria'];
            $sub1 = $row['sub1'];
            $sub2 = $row['sub2'];
            $sub3 = $row['sub3'];
            $sub4 = $row['sub4'];
            $sub5 = $row['sub5'];
            $sukses = mysqli_query($conn, "INSERT INTO input_user_tb(kriteria, sub1, sub2, sub3, sub4, sub5) 
                    VALUES('$kriteria','$sub1', '$sub2', '$sub3','$sub4','$sub5')");
          }
        }
        
        echo "<br>Pilihan anda:";
        $it=0;
        $daftar_kriteria = mysqli_query($conn,"SELECT * from input_user_tb");
        while($data = mysqli_fetch_array($daftar_kriteria)):
          $str=" -> ";
          $str.=$data['kriteria'];
          $str.=": " ;
          echo $str; echo $inputUser[$it];
          $it++;
        endwhile;
        echo "<br>";
		?>
		
				<?php
           $daftar_kriteria = mysqli_query($conn,"SELECT * from input_user_tb");
           $thekrit5 = array();
           $array_bobot = array();
           $it=0;
           while($data = mysqli_fetch_array($daftar_kriteria)):
             $krit = strtolower($data['kriteria']);
             array_push($thekrit5, $krit);
             $tname = "fuzzy_";
             $tname .= $krit;
             $sub1 = strtolower($data['sub1']); $sub2 = strtolower($data['sub2']); $sub3 = strtolower($data['sub3']);$sub4 = strtolower($data['sub4']);$sub5 = strtolower($data['sub5']);
           
             if($inputUser[$it] == $sub1){
               $bobot = mysqli_query($conn,"SELECT {$sub1} from {$tname}");
               array_push($array_bobot, $bobot);
             }else if($inputUser[$it] == $sub2){
               $bobot = mysqli_query($conn,"SELECT {$sub2} from {$tname}");
               array_push($array_bobot, $bobot);
             }else if($inputUser[$it] == $sub3){
               $bobot = mysqli_query($conn,"SELECT {$sub3} from {$tname}");
               array_push($array_bobot, $bobot);
             }else if($inputUser[$it] == $sub4){
              $bobot = mysqli_query($conn,"SELECT {$sub4} from {$tname}");
              array_push($array_bobot, $bobot);
            }else if($inputUser[$it] == $sub5){
              $bobot = mysqli_query($conn,"SELECT {$sub5} from {$tname}");
              array_push($array_bobot, $bobot);
            }
             if(!$bobot){
              $del = mysqli_query($conn,"DELETE FROM input_user_tb");
              if($del) {mysqli_close($conn);}
              echo "<script>alert('Terjadi masalah pada data input. Silahkan coba lagi.')</script>";
              header('Location: index.php'); 
             }else{
              $it++;
             }
             
           endwhile;
          

          $result = mysqli_query($conn,"SELECT * from tempat_wisata_tb");
          $rowcount=mysqli_num_rows($result);
          $result2 = mysqli_query($conn,"SELECT * from input_user_tb");
          $rowcount2=mysqli_num_rows($result2);
					
          function get_arrbot($list_arrbot, $rowcount){
            $temp_array = array();
            if($list_arrbot != "null"){
              $arbot = mysqli_fetch_all($list_arrbot);
              foreach ($arbot as &$value){
                array_push($temp_array, $value[0]);
              }
            }else{
              for ($x = 0; $x < $rowcount; $x++){
                array_push($temp_array, 1);
              }
            }
            return $temp_array;
          }
          
          $temp_array = array();

          $it=0;
          $arrofarrbot = array();
          $daftar_kriteria = mysqli_query($conn,"SELECT * from input_user_tb");
          while($data = mysqli_fetch_array($daftar_kriteria)):        
            $arbot = get_arrbot($array_bobot[$it], $rowcount);
            array_push($arrofarrbot, $arbot);
            $it++;
          endwhile;
					
/*					$fire_strength = array();
					$it2 = 0;
          for ($x = 0; $x < $rowcount; $x++){
            $it1 = 0;
            if($submit == 'and'){$value = 1;} else{$value = 0;}
            for ($y = 0; $y < $rowcount2; $y++){
              if($submit == 'and'){
                $value = $value * $arrofarrbot[$it1][$it2];
              }else{
                $value = $value + $arrofarrbot[$it1][$it2];
              }
              $it1++;
            }
						$it2++;
            if($submit == 'or'){$value = $value/$rowcount2;}
            array_push($fire_strength, $value);
          } */
          $status = "pakai_and";
          $fire_strength = array();
					$it2 = 0;
          for ($x = 0; $x < $rowcount; $x++){
            $it1 = 0;
            $value=1;
            for ($y = 0; $y < $rowcount2; $y++){

              $value = $value * $arrofarrbot[$it1][$it2];
              
              $it1++;
            }
						$it2++;
            
            array_push($fire_strength, $value);
          }

          if(array_sum($fire_strength) == 0){
              $status = "pakai_or";
              $fire_strength = array();
              $it2 = 0;
              for ($x = 0; $x < $rowcount; $x++){
                $it1 = 0;
                $value=0;
                for ($y = 0; $y < $rowcount2; $y++){
                  $value = $value + $arrofarrbot[$it1][$it2];
                  $it1++;
                }
                $it2++;
                if($submit == 'or'){$value = $value/$rowcount2;}
                array_push($fire_strength, $value);
              }
          }
					
					
					if(array_sum($fire_strength) == 0){
						echo "<br><h5 class='mb-5 pb-5'>TIDAK DITEMUKAN REKOMENDASI YANG SESUAI DENGAN KRITERIA YANG ANDA PILIH</h5>";
            $del = mysqli_query($conn,"DELETE FROM input_user_tb");
            if($del) {mysqli_close($conn);}
            else{
              echo "Error pada database";
            }

					}else{ 
            if($status == "pakai_and"){  
          ?>
          <h5 class="mt-3">Berikut adalah rekomendasi yang memenuhi kriteria di atas:</h5>
          <?php } else { ?>
          <h5 class="mt-3">Tidak ditemukan rekomendasi yang memenuhi seluruh kriteria di atas, berikut hasil yang paling mendekati:</h5>
          <?php } ?>
            <table class='table table-bordered'>
              <thead class="thead-dark">
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <?php
                    $daftar_kriteria = mysqli_query($conn,"SELECT * from input_user_tb");
                    while($data = mysqli_fetch_array($daftar_kriteria)):
                  ?>
                    <th><?=$data['kriteria'];?></th>
                  <?php endwhile;?>
                  <th>Fire Strength</th>
                </tr>
              </thead>
            <tbody>
          
          <?php
          
          
          $newliskrit = array(); $new_arrofarrbot = array();
          $it=0;
          foreach ($thekrit5 as &$valkrit){
            array_push($newliskrit, $valkrit);
            array_push($new_arrofarrbot,$arrofarrbot[$it]);
            $it++; 
          }

          if($rowcount2 == 1){
            //create rekomendasi_tb untuk menampung yg direkomendasikan
          $result_rekom = mysqli_query($conn, "CREATE TABLE rekomendasi_tb(
            id INT NOT NULL AUTO_INCREMENT,
            obyek_wisata VARCHAR(30) NOT NULL,
            {$newliskrit[0]} varchar(20) NOT NULL,
            fire_strength float(20) NOT NULL,
            PRIMARY KEY ( id )
         )");
          //create penghitungan_bobot_tb untuk menampung bobot2 rekomendasi
          $result_bot = mysqli_query($conn, "CREATE TABLE penghitungan_bobot_tb(
            id INT NOT NULL AUTO_INCREMENT,
            obyek_wisata VARCHAR(30) NOT NULL,
            {$newliskrit[0]} float(20) NOT NULL,
            fire_strength float(20) NOT NULL,
            PRIMARY KEY ( id )
          )");
          }elseif($rowcount2 == 2){
                        //create rekomendasi_tb untuk menampung yg direkomendasikan
          $result_rekom = mysqli_query($conn, "CREATE TABLE rekomendasi_tb(
            id INT NOT NULL AUTO_INCREMENT,
            obyek_wisata VARCHAR(30) NOT NULL,
            {$newliskrit[0]} varchar(20) NOT NULL,
            {$newliskrit[1]} varchar(20) NOT NULL,
            fire_strength float(20) NOT NULL,
            PRIMARY KEY ( id )
         )");
          //create penghitungan_bobot_tb untuk menampung bobot2 rekomendasi
          $result_bot = mysqli_query($conn, "CREATE TABLE penghitungan_bobot_tb(
            id INT NOT NULL AUTO_INCREMENT,
            obyek_wisata VARCHAR(30) NOT NULL,
            {$newliskrit[0]} float(20) NOT NULL,
            {$newliskrit[1]} float(20) NOT NULL,
            fire_strength float(20) NOT NULL,
            PRIMARY KEY ( id )
          )");
          }elseif($rowcount2 == 3){
            //create rekomendasi_tb untuk menampung yg direkomendasikan
            $result_rekom = mysqli_query($conn, "CREATE TABLE rekomendasi_tb(
            id INT NOT NULL AUTO_INCREMENT,
            obyek_wisata VARCHAR(30) NOT NULL,
            {$newliskrit[0]} varchar(20) NOT NULL,
            {$newliskrit[1]} varchar(20) NOT NULL,
            {$newliskrit[2]} varchar(20) NOT NULL,
            fire_strength float(20) NOT NULL,
            PRIMARY KEY ( id )
            )");

            //create penghitungan_bobot_tb untuk menampung bobot2 rekomendasi
            $result_bot = mysqli_query($conn, "CREATE TABLE penghitungan_bobot_tb(
            id INT NOT NULL AUTO_INCREMENT,
            obyek_wisata VARCHAR(30) NOT NULL,
            {$newliskrit[0]} float(20) NOT NULL,
            {$newliskrit[1]} float(20) NOT NULL,
            {$newliskrit[2]} float(20) NOT NULL,
            fire_strength float(20) NOT NULL,
            PRIMARY KEY ( id )
            )");

          }elseif($rowcount2 == 4){
            //create rekomendasi_tb untuk menampung yg direkomendasikan
            $result_rekom = mysqli_query($conn, "CREATE TABLE rekomendasi_tb(
            id INT NOT NULL AUTO_INCREMENT,
            obyek_wisata VARCHAR(30) NOT NULL,
            {$newliskrit[0]} varchar(20) NOT NULL,
            {$newliskrit[1]} varchar(20) NOT NULL,
            {$newliskrit[2]} varchar(20) NOT NULL,
            {$newliskrit[3]} varchar(20) NOT NULL,
            fire_strength float(20) NOT NULL,
            PRIMARY KEY ( id )
            )");
            //create penghitungan_bobot_tb untuk menampung bobot2 rekomendasi
            $result_bot = mysqli_query($conn, "CREATE TABLE penghitungan_bobot_tb(
            id INT NOT NULL AUTO_INCREMENT,
            obyek_wisata VARCHAR(30) NOT NULL,
            {$newliskrit[0]} float(20) NOT NULL,
            {$newliskrit[1]} float(20) NOT NULL,
            {$newliskrit[2]} float(20) NOT NULL,
            {$newliskrit[3]} float(20) NOT NULL,
            fire_strength float(20) NOT NULL,
            PRIMARY KEY ( id )
            )");
          }
          elseif($rowcount2 == 5){
            //create rekomendasi_tb untuk menampung yg direkomendasikan
            $result_rekom = mysqli_query($conn, "CREATE TABLE rekomendasi_tb(
            id INT NOT NULL AUTO_INCREMENT,
            obyek_wisata VARCHAR(30) NOT NULL,
            {$newliskrit[0]} varchar(20) NOT NULL,
            {$newliskrit[1]} varchar(20) NOT NULL,
            {$newliskrit[2]} varchar(20) NOT NULL,
            {$newliskrit[3]} varchar(20) NOT NULL,
            {$newliskrit[4]} varchar(20) NOT NULL,
            fire_strength float(20) NOT NULL,
            PRIMARY KEY ( id )
            )");
            //create penghitungan_bobot_tb untuk menampung bobot2 rekomendasi
            $result_bot = mysqli_query($conn, "CREATE TABLE penghitungan_bobot_tb(
            id INT NOT NULL AUTO_INCREMENT,
            obyek_wisata VARCHAR(30) NOT NULL,
            {$newliskrit[0]} float(20) NOT NULL,
            {$newliskrit[1]} float(20) NOT NULL,
            {$newliskrit[2]} float(20) NOT NULL,
            {$newliskrit[3]} float(20) NOT NULL,
            {$newliskrit[4]} float(20) NOT NULL,
            fire_strength float(20) NOT NULL,
            PRIMARY KEY ( id )
            )");
          }elseif($rowcount2 == 6){
            //create rekomendasi_tb untuk menampung yg direkomendasikan
            $result_rekom = mysqli_query($conn, "CREATE TABLE rekomendasi_tb(
            id INT NOT NULL AUTO_INCREMENT,
            obyek_wisata VARCHAR(30) NOT NULL,
            {$newliskrit[0]} varchar(20) NOT NULL,
            {$newliskrit[1]} varchar(20) NOT NULL,
            {$newliskrit[2]} varchar(20) NOT NULL,
            {$newliskrit[3]} varchar(20) NOT NULL,
            {$newliskrit[4]} varchar(20) NOT NULL,
            {$newliskrit[5]} varchar(20) NOT NULL,
            fire_strength float(20) NOT NULL,
            PRIMARY KEY ( id )
            )");
            //create penghitungan_bobot_tb untuk menampung bobot2 rekomendasi
            $result_bot = mysqli_query($conn, "CREATE TABLE penghitungan_bobot_tb(
            id INT NOT NULL AUTO_INCREMENT,
            obyek_wisata VARCHAR(30) NOT NULL,
            {$newliskrit[0]} float(20) NOT NULL,
            {$newliskrit[1]} float(20) NOT NULL,
            {$newliskrit[2]} float(20) NOT NULL,
            {$newliskrit[3]} float(20) NOT NULL,
            {$newliskrit[4]} float(20) NOT NULL,
            {$newliskrit[5]} float(20) NOT NULL,
            fire_strength float(20) NOT NULL,
            PRIMARY KEY ( id )
            )");
          }
          else{
            echo "<h1>Terdapat masalah pada data kriteria</h1>";
          }

          if($result_bot && $result_rekom){

					$temp = array();
					$idx = 1;
          $arrofid = array();
          $daftar_id = mysqli_query($conn,"SELECT * from tempat_wisata_tb");
           while($data = mysqli_fetch_array($daftar_id)):
              array_push($arrofid, $data['id']);
           endwhile;

					foreach ($fire_strength as &$value) {
						if($value > 0){
              $inwis = $idx -1;
							$index_wisata = $idx;
							$get_wisata_query = mysqli_query($conn,"SELECT * from tempat_wisata_tb WHERE (id = '$arrofid[$inwis]')");
							while($data = mysqli_fetch_array($get_wisata_query)):

                if($rowcount2==1){
                  $ob_wis = $data['obyek_wisata'];
                  $krit1 = $data[$newliskrit[0]];
                  $it = $idx-1;
								  $fs  = $fire_strength[$it];
                  $bk1 = $new_arrofarrbot[0][$it];

                  mysqli_query($conn, "INSERT INTO rekomendasi_tb(obyek_wisata, {$newliskrit[0]}, fire_strength) 
													VALUES('$ob_wis', '$krit1', '$fs')");
								  mysqli_query($conn, "INSERT INTO penghitungan_bobot_tb(obyek_wisata, {$newliskrit[0]}, fire_strength) 
													VALUES('$ob_wis', '$bk1', '$fs')");
                }elseif($rowcount2==2){
                  $ob_wis = $data['obyek_wisata'];
                  $krit1 = $data[$newliskrit[0]];
                  $krit2 = $data[$newliskrit[1]];
                  $it = $idx-1;
								  $fs  = $fire_strength[$it];
                  $bk1 = $new_arrofarrbot[0][$it];
                  $bk2 = $new_arrofarrbot[1][$it];

                  mysqli_query($conn, "INSERT INTO rekomendasi_tb(obyek_wisata, {$newliskrit[0]}, {$newliskrit[1]}, fire_strength) 
                  VALUES('$ob_wis', '$krit1', '$krit2', '$fs')");
                  mysqli_query($conn, "INSERT INTO penghitungan_bobot_tb(obyek_wisata, {$newliskrit[0]}, {$newliskrit[1]}, fire_strength) 
                  VALUES('$ob_wis', '$bk1', '$bk2','$fs')");
                }elseif($rowcount2==3){
                  $ob_wis = $data['obyek_wisata'];
                  $krit1 = $data[$newliskrit[0]];
                  $krit2 = $data[$newliskrit[1]];
                  $krit3 = $data[$newliskrit[2]];
                  $it = $idx-1;
								  $fs  = $fire_strength[$it];
                  $bk1 = $new_arrofarrbot[0][$it];
                  $bk2 = $new_arrofarrbot[1][$it];
                  $bk3 = $new_arrofarrbot[2][$it];
                  
                  $result1 = mysqli_query($conn, "INSERT INTO rekomendasi_tb(obyek_wisata, {$newliskrit[0]}, {$newliskrit[1]}, {$newliskrit[2]}, fire_strength) 
                  VALUES('$ob_wis', '$krit1', '$krit2','$krit3', '$fs')");
                  $result2 = mysqli_query($conn, "INSERT INTO penghitungan_bobot_tb(obyek_wisata, {$newliskrit[0]}, {$newliskrit[1]}, {$newliskrit[2]}, fire_strength) 
                  VALUES('$ob_wis', '$bk1', '$bk2','$bk3','$fs')");

                  

                }elseif($rowcount2==4){
                  $ob_wis = $data['obyek_wisata'];
                  $krit1 = $data[$newliskrit[0]];
                  $krit2 = $data[$newliskrit[1]];
                  $krit3 = $data[$newliskrit[2]];
                  $krit4 = $data[$newliskrit[3]];
                  $it = $idx-1;
								  $fs  = $fire_strength[$it];
                  $bk1 = $new_arrofarrbot[0][$it];
                  $bk2 = $new_arrofarrbot[1][$it];
                  $bk3 = $new_arrofarrbot[2][$it];
                  $bk4 = $new_arrofarrbot[3][$it];

                  mysqli_query($conn, "INSERT INTO rekomendasi_tb(obyek_wisata, {$newliskrit[0]}, {$newliskrit[1]},{$newliskrit[2]}, {$newliskrit[3]}, fire_strength) 
                  VALUES('$ob_wis', '$krit1', '$krit2', '$krit3', '$krit4', '$fs')");
                  mysqli_query($conn, "INSERT INTO penghitungan_bobot_tb(obyek_wisata, {$newliskrit[0]}, {$newliskrit[1]},{$newliskrit[2]}, {$newliskrit[3]}, fire_strength) 
                  VALUES('$ob_wis', '$bk1', '$bk2','$bk3','$bk4','$fs')");
                }elseif($rowcount2==5){
                  $ob_wis = $data['obyek_wisata'];
                  $krit1 = $data[$newliskrit[0]];
                  $krit2 = $data[$newliskrit[1]];
                  $krit3 = $data[$newliskrit[2]];
                  $krit4 = $data[$newliskrit[3]];
                  $krit5 = $data[$newliskrit[4]];
                  $it = $idx-1;
								  $fs  = $fire_strength[$it];
                  $bk1 = $new_arrofarrbot[0][$it];
                  $bk2 = $new_arrofarrbot[1][$it];
                  $bk3 = $new_arrofarrbot[2][$it];
                  $bk4 = $new_arrofarrbot[3][$it];
                  $bk5 = $new_arrofarrbot[4][$it];

                  mysqli_query($conn, "INSERT INTO rekomendasi_tb(obyek_wisata, {$newliskrit[0]}, {$newliskrit[1]},{$newliskrit[2]}, {$newliskrit[3]},{$newliskrit[4]}, fire_strength) 
                  VALUES('$ob_wis', '$krit1', '$krit2', '$krit3', '$krit4','$krit5', '$fs')");
                  mysqli_query($conn, "INSERT INTO penghitungan_bobot_tb(obyek_wisata, {$newliskrit[0]}, {$newliskrit[1]},{$newliskrit[2]}, {$newliskrit[3]},{$newliskrit[4]}, fire_strength) 
                  VALUES('$ob_wis', '$bk1', '$bk2','$bk3','$bk4','$bk5','$fs')");
                }elseif($rowcount2==6){
                  $ob_wis = $data['obyek_wisata'];
                  $krit1 = $data[$newliskrit[0]];
                  $krit2 = $data[$newliskrit[1]];
                  $krit3 = $data[$newliskrit[2]];
                  $krit4 = $data[$newliskrit[3]];
                  $krit5 = $data[$newliskrit[4]];
                  $krit6 = $data[$newliskrit[5]];
                  $it = $idx-1;
								  $fs  = $fire_strength[$it];
                  $bk1 = $new_arrofarrbot[0][$it];
                  $bk2 = $new_arrofarrbot[1][$it];
                  $bk3 = $new_arrofarrbot[2][$it];
                  $bk4 = $new_arrofarrbot[3][$it];
                  $bk5 = $new_arrofarrbot[4][$it];
                  $bk6 = $new_arrofarrbot[5][$it];

                  mysqli_query($conn, "INSERT INTO rekomendasi_tb(obyek_wisata, {$newliskrit[0]}, {$newliskrit[1]},{$newliskrit[2]}, {$newliskrit[3]},{$newliskrit[4]}, {$newliskrit[5]}, fire_strength) 
                  VALUES('$ob_wis', '$krit1', '$krit2', '$krit3', '$krit4','$krit5','$krit6', '$fs')");
                  mysqli_query($conn, "INSERT INTO penghitungan_bobot_tb(obyek_wisata, {$newliskrit[0]}, {$newliskrit[1]},{$newliskrit[2]}, {$newliskrit[3]},{$newliskrit[4]}, {$newliskrit[5]}, fire_strength) 
                  VALUES('$ob_wis', '$bk1', '$bk2','$bk3','$bk4','$bk5','$bk6','$fs')");
                }
                else{
                  echo "<h1>Terdapat masalah pada data kriteria</h1>";
                }
	
							endwhile;
						} $idx++;
					}
					$get_rekomendasi_query = mysqli_query($conn,"SELECT * from rekomendasi_tb ORDER BY fire_strength DESC LIMIT 10");
					$num = 1;
					while($data = mysqli_fetch_array($get_rekomendasi_query)):
            if($_GET['submit'] == 'and'){
   
            if($data['fire_strength'] == 1){
          ?>
          	<tr style="background: #fc9803;">
							<th><?=$num;?></th>
							<th><?=$data['obyek_wisata'];?></th>
							<?php
							$daftar_kriteria = mysqli_query($conn,"SELECT * from input_user_tb");
								while($dakrit = mysqli_fetch_array($daftar_kriteria)):
							?>
							<th><?=$data[strtolower($dakrit['kriteria'])];?></th>
							<?php endwhile;?>
							<th><?=$data['fire_strength'];?></th>
						</tr>
          <?php 
            }elseif($data['fire_strength'] >= 0.5){
          ?>
            	<tr style="background: #fcdb03;">
							<th><?=$num;?></th>
							<th><?=$data['obyek_wisata'];?></th>
							<?php
							$daftar_kriteria = mysqli_query($conn,"SELECT * from input_user_tb");
								while($dakrit = mysqli_fetch_array($daftar_kriteria)):
							?>
							<th><?=$data[strtolower($dakrit['kriteria'])];?></th>
							<?php endwhile;?>
							<th><?=$data['fire_strength'];?></th>
						</tr>
            <?php 
            }elseif($data['fire_strength'] > 0){
          ?>
            	<tr style="background: #fff6bd;">
							<th><?=$num;?></th>
							<th><?=$data['obyek_wisata'];?></th>
							<?php
							$daftar_kriteria = mysqli_query($conn,"SELECT * from input_user_tb");
								while($dakrit = mysqli_fetch_array($daftar_kriteria)):
							?>
							<th><?=$data[strtolower($dakrit['kriteria'])];?></th>
							<?php endwhile;?>
							<th><?=$data['fire_strength'];?></th>
						</tr>
          <?php
            }else{
          ?>
	          <tr style="background: red;">
							<th><?=$num;?></th>
							<th><?=$data['obyek_wisata'];?></th>
							<?php
							$daftar_kriteria = mysqli_query($conn,"SELECT * from input_user_tb");
								while($dakrit = mysqli_fetch_array($daftar_kriteria)):
							?>
							<th><?=$data[strtolower($dakrit['kriteria'])];?></th>
							<?php endwhile;?>
							<th><?=number_format((float)$data['fire_strength'], 2, '.', '');?></th>
						</tr>
	
          <?php
            } 
          }else{
            if($data['fire_strength'] == 1){
              ?>
                <tr style="background: #fc9803;">
                  <th><?=$num;?></th>
                  <th><?=$data['obyek_wisata'];?></th>
                  <?php
                  $daftar_kriteria = mysqli_query($conn,"SELECT * from input_user_tb");
                    while($dakrit = mysqli_fetch_array($daftar_kriteria)):
                  ?>
                  <th><?=$data[strtolower($dakrit['kriteria'])];?></th>
                  <?php endwhile;?>
                  <th><?=number_format((float)$data['fire_strength'], 2, '.', '');?></th>
                </tr>
              <?php 
                }elseif($data['fire_strength'] > 0.5){
              ?>
                  <tr style="background: #fcdb03;">
                  <th><?=$num;?></th>
                  <th><?=$data['obyek_wisata'];?></th>
                  <?php
                  $daftar_kriteria = mysqli_query($conn,"SELECT * from input_user_tb");
                    while($dakrit = mysqli_fetch_array($daftar_kriteria)):
                  ?>
                  <th><?=$data[strtolower($dakrit['kriteria'])];?></th>
                  <?php endwhile;?>
                  <th><?=number_format((float)$data['fire_strength'], 2, '.', '');?></th>
                </tr>
                <?php 
                }elseif($data['fire_strength'] > 0){
              ?>
                  <tr style="background: #fff6bd;">
                  <th><?=$num;?></th>
                  <th><?=$data['obyek_wisata'];?></th>
                  <?php
                  $daftar_kriteria = mysqli_query($conn,"SELECT * from input_user_tb");
                    while($dakrit = mysqli_fetch_array($daftar_kriteria)):
                  ?>
                  <th><?=$data[strtolower($dakrit['kriteria'])]?></th>
                  <?php endwhile;?>
                  <th><?=number_format((float)$data['fire_strength'], 2, '.', '');?></th>
                </tr>
              <?php
                }else{
              ?>
                <tr style="background: #ff0000;">
                  <th><?=$num;?></th>
                  <th><?=$data['obyek_wisata'];?></th>
                  <?php
                  $daftar_kriteria = mysqli_query($conn,"SELECT * from input_user_tb");
                    while($dakrit = mysqli_fetch_array($daftar_kriteria)):
                  ?>
                  <th><?=$data[strtolower($dakrit['kriteria'])];?></th>
                  <?php endwhile;?>
                  <th><?=number_format((float)$data['fire_strength'], 2, '.', '');?></th>
                </tr>
      
              <?php
                } 
          }
          
					?>
					
				<?php $num++; endwhile; 
          $del = mysqli_query($conn,"DROP TABLE rekomendasi_tb");
        
				?>

			</tbody>
		</table>
    <div class="agenda pt-1 pb-5 table-responsive">
      <p>Keterangan:</p>
      <table class="table">
        <tr>
          <th style="background-color: #fc9803;text-align: center;">Sangat direkomendasikan (FS = 1)</th>
          <th style="background-color: #fcdb03;text-align: center;">Direkomendasikan (0.5 < FS < 1)</th>
          <th style="background-color: #fff6bd;text-align: center;">Kurang direkomendasikan (0 < FS < 0.5)</th>
        </tr>
      </table>
    </div>

		<div class="mt-2 mb-5">
			<button class="btn btn-info btn-block" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
				Klik di sini untuk melihat hasil penghitungan fuzzy
			</button>

			<div class="collapse" id="collapseExample">
				<table class='table table-bordered table-striped mt-4'>
					<thead class="thead-dark">
						<tr>
							<th>No</th>
							<th>Nama</th>
							<?php
								$daftar_kriteria = mysqli_query($conn,"SELECT * from input_user_tb");
								while($data = mysqli_fetch_array($daftar_kriteria)):
							?>
							<th>Bobot <?=$data['kriteria'];?></th>
							<?php endwhile;?>
							<th>Fire Strength</th>
						</tr>
					</thead>
					<tbody>

					<?php
						$get_fuzzy_query = mysqli_query($conn,"SELECT * from penghitungan_bobot_tb ORDER BY fire_strength DESC LIMIT 10");
						$num = 1;
            if($get_fuzzy_query){
              while($data = mysqli_fetch_array($get_fuzzy_query)):
          ?>
           
           <tr>
							<th><?=$num;?></th>
							<th><?=$data['obyek_wisata'];?></th>
							
							<?php
							$daftar_kriteria = mysqli_query($conn,"SELECT * from input_user_tb");
							while($dakrit = mysqli_fetch_array($daftar_kriteria)):
								//$str="bobot_";
								//$str.=strtolower($dakrit['kriteria']);
                $str=strtolower($dakrit['kriteria']);
							?>
							<th><?=number_format((float)$data[$str], 2, '.', '');?></th>
							<?php endwhile;?>
							
							<th><?=number_format((float)$data['fire_strength'], 2, '.', '');?></th>
						</tr>

					<?php $num++; endwhile; 
          $del = mysqli_query($conn,"DROP TABLE penghitungan_bobot_tb");
          $del = mysqli_query($conn,"DELETE FROM input_user_tb");
          if($del) {mysqli_close($conn);}
        }
          ?>
           
           
           <?php }else{
             $del = mysqli_query($conn,"DELETE FROM input_user_tb");
             if($del) {mysqli_close($conn);}
             echo "<script>alert('Maaf, server sedang sibuk. Silahkan coba beberapa saat lagi. (Error - 002 hudtakim@hdmvision)')</script>";
           } }
            }else{
             echo "<script>alert('Maaf, server sedang sibuk. Silahkan coba beberapa saat lagi. (Error - 001 hudtakim@hdmvision)')</script>";
           } } }?> 
						
					</tbody>
				</table>
			</div>
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
<script src="javascript/optional_input_kriteria.js"></script>

