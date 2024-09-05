<?php
session_start();
// block user yang memaksa masuk tanpa login
if (!isset($_SESSION["login"]) && !isset($_SESSION["id_user"])) {
    header("Location: login.php");
    exit;
}

require 'functions.php';

$produk = query("SELECT tb_produk.id_lapangan, tb_produk.id_produk, tb_waktu.nm_waktu, tb_produk.harga, tb_produk.ketersediaan FROM tb_produk, tb_waktu WHERE tb_produk.id_waktu = tb_waktu.id_waktu AND tb_produk.id_lapangan LIKE 'L01';");

$produk2 = query("SELECT tb_produk.id_lapangan, tb_produk.id_produk, tb_waktu.nm_waktu, tb_produk.harga, tb_produk.ketersediaan FROM tb_produk, tb_waktu WHERE tb_produk.id_waktu = tb_waktu.id_waktu AND tb_produk.id_lapangan LIKE 'L02';");

// disable schedule
$today = date('Y-m-d');
if (isset($_POST["cek"]) && !empty($_POST["date"])) {
    $sometime = $_POST["date"];
} else {
    $sometime = date('Y-m-d', strtotime('+1 day'));

}

$parse_today = date_parse($today);
$parse_sometime = date_parse($sometime);

// value for pesan
$day = $parse_today["day"] + 1;
$value2 = $parse_today["year"]."-".$parse_today["month"]."-".$day;

// format date for keranjang and pop up mesagge while reserving
$date_string = new datetime($sometime);
$formated_date = $date_string->format('d F Y');

$transaksi = query("SELECT * FROM tb_transaksi WHERE ttg_datang LIKE '$sometime';");

$count_produk = mysqli_query($conn, "SELECT tb_produk.id_lapangan,tb_produk.id_produk, tb_waktu.nm_waktu, tb_produk.harga, tb_produk.ketersediaan FROM tb_produk, tb_waktu WHERE tb_produk.id_waktu = tb_waktu.id_waktu AND tb_produk.ketersediaan = TRUE AND tb_produk.id_lapangan LIKE 'L01';");
$info1 = mysqli_query($conn, "SELECT tb_transaksi.id_produk, tb_produk.id_lapangan, tb_transaksi.ttg_datang, tb_produk.ketersediaan FROM tb_transaksi, tb_produk WHERE tb_transaksi.ttg_datang LIKE '$sometime' AND tb_produk.id_produk = tb_transaksi.id_produk AND tb_produk.ketersediaan = TRUE AND tb_produk.id_lapangan = 'L01';");
$count_info1 = mysqli_num_rows($count_produk) - mysqli_num_rows($info1);

$count_produk2 = mysqli_query($conn, "SELECT tb_produk.id_lapangan,tb_produk.id_produk, tb_waktu.nm_waktu, tb_produk.harga, tb_produk.ketersediaan FROM tb_produk, tb_waktu WHERE tb_produk.id_waktu = tb_waktu.id_waktu AND tb_produk.ketersediaan = TRUE AND tb_produk.id_lapangan LIKE 'L02';");
$info2 = mysqli_query($conn, "SELECT tb_transaksi.id_produk, tb_produk.id_lapangan, tb_transaksi.ttg_datang, tb_produk.ketersediaan FROM tb_transaksi, tb_produk WHERE tb_transaksi.ttg_datang LIKE '$sometime' AND tb_produk.id_produk = tb_transaksi.id_produk AND tb_produk.ketersediaan = TRUE AND tb_produk.id_lapangan = 'L02';");
$count_info2 = mysqli_num_rows($count_produk2) - mysqli_num_rows($info2);

