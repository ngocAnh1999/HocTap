<?php

include("connect.php"); 
if(isset($_POST['name'])) {
    $name = $_POST['name'];
    $id_tinh = $_POST['idtinh'];
    $query = "UPDATE Tinh SET name = '$name' WHERE id = '$id_tinh'";
    if ($conn->query($query) === TRUE) {
        header('Location: index.php');
        // echo "success";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
        
    $conn->close();
}