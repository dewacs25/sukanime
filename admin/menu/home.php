<?php include "../../koneksi.php";
session_start();


if ($_SESSION['admin'] == "") {
    header("location:../index.php?pesan=gagal1");
}
$idadmin = $_SESSION['idadmin'];
$sql = mysqli_query($conect, "SELECT * FROM tb_admin WHERE id_admin='$idadmin'");
$admin = mysqli_fetch_array($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ini halaman admin</title>
    <link rel="stylesheet" href="../asset/style.css" />
    <script src="https://kit.fontawesome.com/a2754a84b5.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="menu">
        <div class="profile">
            <figure>
                <a href="profiladmin.php"><img src="../asset/gambar/profil/<?php if (empty($admin['gambar_ad'])) {
                                                                                echo "../no.jpg";
                                                                            } else {
                                                                                echo $admin['gambar_ad'];
                                                                            } ?>" alt="none" title="Edit"></a>
                <figcaption><?php echo $admin['nama_lengkap']; ?></figcaption>
            </figure>
        </div>
        <div class="listmenu">
            <ul>
                <li><a href="home.php"><i class="fas fa-home"></i> Beranda</a></li>
                <li><a href="berita.php"><i class="far fa-newspaper"></i> Berita</a></li>
                <li><a href="user.php"><i class="far fa-user"></i> user</a></li>
                <li><a href="admin.php"><i class="far fa-user"></i> admin</a></li>
                <li><a href="report.php"><i class="fas fa-flag"></i> report</a></li>
                <li><a href="../../logout.php?admin"><i class="fas fa-sign-out"></i> Logout</a></li>
            </ul>
        </div>
    </div>
    <div class="konten">
        <div class="kotak_login">
            <h3 class="tulisan_login">Halaman Admin</h3>
            <?php $sql1 = mysqli_query($conect, "SELECT * FROM tb_berita");
            $hitung1 = mysqli_num_rows($sql1); ?>
            <h2><i class="far fa-newspaper"></i> Berita : <?php echo $hitung1 ?></h2>
           
        
            <?php $sql2 = mysqli_query($conect, "SELECT * FROM tb_anggota");
            $hitung2 = mysqli_num_rows($sql2); ?>
            <h2><i class="far fa-user"></i> User : <?php echo $hitung2 ?></h2>
       
            <?php $sql3 = mysqli_query($conect, "SELECT * FROM tb_report");
            $hitung3 = mysqli_num_rows($sql3); ?>
            <h2><i class="fas fa-flag"></i> Report : <?php echo $hitung3; ?></h2>
        
            

        </div>
       
    </div>

</body>

</html>
<!--  <div class="kotak">
<?php $sql1 = mysqli_query($conect, "SELECT * FROM tb_berita");
            $hitung1 = mysqli_num_rows($sql1); ?>
            <div class="dal">
                <h2><i class="far fa-newspaper"></i> Berita : <?php echo $hitung1 ?></h2>
            </div>
        </div>
        <div class="kotak1">
            <?php $sql2 = mysqli_query($conect, "SELECT * FROM tb_anggota");
            $hitung2 = mysqli_num_rows($sql2); ?>
            <h2><i class="far fa-user"></i> User : <?php echo $hitung2 ?></h2>
        </div>
        <div class="kotak2">
            <?php $sql3 = mysqli_query($conect, "SELECT * FROM tb_report");
            $hitung3 = mysqli_num_rows($sql3); ?>
            <h2><i class="fas fa-flag"></i> Report : <?php echo $hitung3; ?></h2>
        </div> -->