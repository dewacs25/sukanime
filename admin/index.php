<?php include "../koneksi.php"; 
session_start();
error_reporting(0);


	$user = $_POST['user'];
	$pass = $_POST['pass'];

	$passmd5 = md5($pass);

	if (isset($_POST['submit'])) {
		
		$cekadmin = mysqli_query($conect, "SELECT * FROM tb_admin WHERE username='$user' and password='$passmd5' ");
		$row = mysqli_fetch_array($cekadmin);
		$isi = mysqli_num_rows($cekadmin);
		$idadmin = $row['id_admin'];
		if ($isi > 0) {
			$_SESSION['admin'] = $user;
			$_SESSION['idadmin'] = $idadmin;
			echo "<script>alert('selamat datang $user');document.location='menu/home.php'</script>";
		}else{
			header("location:index.php?pesan=gagal");
		}
	}

?>



<!DOCTYPE html>
<html>
<head>
	<title>login admin</title>
	<link rel="stylesheet" type="text/css" href="asset/style.css">
</head>
<body>
<?php 
		if(isset($_GET['pesan'])){
			if($_GET['pesan']=="gagal"){
			echo "<div style='background: red; padding: 10px; text-align: center;'>Username dan Password tidak sesuai</div>";
			}elseif ($_GET['pesan']=="gagal1") {
				echo "<div style='background: white; padding: 10px; text-align: center;'>Silahkan login terlebih dahulu</div>";
			}
		}
 ?>

	<div class="kotak_login">
		<p class="tulisan_login">Silahkan login</p>

		<form action="" method="POST">
			<label>Username</label>
			<input type="text" name="user" class="form_login" placeholder="Madukan user admin" required>

			<label>Password</label>
			<input type="password" name="pass" class="form_login" placeholder="Password ..">

			<input type="submit" class="tombol_login" name="submit" value="LOGIN">

			<br/>
			<br/>
			
				<a class="link" href="../">kembali</a>
			
		</form>
		
	</div>


</body>
</html>