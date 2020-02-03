<?php

include("connect.php"); 
if(isset($_POST['del-tinh'])) {
    $id_tinh = $_POST['del-tinh'];
    $query = "DELETE FROM Tinh WHERE id = '$id_tinh'";
    if ($conn->query($query) === TRUE) {
        header('Location: index.php');
        // echo "success";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
        
    $conn->close();
}

?>