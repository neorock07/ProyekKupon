<?php
header("Content-Type: application/json");
require_once "C:/laragon/www/ProyekKupon/config/koneksi.php";

$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data['no_rfid']) && !empty($data['id_kantin']) && !empty($data['id_katering']) && !empty($data['id_arduino'])) {
    $id_kantin = $data['id_kantin'];
    $id_katering = $data['id_katering'];
    $no_rfid = $data['no_rfid'];
    $id_arduino = $data['id_arduino'];

    //select id_rfid berdasarkan no_rfid
    $sql_find_id = "SELECT id_rfid FROM rfid WHERE no_rfid = ?";
    $query_find_id = $conn->prepare($sql_find_id);
    $query_find_id->bind_param("s", $no_rfid);
    $query_find_id->execute();
    $data_id = $query_find_id->get_result();
    $fetch_id = $data_id->fetch_assoc();
    $id_rfid = $fetch_id['id_rfid'];


    //cek apakah id_kantin pada data yang diinputkan sama dengan id_kantin pada tabel rfid
    $sql_cek_kantin = "SELECT id_kantin FROM rfid WHERE id_rfid = ?";
    $query_cek_kantin = $conn->prepare($sql_cek_kantin);
    $query_cek_kantin->bind_param("i", $id_rfid);

    if ($query_cek_kantin->execute()) {
        $result_kantin = $query_cek_kantin->get_result();
        $row = $result_kantin->fetch_assoc();

        //cek nama kantin
        $sql_cek_nama_kantin = "SELECT nama_kantin FROM kantin WHERE id_kantin = ?";
        $query_cek_nama_kantin = $conn->prepare($sql_cek_nama_kantin);
        $query_cek_nama_kantin->bind_param("i", $row['id_kantin']);

        if ($query_cek_nama_kantin->execute()) {
            $result_nama_kantin = $query_cek_nama_kantin->get_result();
            $data_kantin = $result_nama_kantin->fetch_assoc();
            $nama_kantin = $data_kantin['nama_kantin'];
        } else {
            $nama_kantin = "kantin tidak ada";
        }

        $query_cek_nama_kantin->close();


        //jika data kantin ada 
        if (!empty($row)) {
            if ($row['id_kantin'] != $data['id_kantin']) {
                $error_reason = "Salah Kantin\nKantin Anda : " . $nama_kantin;
                $status_transaksi = "gagal";
            } else {

                //cek apakah kupon dari tabel rfid dengan id_rfid ini sudah digunakan ?
                $sql_cek_status_kupon = "SELECT status_kupon FROM rfid WHERE id_rfid = ?";
                $query_cek_status_kupon = $conn->prepare($sql_cek_status_kupon);
                $query_cek_status_kupon->bind_param("i", $id_rfid);

                if ($query_cek_status_kupon->execute()) {
                    $result_status_kupon = $query_cek_status_kupon->get_result();
                    $row_kupon = $result_status_kupon->fetch_assoc();
                    if (!empty($row_kupon)) {
                        if ($row_kupon['status_kupon'] == 1) {
                            $status_kupon = 0;

                            //update status_kupon pada tabel rfid    
                            $sql_update_kupon = "UPDATE rfid SET status_kupon = ? WHERE id_rfid = ?";
                            $query_update_kupon = $conn->prepare($sql_update_kupon);
                            $query_update_kupon->bind_param("ii", $status_kupon, $id_rfid);
                            $query_update_kupon->execute();

                            $query_update_kupon->close();
                            $error_reason = "-";
                            $status_transaksi = "berhasil";
                        } else {
                            $error_reason = "Kupon sudah digunakan";
                            $status_transaksi = "gagal";
                        }
                    }
                    $query_cek_status_kupon->close();
                }
            }
        }
    }



    //menyimpan data transaksi tap rfid
    $sql = "INSERT INTO kupon_harian (id_kantin, id_katering, id_rfid, id_arduino, waktu_scan, status_transaksi, error_reason) VALUES (?,?, ?, ?, CURRENT_TIMESTAMP ,?,?)";
    $query = $conn->prepare($sql);
    $query->bind_param("iiisss", $id_kantin, $id_katering, $id_rfid, $id_arduino, $status_transaksi, $error_reason);

    if ($query->execute()) {
        //select jumlah terjual masing-masing alat
        $sql_count = "SELECT COUNT(*) AS total_penjualan
                      FROM kupon_harian  
                      WHERE DATE(waktu_scan) = DATE(CURRENT_TIMESTAMP) 
                      AND status_transaksi = 'berhasil'
                      AND
                      id_arduino = ?;";

        $query_count = $conn->prepare($sql_count);
        $query_count->bind_param("s", $id_arduino);
        $query_count->execute();
        $result_count = $query_count->get_result();
        $fetch_count = $result_count->fetch_assoc();
        $total_penjualan = $fetch_count['total_penjualan'];

        echo json_encode(array(
            "message" => "Record Created",
            "kantin" => $nama_kantin,
            "status" => $status_transaksi,
            "error" => $error_reason,
            "jumlah" => $total_penjualan,
            "tanggal" => date("Y-m-d")
        ));
    } else {
        echo json_encode(array(
            "message" => "Error : " . $query->error
        ));
    }

    $query->close();
    $query_cek_kantin->close();
} else {
    echo json_encode(array(
        "message" => "Invalid Input"
    ));
}
