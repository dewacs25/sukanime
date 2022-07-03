<?php 
$conect = mysqli_connect("localhost","root","","web_pw01");
 
if (mysqli_connect_errno()){
	echo "Koneksi database gagal : " . mysqli_connect_error();

}


 
?>