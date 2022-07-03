<?php include "../../koneksi.php";
session_start();
error_reporting(0);

if ($_SESSION['admin'] == "") {
    header("location:../index.php?pesan=gagal1");
}
$idadmin = $_SESSION['idadmin'];
$sql = mysqli_query($conect, "SELECT * FROM tb_admin WHERE id_admin='$idadmin'");
$admin = mysqli_fetch_array($sql);

$random_string = uniqid();

$tgl = date('Y-m-d H:i:s');

$judul = $_POST['judul'];
$isi = $_POST['isi'];
$kategori = $_POST['kategori'];

$foto = $_FILES['gambar']['tmp_name'];
$namafoto = $_FILES['gambar']['name'];

$ext = strtolower(end(explode(".", $namafoto)));
$newnama = $random_string . '.' . $ext;
$id = $_GET['id'];
$b = mysqli_fetch_array(mysqli_query($conect, "SELECT * FROM tb_berita WHERE id_berita='$id'"));
$gambarbaru = $_POST['gambarb'];
$idka = $b['id_kategori'];





if (isset($_POST['input'])) {

    if (empty($foto)) {

        $qus = mysqli_query($conect, "UPDATE `tb_berita` SET `id_berita`='$id',`id_kategori`='$kategori',`judul`='$judul',`txt_berita`='$isi' WHERE id_berita='$id'");
        if ($qus) {
            echo "<script>alert('input berhasil');document.location='berita.php'</script>";
        } else {
            echo "<script>alert('input gagal silahkan coba lagi');</script>";
        }
    } else {
        unlink('../../asset/gambar/' . $gambarbaru);
        move_uploaded_file($foto, '../../asset/gambar/' . $newnama);

        $sql = mysqli_query($conect, "UPDATE `tb_berita` SET `id_berita`='$id',`id_kategori`='$kategori',`judul`='$judul',`txt_berita`='$isi', `gambar`='$newnama' WHERE id_berita='$id'");
        if ($sql) {
            echo "<script>alert('input berhasil');document.location='berita.php'</script>";
        } else {
            echo "<script>alert('input gagal silahkan coba lagi');</script>";
        }
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
        <fieldset>
            <form action="" method="POST" autocomplete="off" enctype="multipart/form-data">

                <input type="text" name="judul" placeholder="Masukan Judul" value="<?= $b['judul']; ?>" size="50" required autocomplete="off">
                <br><br>
                <textarea name="isi" class="ckeditor" id="ckedtor" placeholder="Isi berita"><?= $b['txt_berita']; ?></textarea>
                <br>
                <label>pilih kategori</label>
                <select name="kategori" class="pilih">
                    <?php
                    $sql = mysqli_query($conect, "SELECT * FROM tb_kategori ");
                    while ($row = mysqli_fetch_array($sql)) {
                        if ($row['id_kategori'] == $idka) {
                            # code...
                    ?>
                            <option value="<?= $row['id_kategori']; ?>" selected><?= $row['kategori']; ?></option>
                        <?php } else { ?>
                            <option value="<?= $row['id_kategori']; ?>"><?= $row['kategori']; ?></option>
                        <?php } ?>

                    <?php } ?>
                </select>
                <br><br>
                <label>Masukan gambar</label>
                <input type="hidden" name="gambarb" value="<?= $b['gambar']; ?>">
                <input type="file" name="gambar" accept=".jpg, .png, .JPEG, .JPG, .PNG">
                <br>
                <button type="submit" name="input" class="bu50"><i class="fas fa-paper-plane"></i></button>
            </form>
        </fieldset>
    </div>
</body>

</html>