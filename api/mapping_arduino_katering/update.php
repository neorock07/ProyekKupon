<?php
header("Content-Type: application/json");
require_once "C:/laragon/www/ProyekKupon/config/koneksi.php";

$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data['id_mapping']) && !empty($data['id_katering']) && !empty($data['id_arduino']) && !empty($data['id_kantin']) && !empty($data['tanggal_awal']) && !empty($data['tanggal_akhir'])) {
    $id_mapping = $data['id_mapping'];
    $id_katering = $data['id_katering'];
    $id_arduino = $data['id_arduino'];
    $id_kantin = $data['id_kantin'];
    $tanggal_awal = $data['tanggal_awal'];
    $tanggal_akhir = $data['tanggal_akhir'];

    $sql = "UPDATE mapping_arduino_katering 
            SET id_katering = ?,
            id_arduino = ?,
            id_kantin = ?,
            tanggal_awal = ?,
            tanggal_akhir = ?
            WHERE id_mapping = ?";
    $query = $conn->prepare($sql);
    $query->bind_param("iiissi", $id_katering, $id_arduino, $id_kantin, $tanggal_awal, $tanggal_akhir, $id_mapping);

    if ($query->execute()) {
        echo json_encode(array(
            "message" => "Record Updated"
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