if(($parse_sometime["year"] - $parse_today["year"]) > 0){
    $reserved = false;
} 
else if (($parse_sometime["year"] - $parse_today["year"]) <= 0) {
    $reserved = true;
    if(($parse_sometime["month"] - $parse_today["month"]) >= 0){
        $reserved = false;
        if(($parse_sometime["day"] - $parse_today["day"]) > 0) {
            $reserved = false;
        }
        else if(($parse_sometime["day"] - $parse_today["day"]) <= 0){
            $reserved = true;   
        }
    } 
    else if (($parse_sometime["month"] - $parse_today["month"]) < 0) {
        $reserved = true;
    }
} 
else {
    $reserved = true;
}

if($reserved === true){
    $count_info1 = 0;
    $count_info2 = 0;
}


if(isset($_POST["reserve"])){
    $id_produk = $_POST["reserve"];
    $result = mysqli_query($conn, "SELECT id_produk, nm_produk FROM tb_produk WHERE id_produk = '$id_produk';");
    $row = mysqli_fetch_assoc($result);
    $nm_produk = $row["nm_produk"];
    if(reserve($_POST) === 1 ){
        echo "
        <script>
            alert('berhasil memesan $nm_produk pada tanggal $formated_date');
            document.location.href = 'homepage.php';
        </script>
    ";
    } else if (reserve($_POST) === 2) {
        echo "
        <script>
            if( confirm('Oppss anda belum melengkapi data. anda ingin melengkapinya sekarang ?')){
                window.location = 'fill_form.php';
            } else {
                window.location = 'homepage.php';
            }
        </script>
    ";
    }
    else {
        echo "
        <script>
            alert('gagal memesan $nm_produk');
            document.location.href = 'homepage.php';
        </script>
    ";
    }
}

// for keranjang fitur
$idUser = $_SESSION["id_user"];
$transaksi_user = query("SELECT tb_transaksi.id_user, tb_transaksi.id_produk, tb_produk.id_produk, tb_produk.nm_produk, tb_transaksi.ttg_datang FROM tb_transaksi, tb_produk WHERE tb_transaksi.id_user = $idUser AND tb_transaksi.id_produk = tb_produk.id_produk");

