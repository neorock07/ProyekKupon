<?php
header("Content-Type: application/json");
require_once "C:/laragon/www/ProyekKupon/config/koneksi.php";

$data = json_decode(file_get_contents('php://input'), true);

if(!empty($data['id_arduino'])){
    $id_arduino = $data['id_arduino'];
    
    $sql = "DELETE FROM arduino WHERE id_arduino = ?";
    $query = $conn->prepare($sql);
    $query->bind_param("i", $id_arduino);

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