<?php
    require_once "../ProyekKupon/scripts/insert_kantin.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kantin</title>
</head>

<body>
    <h2>Halaman Tambah Kantin</h2>
    <div>
        <form action="insert_kantin.php" method="post">
            <label for="nama_kantin">Nama Kantin</label>
            <input type="text" id="nama_kantin" name="nama_kantin" required>
            <input type="submit" value="Submit">
        </form>
    </div>
    <button>Submit</button>

</body>

</html>