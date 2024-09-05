<?php 
session_start();
// block user yang memaksa masuk tanpa login
if(!isset($_SESSION["login_admin"])){
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Selamat datang di halaman admin</h1>
    <div class="logout" style="padding: 10px;">
        <a href="logout.php">Log Out</a>
    </div>
</body>
</html>