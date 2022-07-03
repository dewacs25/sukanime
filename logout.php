<?php 
if (isset($_GET['user'])) {
	session_start();
	unset($_SESSION['iduser'],$_SESSION['nama'],$_SESSION['email'],$_SESSION['status']);
	echo "<script>alert('Dadah :(');document.location='index.php'</script>";
}elseif(isset($_GET['admin'])){
	session_start();
	unset($_SESSION['admin'],$_SESSION['idadmin']);
	echo "<script>alert('Dadah :(');document.location='index.php'</script>";

}else{
	echo "gagal";
}

 ?>