<?php
header("Content-Type: application/json");
require_once "C:/laragon/www/ProyekKupon/config/koneksi.php";

$data = json_decode(file_get_contents('php://input'), true);

if(!empty($data['id_katering'])){
    $id_katering = $data['id_katering'];
    
    $sql = "DELETE FROM katering WHERE id_katering = ?";
    $query = $conn->prepare($sql);
    $query->bind_param("i", $id_katering);

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