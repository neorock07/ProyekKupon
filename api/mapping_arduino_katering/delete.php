<?php
header("Content-Type: application/json");
require_once "C:/laragon/www/ProyekKupon/config/koneksi.php";

$data = json_decode(file_get_contents('php://input'), true);

if(!empty($data['id_mapping'])){
    $id_mapping = $data['id_mapping'];
    
    $sql = "DELETE FROM mapping_arduino_katering WHERE id_mapping = ?";
    $query = $conn->prepare($sql);
    $query->bind_param("i", $id_mapping);

    if($query->execute()){
        echo json_encode(array(
            "message" => "Record Deleted"
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