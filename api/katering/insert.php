<?php
header("Content-Type: application/json");
require_once "C:/laragon/www/ProyekKupon/config/koneksi.php";

$data = json_decode(file_get_contents('php://input'), true);

if(!empty($data['nama_katering'])){
    $nama_katering = $data['nama_katering'];
    $sql = "INSERT INTO katering (nama_katering) VALUES (?)";
    $query = $conn->prepare($sql);
    $query->bind_param("s", $nama_katering);

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