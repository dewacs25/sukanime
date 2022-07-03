<?php include "koneksi.php";

session_start();

error_reporting(0);


?>

<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>SUKAnime</title>
	<link href='asset/gambar/pink.png' rel='shortcut icon'>
	<link rel="stylesheet" type="text/css" href="asset/style1.css">
	<script src="https://kit.fontawesome.com/a2754a84b5.js" crossorigin="anonymous"></script>
</head>

<body>

	<!-- bagian header -->
	<header>
		<img src="asset/gambar/nime.png" title="SUKAnime">

	</header>
	<!-- akhir bagian header  -->

	<div class="wrap">
		<!-- bagian menu		 -->
		<nav class="menu">
			<ul>
				<li>
					<a href="index.php">Beranda</a>
				</li>
				<li>
					<a href="?kategori">Kategori</a>
				</li>
				<li>
					<a href="kontak.php">Kontak</a>
				</li>

				<?php
				if ($_SESSION['email'] == "") { ?>

					<li><a href="?login">Login</a></li>

				<?php } else { ?>

					<li><a href="?nama"><i class="fas fa-user"></i> <?php echo $_SESSION['nama']; ?></a></li>
				<?php } ?>

			</ul>
		</nav>
		<!-- akhir bagian menu -->

		<!-- bagian sidebar website -->
		<aside class="sidebar">

			<form action="" method="get">
				<input type="text" name="caridata" placeholder="Maap kalo ga ada" required class="inn">
				<button class="cari" name="cari"><i class='fas fa-search'></i></button>

			</form>


			<?php
			if (isset($_GET['login'])) {
				if (isset($_POST['submit'])) {
					$email = $_POST['email'];
					$pass = $_POST['pass'];

					$passmd5 = md5($pass);

					$cekuser = mysqli_query($conect, "SELECT * FROM tb_anggota WHERE email='$email' and password='$passmd5' ");
					$row = mysqli_fetch_array($cekuser);
					$isi = mysqli_num_rows($cekuser);

					$nama = $row['nama'];
					$iduser = $row['id_anggota'];

					if ($isi > 0) {
						if ($row['status'] == 'tidak aktif') {
							echo "<script>alert('Akun anda telah di blokir');document.location='index.php'</script>";
						} else {
							$_SESSION['iduser'] = $iduser;
							$_SESSION['nama'] = $nama;
							$_SESSION['email'] = $email;

							echo "<script>alert('selamat datang $nama');document.location='index.php'</script>";
						}
					} else {
						echo "<script>alert('Email dan Password tidak sesuai');document.location='index.php'</script>";
					}
				}

			?>
				<a href="index.php" class="x"><i class="fas fa-times-circle"></i></a>
				<div class="widget_login">

					<form action="" method="POST" autocomplete="off">

						<h1>login</h1>
						<input class="input" type="email" name="email" placeholder="Madukan Email" required>

						<input class="input" type="password" name="pass" placeholder="Madukan password" required>

						<button name="submit">Login</button><br>

						<a style="text-decoration: none; color: gray;" href="?daftar">Daftar</a>


					</form>
				</div>
			<?php } elseif (isset($_GET['daftar'])) {
				if (isset($_POST['daf'])) {

					$nama1 = htmlspecialchars($_POST['nama']);
					$email = htmlspecialchars($_POST['email']);
					$pass = htmlspecialchars($_POST['pass']);
					$passmd5 = md5($pass);
					$nnn = mysqli_query($conect, "SELECT * FROM tb_anggota WHERE nama='$nama1' ");
					$nnn1 = mysqli_query($conect, "SELECT * FROM tb_anggota WHERE email='$email' ");
					$usercek = mysqli_num_rows($nnn);
					$usercek2 = mysqli_num_rows($nnn1);
					if ($usercek == true) {
						echo "<script>alert('nama sudah di gunakan orang lain');document.location='index.php'</script>";
					} elseif ($usercek2 == true) {

						echo "<script>alert('email sudah di gunakan orang lain');document.location='index.php'</script>";
					} else {
						$sql = mysqli_query($conect, "INSERT INTO tb_anggota (nama,email,password) VALUES ('$nama1','$email','$passmd5') ");


						if ($sql) {
							$cekuser = mysqli_query($conect, "SELECT * FROM tb_anggota WHERE email='$email' and password='$passmd5' ");
							$isi = mysqli_num_rows($cekuser);
							$roww = mysqli_fetch_array($cekuser);
							$iduser = $roww['id_anggota'];

							if ($isi > 0) {

								$_SESSION['iduser'] = $iduser;
								$_SESSION['nama'] = $nama1;
								$_SESSION['email'] = $email;

								echo "<script>alert('selamat datang $nama1');document.location='index.php'</script>";
							}
						} else {
							header('location:index.php?pesan=gagal');
						}
					}
				}
			?>
				<a href="index.php" class="x"><i class="fas fa-times-circle"></i></a>
				<div class="widget_login">

					<form action="" method="POST" autocomplete="off">

						<h1>Daftar</h1>

						<input class="input" type="text" name="nama" placeholder="Masukan Nama" required autocomplete="off" minlength="4">

						<input class="input" type="email" name="email" placeholder="Masukan Email" required autocomplete="off">

						<input class="input" type="password" name="pass" placeholder="Masukan password" required minlength="4">

						<button name="daf">Daftar</button>
					</form>
				</div>
			<?php } ?>

			<?php if (isset($_GET['nama'])) {

			?>
				<a href="index.php" class="x"><i class="fas fa-times-circle"></i></a>
				<div class="widget_login">

					<a href="anggota/edituser.php?edit=<?= $_SESSION['email']; ?>" class="hijau"><i class="fas fa-user"></i> Edit</a>

					<a href="logout.php?user" class="logout"><i class="fas fa-sign-out"></i> Logout</a>
				</div>
			<?php } elseif (isset($_GET['kategori'])) { ?>
				<a href="index.php" class="x"><i class="fas fa-times-circle"></i></a>
				<div class="widget_login">

					<h2>Kategori</h2>
					<div class="kate">
						<?php $tampilkate = mysqli_query($conect, "SELECT * FROM tb_kategori");
						while ($kate = mysqli_fetch_assoc($tampilkate)) { ?>

							<a href="?kategor=<?= $kate['id_kategori']; ?>"><?php echo $kate['kategori']; ?></a>
							<br>
							<hr>

						<?php } ?>
					</div>
				</div>
			<?php } ?>

			<!-- populer -->

			<div class="widget">
				<h2>Populer</h2>

				<?php
				$ki = mysqli_fetch_array(mysqli_query($conect, "SELECT * FROM tb_kategori WHERE kategori='populer' "));
				$idka = $ki['id_kategori'];
				$dds = mysqli_query($conect, "SELECT * FROM tb_berita WHERE status='aktif' and id_kategori='$idka'");
				while ($row = mysqli_fetch_array($dds)) {

				?>
					<hr>
					<a href="all.php?id=<?= $row['id_berita']; ?>?<?= $row['judul']; ?>" style="text-decoration: none; color: gray;">
						<p><?= $row['judul']; ?>

						</p>
					</a>
				<?php } ?>
				<hr>
			</div>


		</aside>

		<?php

		$sql = mysqli_query($conect, "SELECT * FROM tb_berita WHERE status='aktif' ORDER BY tgl_posting DESC limit 3");
		if (isset($_GET['cari'])) {
			$coco = $_GET['caridata'];

			$sql = mysqli_query($conect, "SELECT * FROM tb_berita WHERE status='aktif' AND judul LIKE '%$coco%' OR tgl_posting = '%$coco%' ORDER BY tgl_posting DESC ");
			$hitung = mysqli_num_rows($sql);
			if ($hitung == null) {
				echo "<script>alert('maaf data tidak ditemukan ');document.location='index.php'</script>";
			}
		} elseif (isset($_GET['kategor'])) {
			$idkate = $_GET['kategor'];
			$sql = mysqli_query($conect, "SELECT * FROM tb_berita WHERE status='aktif' AND id_kategori='$idkate' ORDER BY tgl_posting desc");
			$hitung = mysqli_num_rows($sql);
			if ($hitung == null) {
				echo "<script>alert('maaf data tidak ditemukan ');document.location='index.php'</script>";
			}
		} elseif (isset($_GET['selengkapnya'])) {
			$sql = mysqli_query($conect, "SELECT * FROM tb_berita WHERE status='aktif' ORDER BY id_berita desc");
		}
		while ($row = mysqli_fetch_array($sql)) {
		?>
			<div class="blog">

				<div class="conteudo">
					<div class="post-info">
						Di Posting : <b><?= $row['tgl_posting']; ?></b>
					</div>
					<img src="asset/gambar/<?= $row['gambar']; ?>" alt="<?= $row['judul']; ?>">
					<h1> <a style="color: black; text-decoration: none;" href="all.php?id=<?= $row['id_berita']; ?>?<?= $row['judul']; ?>"><?= $row['judul']; ?></a></h1>
					<hr>
					<p><?= substr($row['txt_berita'], 0, 155); ?>...<a href="all.php?id=<?= $row['id_berita']; ?>?<?= $row['judul']; ?>">Baca Selengkapnya</a></p>

				</div>


			<?php } ?>
			<!-- <?php if (is_null($_GET['selengkapnya'])) { ?>
				<a class="se" href="?selengkapnya">Semua Postingan</a>
			<?php } ?> -->
			<?php
			if (is_null($_GET['selengkapnya'])) {
				if (isset($_GET['kategor'])) {
					echo "";
				} else { ?>
					<a class="se" href="?selengkapnya">Semua Postingan</a>
			<?php }
			}
			?>

			</div>



			<!-- akhir bagian konten Blog -->
	</div>
	<footer>copyright © 2022 Rm.haudy</footer>

</body>

</html>