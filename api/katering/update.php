<?php
header("Content-Type: application/json");
require_once "C:/laragon/www/ProyekKupon/config/koneksi.php";

$data = json_decode(file_get_contents('php://input'), true);

if(!empty($data['id_katering']) && !empty($data['nama_katering'])){
    $id_katering = $data['id_katering'];
    $nama_katering = $data['nama_katering'];
    
    $sql = "UPDATE katering SET nama_katering = ? WHERE id_katering = ?";
    $query = $conn->prepare($sql);
    $query->bind_param("si", $nama_katering, $id_katering);

    if($query->execute()){
        echo json_encode(array(
            "message" => "Record Updated"
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