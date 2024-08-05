<?php
header("Content-Type: application/json");
require_once "C:/laragon/www/ProyekKupon/config/koneksi.php";

$data = json_decode(file_get_contents('php://input'), true);

if(!empty($data['id_seksi']) && !empty($data['nama_seksi']) && !empty($data['id_bagian'])){
    $id_seksi = $data['id_seksi'];
    $nama_seksi = $data['nama_seksi'];
    $id_bagian = $data['id_bagian'];

    $sql = "UPDATE seksi SET nama_seksi = ?, id_bagian = ? WHERE id_seksi = ?";
    $query = $conn->prepare($sql);
    $query->bind_param("sii", $nama_seksi, $id_bagian ,$id_seksi);

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