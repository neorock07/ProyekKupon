<?php
header("Content-Type: application/json");
require_once "C:/laragon/www/ProyekKupon/config/koneksi.php";

$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data['id_arduino'])) {
    $nama_arduino = $data['nama_arduino'];
    $ip_arduino = $data['ip_arduino'];
    $id_arduino = $data['id_arduino'];

    $sql = "INSERT INTO arduino (id_arduino, nama_arduino, ip_arduino) VALUES (?,?,?)";
    $query = $conn->prepare($sql);
    $query->bind_param("sss", $id_arduino, $nama_arduino, $ip_arduino);

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
