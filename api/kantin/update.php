<?php
header("Content-Type: application/json");
require_once "C:/laragon/www/ProyekKupon/config/koneksi.php";

$data = json_decode(file_get_contents('php://input'), true);

if(!empty($data['id_kantin']) && !empty($data['nama_kantin'])){
    $id_kantin = $data['id_kantin'];
    $nama_kantin = $data['nama_kantin'];
    
    $sql = "UPDATE kantin SET nama_kantin = ? WHERE id_kantin = ?";
    $query = $conn->prepare($sql);
    $query->bind_param("si", $nama_kantin, $id_kantin);

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