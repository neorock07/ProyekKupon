<?php
header("Content-Type: application/json");
require_once "C:/laragon/www/ProyekKupon/config/koneksi.php";

$data = json_decode(file_get_contents('php://input'), true);

if(!empty($data['id_katering']) && !empty($data['id_kantin']) && !empty($data['id_arduino'])){
    $id_katering = $data['id_katering'];
    $id_kantin = $data['id_kantin'];
    $id_arduino = $data['id_arduino'];

    $sql = "INSERT INTO penjualan_harian (id_katering, id_kantin, id_arduino, jumlah_penjualan, tanggal) VALUES (?, ?, ?, jumlah_penjualan + 1, CURRENT_TIMESTAMP)";
    $query = $conn->prepare($sql);
    $query->bind_param("iii", $id_katering, $id_kantin, $id_arduino);

    if($query->execute()){
        echo json_encode(array(
            "message" => "Record Created"
        ));
    }else{
        echo json_encode(array(
            "message" => "Error : ".$query->error
        ));
    }

    $query->close();
}else{
    echo json_encode(array(
        "message" => "Invalid Input"
    ));
}

?>