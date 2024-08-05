<?php
header("Content-Type: application/json");
require_once "C:/laragon/www/ProyekKupon/config/koneksi.php";

$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data['id_arduino'])) {
    $id_arduino = $data['id_arduino'];

    $sql = "SELECT id_katering, id_kantin 
            FROM mapping_arduino_katering
            WHERE id_arduino = ?";
    $query = $conn->prepare($sql);
    $query->bind_param("i", $id_arduino);

    try {
        if ($query->execute()) {
            $result = $query->get_result();
            $fetch = $result->fetch_assoc();
    
            
            if ($fetch != null) {
                $katering = $fetch['id_katering'];
                $kantin = $fetch['id_kantin'];
            } else {
                $katering = null;
                $kantin = null;
            }
    
            echo json_encode(array(
                "id_katering" => $katering,
                "id_kantin" => $kantin
            ));
        } else {
            echo json_encode(array(
                "message" => "Error : " . $query->error
            ));
        }
    
    } catch (\Throwable $th) {
        die("error " .$th);
    }
    
    $query->close();
} else {
    echo json_encode(array(
        "message" => "Invalid Input"
    ));
}
