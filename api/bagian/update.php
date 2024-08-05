<?php
header("Content-Type: application/json");
require_once "C:/laragon/www/ProyekKupon/config/koneksi.php";

$data = json_decode(file_get_contents('php://input'), true);

if(!empty($data['id_bagian']) && !empty($data['nama_bagian'])){
    $id_bagian = $data['id_bagian'];
    $nama_bagian = $data['nama_bagian'];
    
    $sql = "UPDATE bagian SET nama_bagian = ? WHERE id_bagian = ?";
    $query = $conn->prepare($sql);
    $query->bind_param("si", $nama_bagian, $id_bagian);

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