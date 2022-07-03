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
	
	<!-- bagian header template -->
	<header>
	<img src="asset/gambar/nime.png" >
	</header>
	<!-- akhir bagian header template -->
	
	<div class="wrap">
		<!-- bagian menu		 -->
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
						
						<li><a href="?nama=<?=$_SESSION['nama']; ?>"><i class="fas fa-user"></i> &nbsp; <?php echo $_SESSION['nama']; ?></a></li>
						<?php } ?>
			</ul>
		</nav>
		<!-- akhir bagian menu -->
 
		<!-- bagian sidebar website -->
		<aside class="sidebar">
		
		</aside>
		<div class="blog">
			<div class="conteudo">
				<h2>Tentang Kami</h2>
				<p>SUKAnime adalah portal yang menyediakan informasi tentang anime terbaru, anime populer dan berita seputar kehidupan pecinta anime di indonesia.</p>
				<p>Visi: Menjadi portal Penyedia Informasi Anime No 1 di Indonesia</p>
				<p>Misi: Menyediakan berbagai macam informasi Anime yang anda butuhkan sehari – hari.</p>
			</div>
			<footer>copyright © 2022 Rm.haudy</footer>
		</div>
		
					
	
	</div>
 
</body>
</html>