<?php
    $conn = new mysqli("127.0.0.1", "root", "ngocanh1999", "DanhMuc");
    mysqli_set_charset($conn, 'UTF8');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

?>