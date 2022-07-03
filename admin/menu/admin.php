<?php include "../../koneksi.php";
session_start();


if ($_SESSION['admin'] == "") {
    header("location:../index.php?pesan=gagal1");
}
$idadmin = $_SESSION['idadmin'];
$ssql = mysqli_query($conect, "SELECT * FROM tb_admin WHERE id_admin='$idadmin'");
$admin = mysqli_fetch_array($ssql);
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
                <a href="profiladmin.php"><img src="../asset/gambar/profil/<?php if ($admin['gambar_ad'] == null) {
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
        <?php if (isset($_GET['tambahadmin'])) {
            if (isset($_POST['sub'])) {
                $namaadmin = $_POST['useradmin'];
                $pass = md5($_POST['pass']);

                $foto = $_FILES['gambar']['tmp_name'];
                $namafoto = $_FILES['gambar']['name'];
                $random_string = uniqid();
                $ext = end(explode(".", $namafoto));
                $newnama = $random_string . '.' . $ext;

                $nama_lengkap = $_POST['nama_lengkap'];
                if (empty($foto)) {
                    $tambah = mysqli_query($conect, "INSERT INTO tb_admin (username,nama_lengkap,password) VALUES ('$namaadmin','$nama_lengkap','$pass') ");

                    if ($tambah) {
                        echo "<script>alert('berhasil');document.location='admin.php'</script>";
                    } else {
                        echo "<script>alert('gagal');document.location='admin.php'</script>";
                    }
                } else {
                    $tambah = mysqli_query($conect, "INSERT INTO tb_admin (username,nama_lengkap,password,gambar_ad) VALUES ('$namaadmin','$nama_lengkap','$pass','$newnama') ");
                    move_uploaded_file($foto, '../asset/gambar/profil/' . $newnama);
                    if ($tambah) {
                        echo "<script>alert('berhasil');document.location='admin.php'</script>";
                    } else {
                        echo "<script>alert('gagal');document.location='admin.php'</script>";
                    }
                }
            }



        ?>

            <div class="kotak_login">
            
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="text" name="useradmin" placeholder="User admin" required class="form_login">
                    <br>
                    <input type="text" name="nama_lengkap" placeholder="Nama lengkap" required class="form_login">
                    <br>
                    <input type="password" name="pass" placeholder="password" required class="form_login">
                    <br>
                    <label>Photo
                    <input type="file" name="gambar">
                    </label>
                    <br><br>
                    <button name="sub" class="tombol_login_biru">kirim</button>
                </form>
            
            </div>
        <?php } else { ?>
            <fieldset>
                <legend><a href="?tambahadmin">Tambah admin</a></legend>
                <table border="1" class="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Nama lengkap</th>
                            <th></th>


                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $i = 1;
                        $sql = mysqli_query($conect, "SELECT * FROM tb_admin");
                        while ($row = mysqli_fetch_array($sql)) { ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?= $row['username']; ?></td>
                                <td><?= $row['nama_lengkap']; ?></td>
                                <td><a href="?hapusadmin=<?= $row['id_admin']; ?>" class="merah"><i class="fas fa-trash-alt"></i></a></td>


                            <?php } ?>
                    </tbody>
                </table>
            </fieldset>
            <br>
        <?php } ?>
    </div>
</body>

</html>
<?php
if (isset($_GET['hapusadmin'])) {
    $id = $_GET['hapusadmin'];

    $ceknama = mysqli_fetch_array(mysqli_query($conect, "SELECT * FROM tb_admin WHERE id_admin='$id'"));
    $namagambar = $ceknama['gambar_ad'];
    unlink('../asset/gambar/profil/' . $namagambar);

    $sql = mysqli_query($conect, "DELETE FROM tb_admin WHERE id_admin='$id'");
    if ($sql) {
        echo "<script>alert('hapus berhasil');document.location='admin.php'</script>";
    } else {
        echo "<script>alert('hapus gagal');document.location='admin.php'</script>";
    }
}
?>