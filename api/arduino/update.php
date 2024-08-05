<?php
header("Content-Type: application/json");
require_once "C:/laragon/www/ProyekKupon/config/koneksi.php";

$data = json_decode(file_get_contents('php://input'), true);

if(!empty($data['id_arduino']) && !empty($data['nama_arduino'])){
    $id_arduino = $data['id_arduino'];
    $nama_arduino = $data['nama_arduino'];
    
    $sql = "UPDATE arduino SET nama_arduino = ? WHERE id_arduino = ?";
    $query = $conn->prepare($sql);
    $query->bind_param("si", $nama_arduino, $id_arduino);

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