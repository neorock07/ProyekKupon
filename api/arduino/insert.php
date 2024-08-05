<?php
header("Content-Type: application/json");
require_once "C:/laragon/www/ProyekKupon/config/koneksi.php";

$data = json_decode(file_get_contents('php://input'), true);

if(!empty($data['nama_arduino']) && !empty($data['ip_arduino'])){
    $nama_arduino = $data['nama_arduino'];
    $ip_arduino = $data['ip_arduino'];

    $sql = "INSERT INTO arduino (nama_arduino, ip_arduino) VALUES (?,?)";
    $query = $conn->prepare($sql);
    $query->bind_param("ss", $nama_arduino, $ip_arduino);

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