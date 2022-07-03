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
    <?php if (!$_GET['tampil']) {
    ?>
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
    <?php } ?>
    <div class="konten">
        <?php

        if (isset($_GET['tampil'])) {
            $tam = $_GET['tampil'];

            $pilih = mysqli_fetch_array(mysqli_query($conect, "SELECT * FROM tb_berita, tb_kategori, tb_admin WHERE tb_berita.id_kategori=tb_kategori.id_kategori AND tb_berita.id_admin=tb_admin.id_admin AND id_berita = $tam"));
        ?>
            <div class="blog">
                <a href="berita.php" style="font-size: 40px;"><i class="fas fa-long-arrow-alt-left"></i> kembali</a>
                <div class="conteudo">

                    <div class="post-info">
                        Di Posting Oleh <b><?= $pilih['nama_lengkap']; ?></b>
                    </div>
                    <h3><?php echo $pilih['judul']; ?></h3>
                    <img src="../../asset/gambar/<?= $pilih['gambar']; ?>">
                    <p><?php echo $pilih['txt_berita']; ?></p>

                </div>
                <div class="conteudo">
                    <h4>komentar</h4>
                    <?php
                    $id = $_GET['id'];
                    $sql3 = mysqli_query($conect, "SELECT * FROM tb_komentar WHERE id_berita='$tam' ORDER BY id_komentar desc ");
                    $u = mysqli_num_rows($sql3);

                    while ($kom = mysqli_fetch_assoc($sql3)) {
                    ?>

                        <hr>
                        <div class="posi"> <a href="?hapus=<?= $kom['id_komentar']; ?>">
                                <div class="hapus"></div>
                            </a></div>
                        <p><?= $kom['isi_komentar']; ?></p>


                        <p style="font-size: 10px;">dari : <?= $kom['email']; ?> <?= $kom['tgl_komentar']; ?></p>

                        <hr>
                    <?php } ?>
                </div>
            </div>
        <?php } else { ?>

            <fieldset>
                <legend><a href="inputberita.php">
                        <div class="tambahform"></div>
                    </a></legend>
                <form action="" method="get">
                    <input type="text" name="caridata" size="24" required>
                    <button name="cari" style="background: none; border: none;"><i class='fas fa-search'></i></button>
                    <br><br>
                </form>
                <form action="" method="GET">
                    <select name="daf_kate">
                        <option>Kategori</option>
                        <?php $sqlka = mysqli_query($conect, "SELECT * FROM tb_kategori");
                        while($kate = mysqli_fetch_array($sqlka)){ ?>
                        <option value="<?php echo $kate['id_kategori'] ?>"><?php echo $kate['kategori']; ?></option>
                        <?php } ?>
                    </select>
                    <button name="pilih" class="biru">Pilih</button>
                </form>
                <br>
                <table border="1" class="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>DI posting oleh</th>
                            <th>Tgl</th>
                            <th>Status</th>
                            <th>Pilih</th>


                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $i = 1;
                        $sql = mysqli_query($conect, "SELECT * FROM tb_berita, tb_admin WHERE tb_berita.id_admin=tb_admin.id_admin ORDER BY id_berita desc");
                        if (isset($_GET['cari'])) {
                            $coco = $_GET['caridata'];
                            $sql = mysqli_query($conect, "SELECT * FROM tb_berita, tb_admin WHERE tb_berita.id_admin=tb_admin.id_admin and judul LIKE '%$coco%' OR id_berita LIKE '%$coco%' OR tgl_posting LIKE '%$coco%'");
                            $hitung = mysqli_num_rows($sql);
                            if ($hitung == null) {
                                echo "<script>alert('tidak ada');document.location='berita.php'</script>";
                            }
                        }elseif(isset($_GET['pilih'])){
                            $idkategori = $_GET['daf_kate'];
                            $sql = mysqli_query($conect, "SELECT * FROM tb_berita, tb_admin WHERE tb_berita.id_admin=tb_admin.id_admin and id_kategori='$idkategori' ORDER BY id_berita desc");
                        }
                        while ($row = mysqli_fetch_array($sql)) { ?>

                            <tr>
                                <td><?php echo $i++ ?></td>
                                <td><?= $row['judul']; ?></td>
                                <td><?= $row['nama_lengkap']; ?></td>
                                <td><?= $row['tgl_posting']; ?></td>
                                <td><?php if ($row['status'] == 'aktif') { ?>
                                        <a href="?matikan=<?= $row['id_berita']; ?>" class="hijau">on</a><?php } else { ?>
                                        <a href="?aktifkan=<?= $row['id_berita']; ?>" class="merah">off</a><?php } ?>
                                </td>
                                <td><a href="?tampil=<?= $row['id_berita']; ?>" class="biru">pilih</a></td>
                                <td><a class="hijau" href="editberita.php?id=<?= $row['id_berita']; ?>" title="edit">
                                <i class="fas fa-edit"></i></a></td>

                                <td><a class="merah" href="hapusberita.php?id=<?= $row['id_berita']; ?>" title="hapus">
                                <i class="fas fa-trash-alt"></i></a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table><br> <br><br>
            </fieldset>
        <?php }

        if (isset($_GET['aktifkan'])) {
            $idb = $_GET['aktifkan'];
            $nyala = mysqli_query($conect, "UPDATE tb_berita SET status='aktif' WHERE id_berita='$idb'");
            if ($nyala) {
                echo "<script>alert('Berita aktif');document.location='berita.php'</script>";
            }
        } elseif (isset($_GET['matikan'])) {
            $idb = $_GET['matikan'];
            echo var_dump($id_b);
            $nyala = mysqli_query($conect, "UPDATE tb_berita SET status='tidak aktif' WHERE id_berita='$idb'");
            if ($nyala) {
                echo "<script>alert('Berita dimatikan');document.location='berita.php'</script>";
            }
        }
        ?>
    </div>
</body>

</html>
<?php

if (isset($_GET['hapus'])) {

    $hapus = $_GET['hapus'];
    $sql = mysqli_query($conect, "DELETE FROM tb_komentar WHERE id_komentar = '$hapus'");
    if ($sql) {
        echo "<script>alert('hapus berhasil');document.location='berita.php?tampil=$tam'</script>";
    } else {
        echo "<script>alert('hapus gagal');document.location='berita.php'</script>";
    }
}

?>