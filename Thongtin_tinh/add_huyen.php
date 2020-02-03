<?php 
    include("connect.php"); 
    $new_name = $_POST['new-name'];
    $tinh = $_POST['tinh'];
    if(isset($new_name) && isset($tinh)) {
        $query = "SELECT id FROM Huyen";
        $data = $conn->query($query);
        $max = 1;
        if($data->num_rows > 0) {
            while($row = $data->fetch_assoc()) {
                $id = $row['id']+ 1;
                if($max < $id) $max = $id;   
            }
        }
        $query = "SELECT id FROM Tinh WHERE name = '$tinh'";
        $result = $conn->query($query);
        if($result->num_rows > 0) {
            while($row= $result->fetch_assoc()) {
                $tinhid = $row['id'];
                $query = "INSERT INTO Huyen(id, name, tinhid) VALUES ('$max', '$new_name', '$tinhid')";
                if($conn->query($query) === True) {
                    header('Location: index.php');
                }
                else {
                    echo "Error: " . $query . "<br>" . $conn->error;
                }
            }
        }

        
    }
    $conn->close();
?>