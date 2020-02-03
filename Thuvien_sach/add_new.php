<?php
        $conn = new mysqli('localhost', 'root', 'password', 'dbname');
        $maloai = $_POST['maloai'];
        $maphong = $_POST['maphong'];
        $sophong = $_POST['sophong'];
        $sogiuong = $_POST['sogiuong'];
        $timkiem = $_POST['search'];
        $maloaisua = $_POST['maloaisua'];
        $maphongsua = $_POST['maphongsua'];
        $sophongsua = $_POST['sophongsua'];
        $sogiuongsua = $_POST['sogiuongsua'];
        
        if(isset($_POST['add']))
        {
            if(isset($maloai) && isset($maphong) && isset($sophong) &&
isset($sogiuong))
            {
                $sqladd = "INSERT INTO Phong
                VALUES('$maloai','$maphong','$sophong','$sogiuong')";
                $conn->query($sqladd);
                header("Location: home.php");
            }

        }
        if(isset($_POST['change']))
        {
            if(isset($maloaisua) && isset($maphongsua) && isset($sophongsua) && isset($sogiuongsua))
            {
                $sqladd = "UPDATE  Phong  SET maloai = '$maloaisua', tenphong =
                            '$tenphongsua', sogiuong = '$sogiuongsua' WHERE maphong =
                            '$maphongsua'";
                $conn->query($sqladd) or die("Chưa có loại phòng này");
                header("Location: home.php");
            }

        }
    ?>
