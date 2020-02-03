<!DOCTYPE html>
<html lang="vi">
<?php include("connect.php"); ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Danh mục tỉnh</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
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
            <h3 class="text-white font-weight-bold my-auto">Danh mục tỉnh</h3>
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
            <table id="main_table" class="table-bordered table-striped w-100">
                <thead>
                    <tr>
                        <th>Mã tỉnh</th>
                        <th>Tên tỉnh</th>
                        <th>Số huyện</th>
                        <th>Xóa</th>
                        <th>Sửa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $query = "SELECT t.id, t.name, COUNT(h.id) AS total FROM Tinh t LEFT JOIN Huyen h ON t.id = h.tinhid GROUP BY t.id ORDER BY name";
                        $result = $conn->query($query);
                        if ($result->num_rows > 0) {
                            // output data of each row
                            
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td name='id_tinh'>". $row["id"] ."</td>";
                                echo "<td name='ten_tinh'><a href='#' onclick='javascript:sendHuyen(this)'>". $row["name"] ."</a></td>";
                                echo "<td name='tong_huyen'>". $row["total"] ."</td>";
                                echo "<td onclick='javascript:modalDelete(this)' class='btn-delete' data-toggle=\"modal\" data-target=\"#modalDelete\">X</td>";
                                echo "<td class='btn-edit' data-toggle=\"modal\" data-target=\"#modalEdit\" onclick='javascript:modalEdit(this)'>edit</td>";
                                echo "</tr>";
                            }
                            
                        }
                    
                    ?>
                </tbody>
            </table>
            <form id="form-huyen" action="huyen.php" method="post" hidden>
                <input name="tinh_val" id="tinh_val" />
            </form>
        </div>
        <div class="footer row fixed-bottom"></div>

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
                        <h4 class="modal-title">Thêm tỉnh mới</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <form action="add_new.php" id="form-add" method="post">
                        <!-- Modal body -->
                        <div class="modal-body">
                            <label for="">Tên tỉnh mới: </label>
                            <input onkeyup="javascript:validate()" type="text" placeholder="Thêm tên tỉnh" name="new-name" class="px-2" />
                            &nbsp;<span class="text-danger">(*)</span>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" disabled >Thêm</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function modalEdit(me) {
            document.getElementById("idtinh").value = me.parentNode.children["id_tinh"].innerText;
            document.getElementById("name").value = me.parentNode.children["ten_tinh"].innerText;
        }
        function modalDelete(me) {
            debugger
            document.getElementById("d-id").value = me.parentNode.children["id_tinh"].innerText;
            document.getElementById("d-tinh").innerHTML = me.parentNode.children["ten_tinh"].innerText;
        }
        function validate() {
            let value = document.getElementById("form-add").elements["new-name"].value;
            let btn_save = document.getElementById("form-add").elements[1];
            if(value === "" || value == null) {
                btn_save.disabled = true;
            }
            else {
                btn_save.disabled = false;
            }
        }
        function sendHuyen(me) {
            document.getElementById("tinh_val").value = me.text;
            document.getElementById("form-huyen").submit();
        }

    </script>
</body>

</html>