if(isset($_POST["delete"])){
    if (deleteReserve($_POST) >= 0) {
            echo "
            <script>
                alert('jadwal berhasil dihapus');
                document.location.href = 'homepage.php';
            </script>
        ";
        } else {
            echo "
            <script>
                alert('jadwal gagal dihapus');
            </script>
        ";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="homepage_new.css">
    <title>E-Booking Sport Arena</title>
</head>


<!-- BAGIAN NAVBAR START -->

<body>
<div class="overlay" id="overlay"></div>
    <header class="header1">
        <img src="img/65df1d24-3370-4212-8c15-94b633c4a1e7 [FDB0935].png" alt="" class="logo">
        <nav>
            <ul class="nav_links">
                <li><a href="homepage.php">Home</a></li>
                <li class="dropdown">
                    <a href="fill_form.php">profil</a>
                </li>
                <li class="dropdown">
                    <a href="facilities.php">Fasilitas</a>
                </li>
            </ul>
        </nav>

        <div class="ikon">
            <span class="logoBelanja" id="cartIcon">
                <i class="fa-solid fa-cart-shopping" style="color: #000000;"></i>
            </span>
        </div>

        <a href="logout.php" class="btn_logout">Log out</a>
    </header>

    <header class="thumbnail">
        <h3>Selamat Datang di</h3>
        <h1>HJR FUTSAL</h1>
        <h2 class="h2Class">Silahkan Lengkapi Profil Anda Terlebih Dahulu</h2>
        <button class="buttonLengkapi" onclick="tambahData()">
            <span class="button__text">Lengkapi Sekarang</span>
            <span class="button__icon">
                <i class="fa-solid fa-arrow-right" style="color: white;"></i>
            </span>
        </button>
    </header>
    <!-- BAGIAN NAVBAR END -->
    <!-- NAV BAR CONTENT -->
    <!-- 1. FITUR KERANJANG -->
    <div class="deskripsi_pesanan" id="sidebar">
        <div class="icon_exit">
            <h2>JADWAL DIPILIH</h2>
            <span ><i class="fa-solid fa-x" style="color: #000000;"></i></span>
        </div>
        <?php $j = 1 ?>
            <?php foreach ($transaksi_user as $row) : ?>
                <?php 
                        $parse_tanggal_keranjang = date_parse($row["ttg_datang"]);
                        if(($parse_tanggal_keranjang["year"] - $parse_today["year"]) > 0){
                            $keranjang = true;
                        } 
                        else if (($parse_tanggal_keranjang["year"] - $parse_today["year"]) <= 0) {
                            $keranjang = false;
                            if(($parse_tanggal_keranjang["month"] - $parse_today["month"]) >= 0){
                                $keranjang = true;
                                if(($parse_tanggal_keranjang["day"] - $parse_today["day"]) > 0) {
                                    $keranjang = true;
                                }
                                else if(($parse_tanggal_keranjang["day"] - $parse_today["day"]) <= 0){
                                    $keranjang = false;   
                                }
                            } 
                            else if (($parse_tanggal_keranjang["month"] - $parse_today["month"]) < 0) {
                                $keranjang = false;
                            }
                        } 
                        else {
                            $keranjang = false;
                        }
                        $tanggal = new datetime($row["ttg_datang"]);
                        $formated = $tanggal->format('d F Y');
                    ?> 
                <?php if ($keranjang === true) : ?>    
                    <div class="row">
                        <p><?= $j ?></p>
                        <p><?= $row["nm_produk"];  ?></p>
                        <br>
                        <p>tanggal : <?= $formated ?></p>
                    </div>
                <?php $j += 1; ?>
                <form action="" method="post">
                    <input type="hidden" name="id_user" id="id_user" value=<?= $idUser ?>>
                    <input type="hidden" name="id_produk" id="id_produk" value="<?= $row['id_produk']; ?>">
                    <input type="hidden" name="ttg_datang" id="ttg_datang" value="<?= $row['ttg_datang']; ?>">
                    <button type="submit" name="delete" id="delete">Batalkan</button>
                </form>
            <?php endif; ?>
            <?php endforeach; ?>
    </div>


    <!-- BAGIAN KALENDER START -->
    <main>
        <form action="" method="post">
        <div class="container_calendar" style="display: block;">
            <div class="item_date">
                    <input type="date" id="date" name="date" placeholder="<?= $placeholder_date; ?>" value="<?= isset($_POST["date"]) ? $_POST["date"] : $sometime ?>"> 
                    <button type="submit" name="cek" class="btn_cek">Booking Sekarang</button>
            </div>

            <div class="harga_lapangan">
                <img src="img/harga_lapangan.png" alt="" style="width:100%; height: auto;">
            </div>
        </div>
        <!-- BAGIAN KALENDER END -->
        <!-- BAGIAN HARGA LAPANGAN -->
       
        <!-- HARGA LAPANGAN END -->
        <!-- BAGIAN LAPANGAN 1 START-->
        <div class="containerLap">
            <div class="info1">
                <div class="fotolap">
                    <img src="img/lapangan a.jpg" alt="" class="lapangan1">
                </div>
                <div class="batas2"></div>
                <div class="deskripsi" id="deskripsi1">
                    <h4>Lapangan A</h4>
                    <p class="infolapangan">Lapangan Depan</p>

                    <!--BAGIAN ICON LAP 1 START-->
                    <div class="futsal">
                        <span class="icon_piala">
                            <i class="fa-solid fa-trophy" style="color: #000000;"></i>
                        </span>
                        <p>Futsal</p>
                    </div>
                    <div class="position">
                        <span class="icon_posisi">
                            <i class="fa-solid fa-map-pin" style="color: #000000;"></i>
                        </span>
                        <p>Indor</p>
                    </div>
                    <div class="interlock">
                        <span class="icon_menu">
                            <i class="fa-solid fa-bars" style="color: #000000;"></i>
                        </span>
                        <p>Premium Interlock</p>
                    </div>
                    <div class="btnketerangan" onclick="toggleDropdown1()">Jadwal Tersedia (<?= $count_info1 ?>)</div>
                    <!--BAGIAN ICON LAP 1 END-->

                    <!-- BAGIAN WAKTU LAP 1 START -->
                    <div class="container_utama_waktu">
                        <div class="container_waktu">
                            <?php foreach ($produk as $row) : ?>
                                <?php if($row["ketersediaan"] == 1) : ?>    
                                    <?php $isReserved = $reserved; ?>
                                    <?php foreach ($transaksi as $transaksiRow) : ?>
                                        <?php if ($transaksiRow["id_produk"] == $row["id_produk"]) : ?>
                                            <?php $isReserved = true; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <div class="setPosisi_waktu">
                                        <button class="btn_jadwal" value="<?= $row["id_produk"]; ?>" id="reserve" name="reserve" <?= $isReserved ? 'disabled' : ''; ?>>
                                            Rp. <?= $row["harga"]; ?>
                                            <br>
                                            <br>
                                            <br>
                                            <?= $row["nm_waktu"] ?>
                                        </button>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <!-- BAGIAN WAKTU LAP 1 END -->
                </div>
            </div>
            <div class="batas3"></div>
            <!-- BAGIAN LAPANGAN 1 END-->


            <!-- BAGIAN LAPANGAN 2 START-->
            <div class="info1">
                <div class="fotolap2">
                    <img src="img/lapangan b.jpg" alt="" class="lapangan2">
                </div>
                <div class="batas2"></div>
                <div class="deskripsi" id="deskripsi2">
                    <h4>Lapangan B</h4>
                    <p class="infolapangan">Lapangan Belakang</p>

                    <!-- BAGIAN ICON LAP 2 START-->
                    <div class="futsal">
                        <span class="icon_piala">
                            <i class="fa-solid fa-trophy" style="color: #000000;"></i>
                        </span>
                        <p>Futsal</p>
                    </div>
                    <div class="position">
                        <span class="icon_posisi">
                            <i class="fa-solid fa-map-pin" style="color: #000000;"></i>
                        </span>
                        <p>Indor</p>
                    </div>
                    <div class="interlock">
                        <span class="icon_menu">
                            <i class="fa-solid fa-bars" style="color: #000000;"></i>
                        </span>
                        <p>Karpet Vinyl</p>
                    </div>
                    <div class="btnketerangan" onclick="toggleDropdown2()">Jadwal Tersedia (<?= $count_info2 ?>)</div>
                    <!-- BAGIAN ICON LAP 2 END-->


                    <!-- BAGIAN WAKTU LAP 2 START -->
                    <div class="container_utama_waktu">
                        <div class="container_waktu">
                        <?php foreach ($produk2 as $row) : ?>
                            <?php if($row["ketersediaan"] == 1) : ?> 
                                <?php $isReserved = $reserved; ?>
                                    <?php foreach ($transaksi as $transaksiRow) : ?>
                                        <?php if ($transaksiRow["id_produk"] == $row["id_produk"]) : ?>
                                            <?php $isReserved = true; ?>
                                            <?php break; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>

                                    <div class="setPosisi_waktu"> 
                                    <button class="btn_jadwal" value="<?= $row["id_produk"]; ?>" id="reserve" name="reserve" <?= $isReserved ? 'disabled' : ''; ?>>
                                            Rp. <?= $row["harga"]; ?>
                                            <br>
                                            <br>
                                            <br>
                                            <?= $row["nm_waktu"] ?>
                                    </button>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <!-- BAGIAN WAKTU LAP 2 END -->
                </div>
            </div>
            <div class="batas3"></div>
            <!-- BAGIAN LAPANGAN 2 END-->
                </div>
            </div>
        </div>
        <br><br><br><br><br>
        <script src="script_homepage.js"></script>
    </form>
    </main>
</body>

</html>

