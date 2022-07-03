<?php include "koneksi.php";

session_start();
error_reporting(0);
?>
<html>

<head>
	<link href='asset/gambar/pink.png' rel='shortcut icon'>
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
	<title>SUKAnime</title>
	<link rel="stylesheet" type="text/css" href="asset/style1.css">
	<script src="https://kit.fontawesome.com/a2754a84b5.js" crossorigin="anonymous"></script>
</head>

<body>


	<header>
		<img src="asset/gambar/nime.png">
	</header>


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
				<?php
				if ($_SESSION['email'] == "") { ?>

					<li><a href="index.php?login">Login</a></li>

				<?php } else { ?>
					<li><a href="index.php?nama"><i class="fas fa-user"></i>&nbsp; <?php echo $_SESSION['nama']; ?></a></li>
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
				while ($row = mysqli_fetch_array($dds)) {
				?>
					<a href="all.php?id=<?= $row['id_berita']; ?>?<?= $row['judul']; ?>" style="text-decoration: none; color: gray;">
						<p><?= $row['judul']; ?></p>
					</a>
					<hr>
				<?php } ?>
			</div>


		</aside>
		<!-- akhir bagian sidebar website -->

		<!-- bagian konten  -->

		<?php

		if (isset($_GET['id'])) {
			$id = $_GET['id'];

			$sql = mysqli_query($conect, "SELECT * FROM tb_berita WHERE id_berita='$id'");
			$row = mysqli_fetch_array($sql);
		} else {
			header('location:index.php');
		}
		?>
		<div class="blog">
			<div class="conteudo">
				<div class="post-info">
					Di Posting <b><?= $row['tgl_posting']; ?></b>
				</div>
				<h3><?php echo $row['judul']; ?></h3>
				<img src="asset/gambar/<?php echo $row['gambar']; ?>">
				<p><?php echo $row['txt_berita']; ?></p>

			</div>

			<br>
			<div class="ko">
				<?php
				$idad = $row['id_admin'];
				$tampiladmin = mysqli_fetch_array(mysqli_query($conect, "SELECT * FROM tb_admin WHERE id_admin='$idad'"))
				?>



				<p><img src="admin/asset/gambar/profil/<?php if (empty($tampiladmin['gambar_ad'])) {
															echo "../no.jpg";
														} else {
															echo $tampiladmin['gambar_ad'];
														} ?>" alt=""><br>All posts by <b><?php echo $tampiladmin['nama_lengkap'] ?></b><br>
					<a class="cof" href="<?= $tampiladmin['url_facebook'] ?>" target="_blank"><i class="fab fa-facebook-square"></i></a> &nbsp;<a class="coi" href="<?= $tampiladmin['url_instagram'] ?>" target="_blank"><i class="fab fa-instagram-square"></i></a>
				</p>

			</div>

			<br><br>
			<div>
				<form action="" method="POST">
					<input maxlength="500" type="text" size="30" style="border: none; height: 35px" name="komen" required width="100px" placeholder="Masukan komentar">&nbsp;&nbsp;<button name="inkomen" class="bubu"><i class="fas fa-paper-plane"></i></button>
				</form>
				<?php

				if (isset($_POST['inkomen'])) {
					if ($_SESSION['email'] == "") {
						echo "<script>alert('Login Dulu lah');document.location='index.php?login'</script>";
					}
					$id = $_GET['id'];
					date_default_timezone_set("Asia/Jakarta");
					$komen = htmlspecialchars($_POST['komen']);
					$tgl = date('Y-m-d H:i:s');

					$iduser = $_SESSION['iduser'];

					$inn = mysqli_query($conect, "INSERT INTO `tb_komentar`(`id_komentar`, `id_berita`, `id_anggota`, `isi_komentar`, `tgl_komentar`) VALUES ('','$id','$iduser','$komen','$tgl') ");
					if ($inn) {
						echo "<script>alert('makasih dah komen');document.location='all.php?id=$id'</script>";
					} else {
						echo "<script>alert('gagal');document.location='all.php'</script>";
					}
				}

				?>
			</div>
			<div class="conteudo">
				<h4>Komentar</h4>

				<?php
				$id = $_GET['id'];
				$sql3 = mysqli_query($conect, "SELECT tb_komentar.*, tb_anggota.nama FROM tb_komentar LEFT JOIN tb_anggota ON tb_anggota.id_anggota = tb_komentar.id_anggota
			WHERE id_berita='$id'
			ORDER BY id_komentar DESC");
				$u = mysqli_num_rows($sql3);

				while ($kom = mysqli_fetch_assoc($sql3)) {
					// code...
				?>

					<hr>

					<div class="kontenkomen">
						<?php if ($_SESSION['iduser'] == $kom['id_anggota']) {

						?>
							<form action="" method="POST">
								<input type="hidden" name="idid" value="<?= $kom['id_komentar'] ?>">
								<input type="submit" name="su" value="hapus" class="ha">
							</form>

						<?php } ?>
						<p><?= $kom['isi_komentar']; ?></p>


						<p style="font-size: 10px;">dari :<?= $kom['nama']; ?> <?= $kom['tgl_komentar']; ?></p>
					</div>
					<hr>
				<?php } ?>
			</div>

			<br><br>
			<footer>copyright © 2022 Rm.haudy</footer>
		</div>



		<!-- akhir bagian konten  -->
	</div>
	
</body>

</html>
<?php if (isset($_POST['su'])) {

	$ema = $_POST['idid'];
	$sql = mysqli_query($conect, "DELETE FROM tb_komentar WHERE id_komentar='$ema'");
	if ($sql) {
		echo "<script>alert('komentar dihapus');document.location='all.php?id=$id'</script>";
	}
} ?>