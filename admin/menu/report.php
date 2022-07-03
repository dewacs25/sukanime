<?php include "../../koneksi.php";
session_start();
error_reporting(0);

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
        <table border="1" class="table1">
            <thead>
                <tr>

                    <th>No</th>
                    <th>Nama Pelapor</th>
                    <th>Subjek</th>
                    <th>Isi laporan</th>
                    <th>Tgl</th>
                    <th>email</th>


                </tr>
            </thead>
            <tbody>

                <?php
                include("koneksi.php");
                $i = 1;
                $sql = "select * from tb_report";
                $query = mysqli_query($conect, $sql);

                while ($user = mysqli_fetch_array($query)) { ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?= $user['nama_pelapor']; ?></td>
                        <td><?= $user['subjek']; ?></td>
                        <td><?= $user['isi_report']; ?></td>
                        <td><?= $user['tgl_report']; ?></td>
                        <td><?= $user['email']; ?></td>
                        <td><a href="?hapusre=<?= $user['id_report']; ?>">
                        <i class="fas fa-trash-alt"></i></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>
<?php


if (isset($_GET['hapusre'])) {
    $idre = $_GET['hapusre'];
    $sql = mysqli_query($conect, "DELETE FROM tb_report WHERE id_report='$idre' ");
    if ($sql) {
        echo "<script>alert('berhasil dihapus');document.location='report.php'</script>";
    }
}
?>