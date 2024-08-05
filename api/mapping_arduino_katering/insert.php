<?php
header("Content-Type: application/json");
require_once "C:/laragon/www/ProyekKupon/config/koneksi.php";

$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data['id_katering']) && !empty($data['id_arduino']) && !empty($data['id_kantin'])) {
    $id_katering = $data['id_katering'];
    $id_arduino = $data['id_arduino'];
    $id_kantin = $data['id_kantin'];
    $tanggal_awal = $data['tanggal_awal'];
    $tanggal_akhir = $data['tanggal_akhir'];

    $sql = "INSERT INTO mapping_arduino_katering (id_katering, id_arduino, id_kantin, tanggal_awal, tanggal_akhir) VALUES (?,?,?,?,?)";
    $query = $conn->prepare($sql);
    $query->bind_param("iiiss", $id_katering, $id_arduino, $id_kantin, $tanggal_awal, $tanggal_akhir);

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
