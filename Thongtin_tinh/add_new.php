<?php 
    include("connect.php"); 
    $new_name = $_POST['new-name'];
    if(isset($new_name)) {
        $query = "SELECT id FROM Tinh";
        $data = $conn->query($query);
        $max = 1;
        if($data->num_rows > 0) {
            while($row = $data->fetch_assoc()) {
                $id = trim(substr($row['id'], 2))+ 1;
                if($max < $id) $max = $id;
            }
        }
        $new_id = "t_" . $max;
        $query = "INSERT INTO Tinh(id, name) VALUES ('$new_id', '$new_name')";
        if($conn->query($query) === True) {
            header('Location: index.php');
        }
        else {
            echo "Error: " . $query . "<br>" . $conn->error;
        }
    }
    $conn->close();
?>
