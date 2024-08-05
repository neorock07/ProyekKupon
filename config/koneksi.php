<?php

$serverName = "localhost";
$userName = "root";
$password = "";
$dbName = "db_kupon";

$conn = mysqli_connect($serverName, $userName, $password, $dbName);

if(!$conn){
    die("Koneksi Gagal : " . mysqli_connect_error());
}

// echo "Koneksi Berhasil";

?>