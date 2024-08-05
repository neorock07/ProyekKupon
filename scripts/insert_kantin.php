<?php
    require_once "../config/koneksi.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $nama_kantin = $_POST['nama_kantin'];
        $sql = "INSERT INTO kantin (nama_kantin) VALUES (?)";
        $query = $conn->prepare($sql);
        $query->bind_param("s", $nama_kantin);

        if($query->execute()){
            echo "New Record Submitted";
        }else{
            echo "Error : " .$sql . "<br>" .$conn->error;
        }

        $query->close();
    }


?>