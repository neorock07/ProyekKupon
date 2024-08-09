<?php
require_once '../config/koneksi.php';

$sql_kantin = "CREATE TABLE IF NOT EXISTS kantin (
        id_kantin INT(5) AUTO_INCREMENT PRIMARY KEY,
        nama_kantin VARCHAR(100) NOT NULL
    )";

if ($conn->query($sql_kantin) == TRUE) {
    echo "Table Kantin Created<br>";
} else {
    echo "Error creating Table Kantin :" . $conn->error . "<br>";
}

$sql_katering = "CREATE TABLE IF NOT EXISTS katering(
        id_katering INT(3) AUTO_INCREMENT PRIMARY KEY, 
        nama_katering VARCHAR(100) NOT NULL
    )";

if ($conn->query($sql_katering) == TRUE) {
    echo "Table Katering created";
} else {
    echo "Error creating Table Katering :" . $conn->error . "<br>";
}

$sql_bagian = "CREATE TABLE IF NOT EXISTS bagian(
        id_bagian INT(5) AUTO_INCREMENT PRIMARY KEY,
        nama_bagian VARCHAR(100) NOT NULL
    )";

if ($conn->query($sql_bagian) == TRUE) {
    echo "Table Bagian created";
} else {
    echo "Error creating Table Bagian :" . $conn->error . "<br>";
}

$sql_seksi = "CREATE TABLE IF NOT EXISTS seksi(
        id_seksi INT(5) AUTO_INCREMENT PRIMARY KEY,
        id_bagian INT(5) NOT NULL,
        nama_seksi VARCHAR(100) NOT NULL,
        FOREIGN KEY (id_bagian) REFERENCES bagian(id_bagian)
    )";

if ($conn->query($sql_seksi) == TRUE) {
    echo "Table Seksi created";
} else {
    echo "Error creating Table Seksi :" . $conn->error . "<br>";
}

$sql_rfid = "CREATE TABLE IF NOT EXISTS rfid(
        id_rfid INT(5) AUTO_INCREMENT PRIMARY KEY,
        id_bagian INT(5) NOT NULL, 
        id_seksi INT(5),
        id_kantin INT(5) NOT NULL, 
        no_rfid VARCHAR(20) UNIQUE NOT NULL,
        nik_user INT(10),
        nama_user VARCHAR(60),
        status_kupon BOOLEAN NOT NULL,
        FOREIGN KEY (id_kantin) REFERENCES kantin(id_kantin),
        FOREIGN KEY (id_bagian) REFERENCES bagian(id_bagian),
        FOREIGN KEY (id_seksi) REFERENCES seksi(id_seksi)
    )";

if ($conn->query($sql_rfid) == TRUE) {
    echo "Table RFID created";
} else {
    echo "Error creating Table RFID :" . $conn->error . "<br>";
}

$sql_arduino = "CREATE TABLE IF NOT EXISTS arduino(
    id_arduino VARCHAR(20) PRIMARY KEY,
    nama_arduino VARCHAR(100) NOT NULL,
    ip_arduino VARCHAR(60) NOT NULL
)";

if ($conn->query($sql_arduino) == TRUE) {
    echo "Table arduino created";
} else {
    echo "Error creating Table arduino :" . $conn->error . "<br>";
}

$sql_mapping_arduino_katering = "CREATE TABLE IF NOT EXISTS mapping_arduino_katering(
    id_mapping INT(5) AUTO_INCREMENT PRIMARY KEY,
    id_katering INT(5) NOT NULL, 
    id_arduino VARCHAR(20) NOT NULL, 
    id_kantin INT(5) NOT NULL, 
    tanggal_awal DATETIME NOT NULL, 
    tanggal_akhir DATETIME NOT NULL,
    FOREIGN KEY (id_kantin) REFERENCES kantin(id_kantin),
    FOREIGN KEY (id_katering) REFERENCES katering(id_katering),
    FOREIGN KEY (id_arduino) REFERENCES arduino(id_arduino)
)";

if ($conn->query($sql_mapping_arduino_katering) == TRUE) {
    echo "Table mapping_arduino_katering created";
} else {
    echo "Error creating Table mapping_arduino_katering :" . $conn->error . "<br>";
}



$sql_kupon_harian = "CREATE TABLE IF NOT EXISTS kupon_harian(
    id_kupon_harian INT(5) AUTO_INCREMENT PRIMARY KEY,
    id_kantin INT(5) NOT NULL, 
    id_katering INT(5) NOT NULL,
    id_rfid INT(5) NOT NULL, 
    id_arduino VARCHAR(20) NOT NULL, 
    waktu_scan DATETIME NOT NULL, 
    status_transaksi ENUM('berhasil', 'gagal'),
    error_reason VARCHAR(200), 
    FOREIGN KEY (id_kantin) REFERENCES kantin(id_kantin),
    FOREIGN KEY (id_katering) REFERENCES katering(id_katering),
    FOREIGN KEY (id_rfid) REFERENCES rfid(id_rfid),
    FOREIGN KEY (id_arduino) REFERENCES arduino(id_arduino)
)";

if ($conn->query($sql_kupon_harian) == TRUE) {
    echo "Table kupon_harian created";
} else {
    echo "Error creating Table kupon_harian :" . $conn->error . "<br>";
}

$sql_penjualan_harian = "CREATE TABLE IF NOT EXISTS penjualan_harian(
    id_penjualan INT(5) AUTO_INCREMENT PRIMARY KEY, 
    id_katering INT(5) NOT NULL, 
    id_kantin INT(5) NOT NULL,
    id_arduino VARCHAR(20) NOT NULL, 
    jumlah_penjualan INT(30) NOT NULL,
    tanggal DATETIME NOT NULL,
    FOREIGN KEY (id_katering) REFERENCES katering(id_katering),
    FOREIGN KEY (id_kantin) REFERENCES kantin(id_kantin),
    FOREIGN KEY (id_arduino) REFERENCES arduino(id_arduino)

)";

if ($conn->query($sql_penjualan_harian) == TRUE) {
    echo "Table penjualan_harian created";
} else {
    echo "Error creating Table penjualan_harian :" . $conn->error . "<br>";
}

$conn->close();