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
        <table border="1" class="table1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>EMAIL</th>
                    <th>Status</th>
                    <th></th>

                </tr>
            </thead>
            <tbody>

                <?php
                $i = 1;

                $sql = "select * from tb_anggota";
                $query = mysqli_query($conect, $sql);

                while ($user = mysqli_fetch_array($query)) { ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?= $user['nama']; ?></td>
                        <td><?= $user['email']; ?></td>
                        <td><?= $user['status']; ?></td>
                        <td>
                            <?php if ($user['status'] == 'aktif') { ?>
                                <a href="?blokir=<?= $user['id_anggota']; ?>" class="hijau">blokir</a>
                            <?php } else { ?>
                                <a href="?buka=<?= $user['id_anggota']; ?>" class="merah">buka blokir</a>
                            <?php } ?>
                        </td>
                        <td><a href="?hapus=<?= $user['id_anggota']; ?>" class="merah"><i class="fas fa-trash-alt"></i></a></td>
                    </tr>
                <?php } ?>

                <?php

                if (isset($_GET['blokir'])) {
                    $id_anggota = $_GET['blokir'];
                    $sql = mysqli_query($conect, "UPDATE tb_anggota SET status='tidak aktif' WHERE id_anggota='$id_anggota' ");
                    if ($sql) {
                        echo "<script>alert('Blokir berhasil');document.location='user.php'</script>";
                    } else {
                        echo "<script>alert('Gagal blokir');document.location='user.php'</script>";
                    }
                } elseif (isset($_GET['buka'])) {
                    $id_anggota = $_GET['buka'];
                    $sql = mysqli_query($conect, "UPDATE tb_anggota SET status='aktif' WHERE id_anggota='$id_anggota' ");
                    if ($sql) {
                        echo "<script>alert('Buka Blokir berhasil');document.location='user.php'</script>";
                    } else {
                        echo "<script>alert('Gagal Buka blokir');document.location='user.php'</script>";
                    }
                } elseif (isset($_GET['hapus'])) {
                    $hapus = $_GET['hapus'];
                    $sql = mysqli_query($conect, "DELETE FROM tb_anggota WHERE id_anggota='$hapus'");
                    if ($sql) {
                        echo "<script>alert('berhasil');document.location='user.php'</script>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>