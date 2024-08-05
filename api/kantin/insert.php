<?php
header("Content-Type: application/json");
require_once "C:/laragon/www/ProyekKupon/config/koneksi.php";

$data = json_decode(file_get_contents('php://input'), true);

if(!empty($data['nama_kantin'])){
    $nama_kantin = $data['nama_kantin'];
    $sql = "INSERT INTO kantin (nama_kantin) VALUES (?)";
    $query = $conn->prepare($sql);
    $query->bind_param("s", $nama_kantin);

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