<?php
header("Content-Type: application/json");
require_once "C:/laragon/www/ProyekKupon/config/koneksi.php";

$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data['no_rfid'])) {
    $no_rfid = $data['no_rfid'];


    $sql = "SELECT * 
            FROM rfid
            WHERE no_rfid = ?;";
    $query = $conn->prepare($sql);
    $query->bind_param("s", $no_rfid);

    if ($query->execute()) {
        $data_rfid = $query->get_result();
        $fetch_rfid = $data_rfid->fetch_assoc();
        if (!empty($fetch_rfid)) {
            echo json_encode(array(
                "data" => $fetch_rfid['id_rfid']
            ));
        }else{
            echo json_encode(array(
                "data" => "tidak ada"
            ));
        }
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
