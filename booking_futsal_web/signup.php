<?php 
    require 'functions.php';

    if(isset($_POST["register"])){
        if (registrasi($_POST) > 0) {
            echo "<script>
                alert('user baru berhasil ditambahkan');
            </script>";
            header("Location: homepage.php");
        }else {
            echo mysqli_error($conn);

        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style_register.css">
</head>
<body>
    <div class="item-card">
        <div class="column">
            <h1>Create New Account</h1>
            <div class="text">
                <p>if you have already an account<br></p>
                <a href="login.html">Sign in</a>
                <p>here</p>
            </div>
            <div class="input-box">
                <form action="" method="post">
                    <div class="form-item">
                        <input type="email" class="form-element" placeholder="E-Mail" id="username" name="username">
                    </div>

                    <div class="form-item">
                        <input type="password" class="form-element" placeholder="Password" id="password" name="password">
                    </div>

                    <div class="form-item">
                        <input type="password" class="form-element" placeholder="Konfirmasi Password" id="password2" name="password2">
                    </div>

                    <div class="form-checkbox-item">
                        <input type="checkbox" id="rememberMe" checked>
                        <label for="rememberMe">I've read and agree with Terms of Service and our Privacy Policy</label>
                    </div>

                    <div class="flex">
                        <button type="submit" id="regiter" name="register">Create an account</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="column">
            <h1>Welcome</h1>
            <p>Join us and enjoy the convenience of booking futsal courts.</p>
        </div>
    </div>
</body>
</html>