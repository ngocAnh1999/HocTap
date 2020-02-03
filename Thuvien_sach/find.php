<!DOCTYPE html>
<?php 
		$conn = new mysqli('127.0.0.1', "root","ngocanh1999", "thuvien");
		mysqli_set_charset($conn, 'UTF8');
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
?>
<html lang="vi">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<title>Thư viện</title>
	<style type="text/css">
		* {
			margin: 0;
			padding: 0;
		}
		.header {
			background-color: #008B8B;
			height: 55px;
		}
		.toolbar {
			background-color: #d0d0d0;
		}
		.main-table {
			width: 100%;
			overflow: auto;
		}
		.main-table tr {
			height: 40px;
			text-align: center;
		}
		.main-table tbody tr:hover {
			background-color: #B0C4DE !important;
			color: #FFF !important;
		}
		.modal-body label {
			width: 150px;
		}
	</style>
</head>
<body>
    
<?php
    $tentheloai = $_POST["tentheloai"];
    $query = "SELECT * FROM Sach s JOIN LoaiSach ls ON s.matheloai = ls.matheloai WHERE ls.tentheloai = '$tentheloai'";
    $result = $conn->query($query);
    echo "<div class=\"header row text-white\">
                <div class=\"font-weight-bold m-auto\">Thể loại: $tentheloai</div>
            </div>";
    if ($result->num_rows > 0) {
        // output data of each row
        echo "<table class=\"main-table table-striped table-bordered\">
        <thead>
            <tr>
                <th>Mã thể loại</th>
                <th>Mã sách</th>
                <th>Tên sách</th>
                <th>Năm xuất bản</th>
            </tr>
        </thead>
        <tbody>";
        while($row = $result->fetch_assoc()) 
        {
            $matheloai = $row["matheloai"];
            $masach = $row["masach"];
            $tensach = $row["tensach"];
            $namxb = $row["namxb"];
            echo "<tr>";
            echo "<td name='matheloai'>$matheloai</td>";
            echo "<td name='masach'>$masach</td>";
            echo "<td name='tensach'>$tensach</td>";
            echo "<td name='namxb'>$namxb</td>";
            echo "</tr>";									
        }
        echo "</tbody>
        </table>
        <a class=\"navbar\" href=\"index.php\">Quay lại</a>";
    }
    else {
        echo "Thể loại này không có trong thư viện.";
    }
    $conn->close();

?>
</body>
</html>