<?php 
session_start();
include "../koneksi.php";
if (isset($_GET['edit'])) {
	$email = $_GET['edit'];
	$row = mysqli_fetch_assoc(mysqli_query($conect, "SELECT * FROM tb_anggota WHERE email='$email'"));
}
if (isset($_POST['submit'])){
	$passbaru = $_POST['passbaru'];
	$passmd5 = md5($passbaru);
	$nama = htmlspecialchars($_POST['nama']);
	$ceknama = mysqli_num_rows(mysqli_query($conect, "SELECT * FROM tb_anggota WHERE nama='$nama'"));
	if ($ceknama == true){
		echo "<script>alert('nama telah digunakan');document.location='edituser.php?edit=$email'</script>";
	}else{
		
		if (empty($passbaru)) {
			$sql = mysqli_query($conect, "UPDATE tb_anggota SET nama='$nama' WHERE email='$email'");
			if ($sql) {
				$_SESSION['nama'] = $nama;
				echo "<script>alert('berhasil');document.location='../'</script>";
			}else{
				echo "<script>alert('gagal silahkan coba lagi');document.location='edituser.php'</script>";
			}
		}else{
			$sql = mysqli_query($conect, "UPDATE tb_anggota SET nama='$nama', password='$passmd5' WHERE email='$email'");
			if ($sql) {
				$_SESSION['nama'] = $nama;
				echo "<script>alert('berhasil');document.location='../'</script>";
			}else{
					echo "<script>alert('gagal silahkan coba lagi');document.location='edituser.php'</script>";
			}
		}
	}

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../asset/style1.css">
    <title>Edit user</title>
</head>
<body>
<div class="kotak_login">
		<p class="tulisan_login">Edit user</p>
	
		<form action="" method="POST">
            <label>Nama</label>
			<input type="text" name="nama" class="form_login" placeholder="Madukan user admin" value="<?php echo $row['nama']; ?>">

			<label>Password</label>
			<input type="password" name="passbaru" class="form_login" placeholder="Password .." >

			<input type="submit" class="tombol_login" name="submit" value="Simpan">

			<br/>
			<br/>
			
				<a class="link" href="../">kembali</a>
			
		</form>
		
	</div>
</body>
</html>