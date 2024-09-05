<?php 
session_start();
// block user yang memaksa masuk tanpa login

if (!isset($_SESSION["login"]) && !isset($_SESSION["id_user"])) {
    header("Location: login.php");
    exit;
}

require 'functions.php';
// add data using id_user
if (isset($_POST["submitNickname"])) {
    if (updateNickname($_POST) > 0) {
        echo "
        <script>
            alert('data berhasil ditambahkan');
        </script>
    ";
    } else {
        echo "
        <script>
            alert('nickname/nama tim tidak bisa digunakan, coba masukan nama yang lain');
        </script>
    ";
    }
}

if (isset($_POST["submitNoTelp"])) {
    if (updateNoTelp($_POST) > 0) {
        echo "
        <script>
            alert('data berhasil ditambahkan');
        </script>
    ";
    } else {
        echo "
        <script>
            alert('nickname/nama tim tidak bisa digunakan, coba masukan nama yang lain');
        </script>
    ";
    }
}
$idUser = $_SESSION["id_user"];
$user = mysqli_query($conn, "SELECT * FROM tb_user WHERE id_user = $idUser");
$result = mysqli_fetch_assoc($user);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="fill_form.css">
    <title>Document</title>
</head>
<body>
    <div class="wrapper">
    <div class="center">
        <h4><?= $result["username"]; ?></h4>
        <p>Nickname/Nama Tim</p>
        <div class="text_field">
            <div><h3><?= $result["nickname"]; ?></h3></div>
            <button onclick="popupNickname()">ubah</button>
        </div>
        <p>Nomor Telepon</p>
        <div class="text_field">
            <div><h3><?= $result["no_telp"]; ?></h3></div>
            <button onclick="popupNoTelp()">ubah</button>
        </div>
        <button><a href="homepage.php">Kembali</a></button>
    <br><br><br><br><br>
    </div>

    <div id="overlay_nickname" class="overlay_nickname">
        <div id="popup_nickname">
            <form action="" method="post">
            <label for="nicknameInput">Nickname/Nama Tim:</label>
            <input type="text" id="nicknameInput" name="nicknameInput" required>
            <button type="submit" id="submitNickname" name="submitNickname">Submit</button>
            </form>
            <button onclick="closePopup()">Cancel</button>
        </div>
    </div>

    <div id="overlay_noTelp" class="overlay_noTelp">
        <div id="popup_noTelp">
            <form action="" method="post">
            <label for="noTelpInput">Nomor Telepon:</label>
            <input type="text" id="noTelpInput" name="no_telpInput" required>
            <button type="submit" id="submitNoTelp" name="submitNoTelp">Submit</button>
            </form>
            <button onclick="closePopup()">Cancel</button>
        </div>
    </div>
    <script src="fill_form.js"></script>
    </div>
</body>
</html>
