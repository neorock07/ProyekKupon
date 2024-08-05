<?php
header("Content-Type: application/json");
require_once "C:/laragon/www/ProyekKupon/config/koneksi.php";

$data = json_decode(file_get_contents('php://input'), true);

if(!empty($data['nama_seksi']) && !empty($data['id_bagian'])){
    $nama_seksi = $data['nama_seksi'];
    $id_bagian = $data['id_bagian'];
    $sql = "INSERT INTO seksi (nama_seksi, id_bagian) VALUES (?,?)";
    $query = $conn->prepare($sql);
    $query->bind_param("si", $nama_seksi, $id_bagian);

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