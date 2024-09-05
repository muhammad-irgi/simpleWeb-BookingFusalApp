<?php 
session_start();
// block user yang memaksa masuk tanpa login
if (!isset($_SESSION["login_admin"])) {
    header("Location: login.php");
    exit;
}

require 'functions.php';

$today = date('Y-m-d');
$pesanan = query("select tb_transaksi.id_user, tb_transaksi.id_produk, tb_user.nickname, tb_user.no_telp, tb_produk.nm_produk, tb_transaksi.ttg_datang from tb_transaksi, tb_produk, tb_user where tb_transaksi.id_user = tb_user.id_user and tb_transaksi.id_produk = tb_produk.id_produk AND tb_transaksi.ttg_datang = '$today'");

// searching fiturs
if (isset($_POST["cari"])) {
    // go to cari function
    $pesanan = cari($_POST["keyword"]);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <link rel="stylesheet" href="adminn.css">
    <title>Admin Page</title>
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
                            <span class="update"><a href="update_page.php">Update</a></span>
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
                        <?php if (!isset($_POST["cari"])) : ?>
                            <p class="p_menampilkan_jadwal">Menampilkan jadwal hari ini : </p>
                            <?php else : ?>
                            <p></p>
                        <?php endif; ?>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Nama Tim</td>
                                <td>No Telepon</td>
                                <td>Pesanan</td>
                                <td>Tanggal Pesanan</td>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php $i = 1; ?>
                                <?php foreach ($pesanan as $row) : ?>
                                    <tr>
                                        <td><?= $i ?> .</td>
                                        <td><?= $row["nickname"]; ?></td>
                                        <td><?= $row["no_telp"]; ?></td>
                                        <td><?= $row["nm_produk"]; ?></td>
                                        <td><?= $row["ttg_datang"]; ?></td>
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