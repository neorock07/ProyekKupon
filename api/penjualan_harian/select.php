<?php
header("Content-Type: application/json");
require_once "C:/laragon/www/ProyekKupon/config/koneksi.php";

$data = json_decode(file_get_contents('php://input'), true);

if(!empty($data['id_arduino'])){
    $id_arduino = $data['id_arduino'];
 

    $sql = "SELECT COUNT(*) AS total_penjualan 
            FROM penjualan_harian
            WHERE DATE(tanggal) = DATE(CURRENT_TIMESTAMP) AND id_arduino = ?;";
    $query = $conn->prepare($sql);
    $query->bind_param("i", $id_arduino);

    if($query->execute()){
        $total = $query->get_result();
        $total_penjualan = $total->fetch_assoc();

        echo json_encode(array(
            "total_penjualan" => $total_penjualan['total_penjualan']
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