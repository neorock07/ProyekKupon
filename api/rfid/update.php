<?php
header("Content-Type: application/json");
require_once "C:/laragon/www/ProyekKupon/config/koneksi.php";

$data = json_decode(file_get_contents('php://input'), true);

if(!empty($data['id_rfid'])){
    $id_rfid = $data['id_rfid'];
    $id_bagian = $data['id_bagian'];
    $id_seksi = $data['id_seksi'];
    $id_kantin = $data['id_kantin'];
    $no_rfid = $data['no_rfid'];
    $nik_user = $data['nik_user'];
    $nama_user = $data['nama_user'];
    $status_kupon = $data['status_kupon'];

    $sql = "UPDATE rfid SET 
            id_bagian = ?,
            id_seksi = ?,
            id_kantin = ?,
            no_rfid = ?,
            nik_user = ?,
            nama_user = ?,
            status_kupon = ?
            WHERE id_rfid = ?";
    $query = $conn->prepare($sql);
    $query->bind_param("iiisisii", $id_bagian, $id_seksi, $id_kantin, $no_rfid, $nik_user, $nama_user, $status_kupon ,$id_rfid);

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