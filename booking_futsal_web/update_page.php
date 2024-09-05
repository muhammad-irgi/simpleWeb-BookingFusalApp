<?php 
session_start();
// block user yang memaksa masuk tanpa login
if (!isset($_SESSION["login_admin"])) {
    header("Location: login.php");
    exit;
}

require 'functions.php';

// open-close schedule
if (isset($_POST['triger'])) {
    list($openClose, $msg) = openClose($_POST);
    if($openClose == 1 && $msg == false) {
        echo "
        <script>
            alert('jadwal berhasil ditutup');
        </script>
    ";
    }else if($openClose == 1 && $msg == true) {
        echo "
        <script>
            alert('jadwal berhasil dibuka');
        </script>
    ";
    } else {
        echo "
        <script>
            alert('jadwal gagal diubah');
        </script>
    ";
    }
}
// change price schedule
if(isset($_POST["submit"])){
    if (update_harga($_POST) >= 0) {
        echo "
        <script>
            alert('data berhasil diubah');
        </script>
    ";
    } else {
        echo "
        <script>
            alert('data gagal diubah');
        </script>
    ";
    }   
}

// Pagination
$jumlahDataPerHalaman = 24;
$jumlahData = count(query("SELECT * FROM tb_produk"));
$jumlahHalaman = 2;
$nomor_halaman = 1;
if (isset($_GET['page'])) {
    $_GET['page'];   
    if ($_GET['page'] == 'Lapangan-A') {
        $nomor_halaman = 1;
    } 
    if ($_GET['page'] == 'Lapangan-B'){
        $nomor_halaman = 2;
    }
} else {
    $nomor_halaman = 1;
}
$acctivePage = (isset($_GET['page'])) ? $_GET['page'] : 'lapangan-A';
$awalData = ($jumlahDataPerHalaman * $nomor_halaman) - $jumlahDataPerHalaman;

$produk = query("SELECT * FROM tb_produk ORDER BY id_produk ASC LIMIT $awalData, $jumlahDataPerHalaman");



if (isset($_POST["cari"])) {
    // go to cari function
    $produk = cari_update($_POST["keyword"]);
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <link rel="stylesheet" href="update_style_baru.css">
    <title>Update Page</title>
    <script src="update_script.js"></script>
</head>
<body>
    <!-- Navigation -->
    <div class="container">
        <div class="navigation">
            	<ul>
                    <img src="img/65df1d24-3370-4212-8c15-94b633c4a1e7 [FDB0935].png" alt="" class="logo">
                    <li>
                        <a href="#" class="text_decoration">
                            <span class="icon_up">
                                <i class="fa-regular fa-pen-to-square" style="color: #ffffff;"></i>
                            </span>                            
                            <span class="update"><a href="admin.php">Kembali</a></span>
                        </a>
                    </li>
                    <button class="log_out">
                        <span class="iconButton">
                            <i class="fa-solid fa-right-from-bracket" style="color: #000000;"></i>
                        </span>
                        <span class="textButton"><a href="logout.php">Log out</a></span>
                    </button>
                </ul>
        </div>
        
        <!-- Main -->
        <div class="main">
            <div class="topbar">
                <!-- UNTUK FITUR SEARCHNYA MENGGUNAKAN FORM JADI YANG SEKARANG MALAH BERUBAH -->
                    <form class="search" method="post" action="">
                        <input type="text" placeholder="Search Here" name="keyword" id="keyword">
                        <i class="fa-solid fa-magnifying-glass" style="color: #000000;"></i>
                        <button type="submit" name="cari" class="btn_cari">Cari</button>
                    </form>
            </div>

            <!-- Tabel List -->
            <div class="tabelList">
                <div class="detail">
                    <div class="headerTabel">
                        <h4 class="judul_table">List Table</h4>
                            <!-- pagination -->
                            <br>
                            <?php if(!isset($_POST['cari'])) : ?>
                                <div class="halaman" id="lapanganA"><a href="?page=Lapangan-A" id="anchorA" class="anchor">Lapangan A</a></div>
                                <div class="halaman" id="lapanganB"><a href="?page=Lapangan-B" id="anchorB" class="anchor">Lapangan B</a></div>
                            <?php endif; ?>
                            <br>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>nama produk</td>
                                <td>harga</td>
                                <td>Update harga</td>
                                <td>buka</td>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php $i = 1; ?>
                                <?php foreach ($produk as $row) : ?>
                                    <tr>
                                        <td><?= $i ?> .</td>
                                        <td><?= $row["nm_produk"]; ?></td>
                                        <td><?= $row["harga"]; ?></td>
                                        <form action="" method="post">
                                        <td>
                                            <input type="hidden" name="id_produk" id="id_produk" value="<?=$row['id_produk']; ?>">
                                            <input type="number"  name="harga" id="harga" placeholder="input new price" required>
                                            <button type="submit" id="submit" name="submit">OK</button>
                                        </form>
                                        </td>
                                        <td>
                                        <form action="" method="post">           
                                            <input type="hidden" name="id_produk" id="id_produk" value="<?=$row['id_produk']; ?>">
                                            <input type="hidden" name="ketersediaan" id="ketersediaan" value="<?=$row['ketersediaan']; ?>">
                                            <button type="submit" id="triger" name="triger"><?= ($row["ketersediaan"] == 1) ? 'Tutup' : 'Buka' ?></button>
                                        </form>
                                        </td>
                                </tr>
                                <?php $i++ ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
   
</body>
</html>