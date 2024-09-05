<?php 
session_start();
require 'functions.php';

if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];
    // cari data mahasiswa berdasarkan id
    // ambil username berdasarkan id
    $result = mysqli_query($conn, "SELECT id_user, username FROM tb_user WHERE id_user = $id");
    $row = mysqli_fetch_assoc($result);

    // cek username dan password
    if($key === hash('sha256', $row['username'])){
        $_SESSION['login'] = true;
    }
}

if(isset($_SESSION["login"])){
    header("Location: homepage.php");
    exit;
}

if(isset($_POST["login"])){
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM tb_user WHERE username = '$username'");

    if(mysqli_num_rows($result) === 1){
        $row = mysqli_fetch_assoc($result);
        if ($row["status"] === 'admin' && $password == $row["password"]) {
            $_SESSION["login_admin"] = true;
            header("Location: admin.php");
            exit;
        }

        // Verify hashed password for customer
        if ($row["status"] === 'customer' && password_verify($password, $row["password"])) {
            
            // Remember me functionality
            $_SESSION["login"] = true;
            $_SESSION["id_user"] = $row["id_user"];
            if (isset($_POST["remember"])) {
                // create cookies
                setcookie('id', $id, time()+60);
                setcookie('key', hash('sha256', $row['username']), time()+60);
            }
            header("Location: homepage.php");
            exit;
        }
     } 
    //  else {}
    
    // If username or password is incorrect
    // You might want to handle this case, e.g., display an error message
    $error = true;
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login form</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="stylelogin.css">

</head>

<body>
    <?php if(isset($error)) : ?>
        <?= "<script> alert('username/password salah')</script>" ?>
    <?php endif; ?>
    <div class="item-card">
        <div class="column">
            <h1>Login Your Account</h1>
                <p class="text">After login, you can enjoy the privileges</p>
            <div class="input-box">
                <form action="" method="post">
                    <div class="form-item">
                        <input type="text" class="form-element" placeholder="Username" id="username" name="username">
                    </div>

                    <div class="form-item">
                        <input type="password" class="form-element" placeholder="Password" id="password" name="password">
                    </div>

                    <div class="form-checkbox-item">
                        <input type="checkbox" id="rememberMe" checked>
                        <label for="rememberMe">Remember Me</label>
                    </div>

                    <div class="flex">
                        <button type="submit" name="login">Sign In</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="column">
            <h1>Welcome to HJR Futsal</h1>
            <p>if you don't have an account, would you like to register right now?</p>
            <a href="signup.php">Sign Up</a>
        </div>
    </div>
</body>

</html>