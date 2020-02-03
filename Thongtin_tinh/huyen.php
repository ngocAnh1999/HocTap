<!-- <!DOCTYPE html>
<html lang="vi"> -->
<?php 
include("connect.php"); 
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Danh sách huyện</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            font-size: 13px;
            font-family: 'Courier New', Courier, monospace;
        }

        a,
        a:hover {
            text-decoration: none;
        }

        .header {
            height: 60px;
            background-color: #008b8b;
        }

        .content {
            overflow: auto;
        }

        .content .toolbar {
            height: 50px;
            border-bottom: 1px solid #d0d0d0;
            width: 100%;
        }

        .footer {
            height: 50px;
            background-color: #808080;
        }

        table th,
        td {
            text-align: center;
            height: 35px;
        }

        .btn-delete:hover,.btn-edit:hover  {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="header row fixed-header d-flex justify-content-center">
            <?php 
                $tinh = $_POST["tinh_val"];
                echo "<h3 id='ten_tinh' class=\"text-white font-weight-bold my-auto\">$tinh</h3>";
            ?>
        </div>
        <div class="content row">
                <div class="toolbar">
                <nav class="navbar navbar-expand-sm">
                        <button class="col-sm-1 btn btn-success" data-toggle="modal" data-target="#modalAdd" >Thêm mới</button>
                        <div class="col-sm"></div>
                        <form class="form-inline col-sm-5" action="find.php" method="post">
                            <input class="form-control mr-sm-1" name="tentheloai" type="text" placeholder="Tìm kiếm theo thể loại sách">
                            <button class="btn bg-secondary text-white" type="submit" onclick = "search()">Tìm</button>
                        </form>
                    </nav>
                </div>
                <table class="table-bordered table-striped w-100">
                    <thead>
                        <tr>
                            <th>Mã huyện</th>
                            <th>Tên huyện</th>
                            <th>Xóa</th>
                            <th>Sửa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(isset($_POST["tinh_val"])) {

                                $tinh = $_POST["tinh_val"];
                                $query = "SELECT h.id, h.name FROM Huyen h JOIN Tinh t ON t.id = h.tinhid WHERE t.name = '$tinh'";
                                $result = $conn->query($query);
                                if ($result->num_rows > 0) {
                                    // output data of each row
                                    
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td name='id_huyen'>". $row["id"] ."</td>";
                                        echo "<td name='ten_huyen'>". $row["name"] ."</td>";
                                        echo "<td onclick='javascript:modalDelete(this)' class='btn-delete' data-toggle=\"modal\" data-target=\"#modalDelete\">X</td>";
                                        echo "<td class='btn-edit' data-toggle=\"modal\" data-target=\"#modalEdit\" onclick='javascript:modalEdit(this)'>edit</td>";
                                        echo "</tr>";
                                    }
                                    
                                }
                                else {
                                    echo "<tr>Không có huyện nào</tr>";
                                }
                            }
                        
                        ?>
                    </tbody>
                </table>
            </div>
            <div>
            <a href="index.php">Quay lại trang chủ</a>
            </div>
            <div class="modal" id="modalDelete">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Cảnh báo xóa dữ liệu</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <form action="delete.php" method="post">
                        <!-- Modal body -->
                        <div class="modal-body">
                        Bạn có chắc chắn muốn xóa tỉnh "<span id="d-tinh" name="d-tinh"></span>" ?
                            <input name="del-tinh" id="d-id" hidden />
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">Xóa</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal" id="modalEdit">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Sửa dữ liệu</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <form action="edit.php" method="post">
                        <!-- Modal body -->
                        <div class="modal-body">
                            <input id="idtinh" name="idtinh" hidden/>
                            <label>Tên tỉnh: </label>
                            <input type="text" placeholder="Sửa tên tỉnh" id="name" name="name" class="px-2" />
                            &nbsp;<span class="text-danger">(*)</span>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-info">Sửa</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal" id="modalAdd">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Thêm huyện mới</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <form action="add_huyen.php" id="form-add" method="post">
                        <!-- Modal body -->
                        <div class="modal-body">
                            <input name="tinh" hidden />
                            <script>
                                document.forms["form-add"].elements["tinh"].value = document.getElementById("ten_tinh").innerHTML;
                            </script>
                            <label for="">Tên huyện mới: </label>
                            <input onkeyup="javascript:validate()" type="text" placeholder="Thêm tên huyện" name="new-name" class="px-2" />
                            &nbsp;<span class="text-danger">(*)</span>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button name="save" type="submit" class="btn btn-success" disabled >Thêm</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function modalEdit(me) {
            
            document.getElementById("idtinh").value = me.parentNode.children["id_huyen"].innerText;
            document.getElementById("name").value = me.parentNode.children["ten_huyen"].innerText;
        }
        function modalDelete(me) {
            debugger
            document.getElementById("d-id").value = me.parentNode.children["id_huyen"].innerText;
            document.getElementById("d-tinh").innerHTML = me.parentNode.children["ten_huyen"].innerText;
        }
        function validate() {
            
            let value = document.getElementById("form-add").elements["new-name"].value;
            let btn_save = document.getElementById("form-add").elements["save"];
            if(value === "" || value == null) {
                btn_save.disabled = true;
            }
            else {
                btn_save.disabled = false;
            }
        }
    </script>
</body>

</html>