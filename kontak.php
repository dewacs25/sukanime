<?php include "koneksi.php"; 

session_start();
error_reporting(0);


?>

<html>
<head>
	<link href='asset/gambar/pink.png' rel='shortcut icon'>
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
	<title>Kontak</title>
	<link rel="stylesheet" type="text/css" href="asset/style1.css">
	<script src="https://kit.fontawesome.com/a2754a84b5.js" crossorigin="anonymous"></script>
</head>
<body>
	
	<!-- bagian header  -->
	<header>
	<img src="asset/gambar/nime.png" >
	</header>
	<!-- akhir bagian header  -->
	
	<div class="wrap">
		<!-- bagian menu -->
		<nav class="menu">
			<ul>
				<li>
					<a href="index.php">Beranda</a>
				</li>
				
				<li>
					<a href="kontak.php">Kontak</a>
				</li>
				<li>
					<a href="tentang.php">Tentaang kami</a>
				</li>
				<?php 
					if($_SESSION['email']==""){?>

						<li><a href="index.php?login">Login</a></li>
						
					<?php }else{?>
						
						<li><a href="index.php?nama=<?=$_SESSION['nama']; ?>"><i class="fas fa-user"></i> &nbsp; <?php echo $_SESSION['nama']; ?></a></li>
						<?php } ?>
			</ul>
		</nav>
		<!-- akhir bagian menu -->
 
		<!-- bagian sidebar website -->
		<aside class="sidebar">
			
			
			<div class="widget">
				<h2>Populer</h2>
				
				<?php 

				$ki = mysqli_fetch_array(mysqli_query($conect, "SELECT * FROM tb_kategori WHERE kategori='populer'"));
				$idka = $ki['id_kategori'];
				$dds = mysqli_query($conect, "SELECT * FROM tb_berita WHERE id_kategori='$idka'");
				while($row = mysqli_fetch_array($dds)){
				?>	
				<hr>
				<a href="all.php?id=<?= $row['id_berita'];?>?<?= $row['judul'];?>" style="text-decoration: none; color: gray;"><p><?= $row['judul'];?></p></a><br>
					<?php } ?>
					<hr>
			</div>
			
			
		</aside>
		<!-- akhir bagian sidebar website -->
 
		<!-- bagian konten Blog -->
		

		<div class="blog">
			<br><br>
			<iframe width="640" height="300" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d253670.16429428055!2d106.45464042499998!3d-6.572523499999989!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69dba845ad6d69%3A0xb47eced64dc57aca!2sWarung%20MaLes!5e0!3m2!1sid!2sid!4v1653112311911!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
			<br>
			<p><b>Tel: 082125246091</b></p>
			<p><b>Email: <a href="mailto:muhamadhaudy25@gmail.com">muhamadhaudy25@gmail.com</b></a></p>
			<a class="cof" href="https://www.facebook.com/haudyal" target="_blank"><i class="fab fa-facebook-square"></i></a> &nbsp;<a class="coi" href="https://www.instagram.com/haudyal/" target="_blank"><i class="fab fa-instagram-square"></i></a>
		</div>
		<div class="blog">
			<div class="conteudo">
				<div class="ga">
					<h2> Report</h2>
					<?php 

					if (isset($_POST['kirim'])) {
						date_default_timezone_set("Asia/Jakarta");
						$nama_pelapor = $_POST['nama_pelapor'];
						$subjek = $_POST['subjek'];
						$tgl = date('Y-m-d H-i-s');
						$isi_pesan = $_POST['isi_pesan'];
						$email = $_POST['email'];


						$sql = mysqli_query($conect ,"INSERT INTO `tb_report`(`id_report`, `nama_pelapor`, `tgl_report`, `subjek`, `isi_report`,`email`) VALUES ('','$nama_pelapor','$tgl','$subjek','$isi_pesan','$email')");
						if ($sql) {
							echo "<script>alert('Laporan Sudah Terkirim');document.location='kontak.php'</script>";
						}
					}
					 ?>
					<form action="" method="POST">
					<input type="text" name="nama_pelapor" placeholder="Masukan Nama" required autocomplete="off">
					<input type="email" name="email" placeholder="Masukan Email" required autocomplete="off">
					<select required name="subjek">
						<option value="none">Pilih Subjek</option>
						<option value="Akun User">Akun user</option>
						<option value="ui ux">UI UX</option>

					</select>
					<br>
					<textarea name="isi_pesan" placeholder="Masukan Pesan" rows="3" cols="73" required></textarea>
					<br>
					<button name="kirim">Kirim</button>
				</form>
				</div>
			</div>
			
			<footer>copyright © 2022 Rm.haudy</foter>
		</div>
					
		<!-- akhir bagian konten Blog -->
	</div>
 
</body>
</html>