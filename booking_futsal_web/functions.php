<?php 
// koneksi ke database
$conn = mysqli_connect('localhost','root','','booking_futsal');

function query($query){
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }
    return $rows;
}

function registrasi($data){
    global $conn;
    $username = stripcslashes($data["username"]);
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);


    if ($password !== $password2) {
        echo "<script>
                alert('konvirmasi password tidak sesuai');
        </script>";
        return false;
    }

    //check username is exist for dont duplicate
    $result = mysqli_query($conn, "SELECT username FROM tb_user WHERE username = '$username'");
    if(mysqli_fetch_assoc($result)){
        echo "<script>
            alert('email sudah terdaftar');
        </script>";
        
        return false;
    }


    // enskripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);
    
    if($username == "" OR $password == "" OR $password2 == ""){
        echo "<script>
        alert('silahkan isi username dan password terlebih dahulu');
        </script>";
    }else{
        //tambahkan userbaru ke database
        mysqli_query($conn, "INSERT INTO tb_user (username, password, status) VALUES('$username','$password', 'customer')");
        return mysqli_affected_rows($conn);
    }
    
}

function updateNickname($data){
    global $conn;

    $idUser = $_SESSION["id_user"];
    $nickname = htmlspecialchars($data["nicknameInput"]);

    $command = "SELECT * FROM tb_user WHERE nickname = '$nickname'";
    $validasi = query($command);
    if(count($validasi) == 0){
        $query = "UPDATE tb_user SET 
                nickname = '$nickname'
            WHERE id_user = $idUser
            ";  
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    } else {
        return -2;
    }      
}


function updateNoTelp($data){
    global $conn;

    $idUser = $_SESSION["id_user"];
    $noTelp = $data["no_telpInput"];

    $query = "UPDATE tb_user SET 
            no_telp = '$noTelp'
        WHERE id_user = $idUser
        ";  
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);    
}


function reserve($data){
    global $conn;
    $idUser = $_SESSION["id_user"];
    $id_produk = $data["reserve"];
    $ttg_datang = $data["date"];

    $command = "SELECT * FROM tb_user WHERE id_user = $idUser;";
    $tb_user = mysqli_query($conn, $command);
    $tb_user_row = mysqli_fetch_assoc($tb_user);

    if(!$tb_user_row["nickname"] == null && !$tb_user_row["no_telp"] == null){
        $query = "INSERT INTO tb_transaksi VALUES ('$idUser', '$id_produk', '$ttg_datang')";
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    } else {
        return 2;
    }

    // query insert data
}

function cari($keyword){
    $query = "SELECT tb_transaksi.id_user, tb_transaksi.id_produk, tb_user.nickname, tb_user.no_telp, tb_produk.nm_produk, tb_transaksi.ttg_datang 
              FROM tb_transaksi, tb_produk, tb_user 
              WHERE tb_transaksi.id_user = tb_user.id_user 
                AND tb_transaksi.id_produk = tb_produk.id_produk 
                AND (tb_user.nickname LIKE '%$keyword%' 
                     OR tb_user.no_telp LIKE '%$keyword%' 
                     OR tb_produk.nm_produk LIKE '%$keyword%'
                     OR tb_transaksi.ttg_datang LIKE '%$keyword%')";
    return query($query);
}

function oldDay($data1, $data2) {
    // Tanggal saat ini
    $date_today = date('Y-m-d');
    if ($data1 === true) {
        $date_checking = data2;
    } else {
        $date_checking = $date_today;
    }
    
    // Memeriksa apakah tanggal yang ingin dicek adalah hari esok atau hari kemarin
    if ($date_today == date('Y-m-d', strtotime('+1 day', strtotime($date_checking)))) {
        $reserved = false;
    } elseif ($date_today == date('Y-m-d', strtotime('-1 day', strtotime($date_checking)))) {
        $reserved = true;
    } else {
        $reserved = true;
    }
    return $reserved;
}

function unReseved($val1, $val2){
    $val1 += $val2;
    return $val1;
} 

function update_harga($data){
    global $conn;

    // Assuming $new_harga is the new value you want to set for 'harga'
    $new_harga = isset($data['harga']) ? (int)$data['harga'] : 0;
    $id_produk = isset($data['id_produk']) ? $data['id_produk'] : '';
    
    // Perform the update query
    $query = "UPDATE tb_produk SET harga = $new_harga WHERE id_produk = '$id_produk'";
    
    // Assuming $conn is your database connection
    mysqli_query($conn, $query);
    
    // Close the database connection
    return mysqli_affected_rows($conn);
}

function cari_update($keyword){
    $query = "SELECT id_produk, nm_produk, harga 
              FROM tb_produk 
              WHERE id_produk LIKE '%$keyword%' 
                     OR nm_produk LIKE '%$keyword%' 
                     OR harga LIKE '%$keyword%';";
    return query($query);
}

function deleteReserve($data) {
    global $conn;
    $id_user = isset($data['id_user']) ? (int)$data['id_user'] : 0;
    $id_produk = $data["id_produk"];
    $ttg_datang = $data['ttg_datang'];

    $query = "DELETE FROM tb_transaksi WHERE id_user = $id_user AND id_produk = '$id_produk' AND ttg_datang = '$ttg_datang';";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function openClose($data) {
    global $conn;
    $id_produk = $data["id_produk"];
    $ketesediaan = $data["ketersediaan"];

    if ($ketesediaan == 1) {
        $query = "UPDATE tb_produk SET ketersediaan = FALSE WHERE id_produk = '$id_produk';";
        $msg = false;
    } else {
        $query = "UPDATE tb_produk SET ketersediaan = TRUE WHERE id_produk = '$id_produk';";  
        $msg = true;      
    }

    mysqli_query($conn, $query);
    return [mysqli_affected_rows($conn), $msg];
}


?>