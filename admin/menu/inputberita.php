<?php include "../../koneksi.php";
session_start();
error_reporting(0);

if ($_SESSION['admin'] == "") {
    header("location:../index.php?pesan=gagal1");
}
$idadmin = $_SESSION['idadmin'];
$ssql = mysqli_query($conect, "SELECT * FROM tb_admin WHERE id_admin='$idadmin'");
$admin = mysqli_fetch_array($ssql);


$random_string = uniqid();
date_default_timezone_set("Asia/Jakarta");
$sql = mysqli_query($conect, "SELECT * FROM tb_admin");
$row = mysqli_fetch_array($sql);
$tgl = date('Y-m-d H:i:s');

$judul = $_POST['judul'];
$isi = $_POST['isi'];
$kategori = $_POST['kategori'];

$foto = $_FILES['gambar']['tmp_name'];
$namafoto = $_FILES['gambar']['name'];

$ext = end(explode(".", $namafoto));
$newnama = $random_string . '.' . $ext;

if (isset($_POST['input'])) {
    move_uploaded_file($foto, '../../asset/gambar/' . $newnama);



    $sql = mysqli_query($conect, "INSERT INTO `tb_berita`(`id_berita`, `id_kategori`, `id_admin`, `judul`, `tgl_posting`, `txt_berita`, `gambar`) VALUES ('','$kategori','$idadmin','$judul','$tgl','$isi','$newnama')");
    if ($sql) {
        echo "<script>alert('input berhasil');document.location='berita.php'</script>";
    } else {
        echo "<script>alert('input gagal silahkan coba lagi');</script>";
    }
}
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
    <script type="text/javascript" src="../../ckeditor/ckeditor.js"></script>

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
        <a href="berita.php" style="font-size: 15px;"><i class="fas fa-long-arrow-alt-left"></i> kembali</a>
        <fieldset>
            <legend>Input berita</legend>
            <form action="" method="POST" autocomplete="off" enctype="multipart/form-data">
                <input type="text" name="judul" placeholder="Masukan Judul" size="50" required autocomplete="off">
                <br><br>
                <textarea name="isi" class="ckeditor" id="ckedtor"></textarea>
                <br>
                <label>pilih kategori</label>
                <select class="pilih" name="kategori" required>
                    <?php
                    $sql = mysqli_query($conect, "SELECT * FROM `tb_kategori` ORDER BY id_kategori DESC");
                    while ($row = mysqli_fetch_array($sql)) { ?>
                        <option value="<?= $row['id_kategori']; ?>"><?= $row['kategori']; ?></option>
                    <?php } ?>
                </select>
                <br><br>
                <label>Masukan gambar</label>
                <input class="foto" type="file" name="gambar" accept=".jpg, .png, .JPEG, .JPG, .PNG" required>
                <br>
                <button type="submit" name="input" class="bu50"><i class="fas fa-paper-plane"></i></button>
            </form>
        </fieldset>
        <br><br>
        <fieldset>
            <?php
            if (isset($_POST['kate'])) {
                $kategori = $_POST['kategori'];
                $sqli = mysqli_query($conect, "INSERT INTO tb_kategori (id_kategori,kategori) VALUES ('','$kategori')");
                if ($sqli) {
                    echo "<script>alert('input berhasil');document.location='inputberita.php'</script>";
                } else {
                    echo "<script>alert('gagal');document.location='inputberita.php'</script>";
                }
            } elseif (isset($_POST['editkate'])) {
                $kategori = $_POST['kategori'];
                $isikate = $_GET['isikate'];
                $sqli = mysqli_query($conect, "UPDATE tb_kategori set kategori='$kategori' WHERE id_kategori='$isikate' ");
                if ($sqli) {
                    echo "<script>alert('edit berhasil');document.location='inputberita.php'</script>";
                }
            } elseif (isset($_POST['hapuskate'])) {

                $isikate = $_GET['isikate'];
                $sqli = mysqli_query($conect, " DELETE FROM tb_kategori WHERE id_kategori='$isikate' ");
                if ($sqli) {
                    echo "<script>alert('hapus berhasil');document.location='inputberita.php'</script>";
                }
            }
            ?>
            <legend>Input Kategoti</legend>
            <form action="" method="POST">
                <?php if (isset($_GET['isikate'])) {
                    $isikate = $_GET['isikate'];
                    $my = mysqli_fetch_array(mysqli_query($conect, "SELECT * FROM tb_kategori WHERE id_kategori='$isikate'"));
                } ?>
                <input type="text" name="kategori" placeholder="input kategori" class="input-200px" required autocomplete="off" value="<?php echo $my['kategori']; ?>">

                <button name="kate" class="biru"><i class="fas fa-paper-plane"></i></button>
                <button name="editkate" class="hijau">edit</button>
                <button name="hapuskate" class="merah">hapus</button>
                <br>
            </form>
            <br>
            <br>
            <?php
            $tampilkate = mysqli_query($conect, "SELECT * FROM tb_kategori");
            while ($katego = mysqli_fetch_array($tampilkate)) {
            ?>
                <hr>
                <p>
                    <a href="?isikate=<?= $katego['id_kategori']; ?>">
                        <p><?php echo $katego['kategori']; ?>
                    </a>
                </p>
                </p>
                <hr>
            <?php } ?>

        </fieldset>
    </div>
</body>

</html>