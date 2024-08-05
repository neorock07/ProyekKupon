<?php
header("Content-Type: application/json");
require_once "C:/laragon/www/ProyekKupon/config/koneksi.php";

$data = json_decode(file_get_contents('php://input'), true);

if(!empty($data['id_kantin'])){
    $id_kantin = $data['id_kantin'];
    
    $sql = "DELETE FROM kantin WHERE id_kantin = ?";
    $query = $conn->prepare($sql);
    $query->bind_param("i", $id_kantin);

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