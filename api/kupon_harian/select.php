<?php
header("Content-Type: application/json");
require_once "C:/laragon/www/ProyekKupon/config/koneksi.php";

$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data['id_arduino'])) {
    $id_arduino = $data['id_arduino'];

    $sql = "SELECT * FROM kupon_harian
            WHERE id_arduino = ?
            AND DATE(waktu_scan) = DATE(CURRENT_TIMESTAMP) 
            ORDER BY waktu_scan DESC LIMIT 1;";

    $query = $conn->prepare($sql);
    $query->bind_param("i", $id_arduino);

    try {
        if ($query->execute()) {
            $result = $query->get_result();
            $fetch = $result->fetch_assoc();
            //get penjualan
            $sql_count = "SELECT COUNT(*) AS total_penjualan
            FROM kupon_harian  
            WHERE DATE(waktu_scan) = DATE(CURRENT_TIMESTAMP) 
            AND status_transaksi = 'berhasil'
            AND id_arduino = ?;";

            $query_count = $conn->prepare($sql_count);
            $query_count->bind_param("s", $id_arduino);
            $query_count->execute();
            $result_count = $query_count->get_result();
            $fetch_count = $result_count->fetch_assoc();
            $total_penjualan = $fetch_count['total_penjualan'];
            $query_count->close();


            if ($fetch != null) {
                $katering = $fetch['id_katering'];
                $kantin = $fetch['id_kantin'];
                $id_rfid = $fetch['id_rfid'];
                $waktu_scan = $fetch['waktu_scan'];
                $status_transaksi = $fetch['status_transaksi'];
                $error_reason = $fetch['error_reason'];

                //get no_rfid
                $sql_rfid = "SELECT * FROM rfid WHERE id_rfid = ?";
                $query_rfid = $conn->prepare($sql_rfid);
                $query_rfid->bind_param("i", $id_rfid);
                $query_rfid->execute();
                $result_rfid = $query_rfid->get_result();
                $fetch_rfid = $result_rfid->fetch_assoc();
                $nik = $fetch_rfid['nik_user'];
                $query_rfid->close();
            } else {
                $katering = '';
                $kantin = '';
                $id_rfid = '';
                $waktu_scan = '';
                $status_transaksi = '';
                $error_reason = '';
                $nik = "";
            }

            echo json_encode(array(
                "nik" => $nik,
                "status" => $status_transaksi,
                "error" => $error_reason,
                "jumlah" => $total_penjualan
            ));
        } else {
            echo json_encode(array(
                "message" => "Error : " . $query->error
            ));
        }
    } catch (\Throwable $th) {
        die("error " . $th);
    }

    $query->close();
} else {
    echo json_encode(array(
        "message" => "Invalid Input"
    ));
}
