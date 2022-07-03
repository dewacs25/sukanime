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
            <p class="tulisan_login">Edit Profil</p>

            <form action="" method="POST" enctype="multipart/form-data">

                <label>Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="form_login" value="<?php echo $admin['nama_lengkap'] ?>">

                <label>URL Facebook</label>
                <input type="text" name="facebook" class="form_login" value="<?php echo $admin['url_facebook'] ?>">

                <label>URL instagram</label>
                <input type="text" name="instagram" class="form_login" value="<?php echo $admin['url_instagram'] ?>">

                <label>Foto</label>
                <input type="file" name="gambar"><br><br>
                <input type="hidden" name="gambarb" value="<?php echo $admin['gambar_ad'] ?>">

                <input type="submit" class="tombol_login_biru" name="submit" value="SELESAI">

                <br />
                <br />

                <a class="link" href="./">kembali</a>

            </form>

        </div>
    </div>

</body>

</html>
<?php

if (isset($_POST['submit'])) {
    $foto = $_FILES['gambar']['tmp_name'];
    $namafoto = $_FILES['gambar']['name'];
    $nama_lengkap = htmlspecialchars($_POST['nama_lengkap']);
    $random_string = uniqid();
    $ext = end(explode(".", $namafoto));
    $newnama = $random_string . '.' . $ext;
    $gambarbaru = $_POST['gambarb'];
    $facebook = $_POST['facebook'];
    $instagram = $_POST['instagram'];


    if (empty($foto)) {
        $sql = mysqli_query($conect, "UPDATE tb_admin SET nama_lengkap='$nama_lengkap',url_facebook='$facebook',url_instagram='$instagram' WHERE id_admin='$idadmin'");
        if ($sql) {

            echo "<script>alert('berhasil');document.location='profiladmin.php'</script>";
        } else {
            echo "<script>alert('gagal silahkan coba lagi');document.location='edituser.php'</script>";
        }
    } else {
        unlink('../asset/gambar/profil/' . $gambarbaru);
        move_uploaded_file($foto, '../asset/gambar/profil/' . $newnama);
        $sql = mysqli_query($conect, "UPDATE `tb_admin` SET `nama_lengkap`='$nama_lengkap', `gambar_ad`='$newnama' WHERE id_admin='$idadmin'");
        if ($sql) {

            echo "<script>alert('berhasil');document.location='profiladmin.php'</script>";
        } else {
            echo "<script>alert('gagal silahkan coba lagi');document.location='edituser.php'</script>";
        }
    }
}

?>