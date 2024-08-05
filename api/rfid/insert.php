<?php
header("Content-Type: application/json");
require_once "C:/laragon/www/ProyekKupon/config/koneksi.php";

$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data['id_bagian']) && !empty($data['id_kantin']) && !empty($data['no_rfid']) && !empty($data['status_kupon'])) {
    $id_bagian = $data['id_bagian'];
    $id_seksi = $data['id_seksi'];
    $id_kantin = $data['id_kantin'];
    $no_rfid = $data['no_rfid'];
    $nik_user = $data['nik_user'];
    $nama_user = $data['nama_user'];
    $status_kupon = $data['status_kupon'];
    
    $sql = "INSERT INTO rfid (id_bagian, id_seksi, id_kantin, no_rfid, nik_user, nama_user, status_kupon) VALUES (?,?, ?, ?, ? ,?,?)";
    $query = $conn->prepare($sql);
    $query->bind_param("iiiiisi", $id_bagian, $id_seksi, $id_kantin, $no_rfid, $nik_user, $nama_user, $status_kupon);

    if ($query->execute()) {
        echo json_encode(array(
            "message" => "Record Created"
        ));
    } else {
        echo json_encode(array(
            "message" => "Error : " . $query->error
        ));
    }

    $query->close();
} else {
    echo json_encode(array(
        "message" => "Invalid Input"
    ));
}
