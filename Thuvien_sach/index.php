<!DOCTYPE html>
<?php 
		$conn = new mysqli('127.0.0.1', "root","yourpassword", "yourdbName");
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
	
	<div class="container-fluid p-0">

		<div class="header row text-white">
			<div class="font-weight-bold m-auto">Thư viện sách</div>
		</div>
		<div class="content">
			<div class="toolbar">
				<nav class="navbar navbar-expand-sm row">
					<ul class="navbar-nav col-sm-4">
						<li class="nav-item ml-4">
						<a class="nav-link btn btn-info ml-2" id="add" data-toggle="modal" data-target="#modalAdd">Thêm</a>
						</li>
						<li class="nav-item">
						<a class="nav-link btn btn-info ml-2 disabled" id="edit" data-toggle="modal" data-target="#modalEdit" >Sửa</a>
						</li>
						<li class="nav-item">
						<a class="nav-link btn btn-info ml-2 disabled" id="delete" data-toggle="modal" data-target="#modalDelete" >Xóa</a>
						</li>
					</ul>
					<div class="col-sm"></div>
					<form class="form-inline col-sm-5" action="find.php" method="post">
						<input class="form-control mr-sm-1" name="tentheloai" type="text" placeholder="Tìm kiếm theo thể loại sách">
						<button class="btn bg-secondary text-white" type="submit" onclick = "search()">Tìm</button>
					</form>
				</nav>
			</div>
			<div class="main">
				<table class="main-table table-striped table-bordered">
					<thead>
						<tr>
							<th>Mã sách</th>
							<th>Tên sách</th>
							<th>Năm xuất bản</th>
							<th>Thể loại</th>
							<th ><input id="check-all" type="checkbox" name="check-box" /></th>
						</tr>
					</thead>
					<tbody>
					 <?php
						$query = "SELECT ls.tentheloai, s.masach, s.tensach, s.namxb FROM Sach s
						JOIN LoaiSach ls ON s.matheloai = ls.matheloai ORDER BY s.masach ASC";
						$result = $conn->query($query);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) 
							{
				
								$masach = $row["masach"];
								$tensach = $row["tensach"];
								$namxb = $row["namxb"];
								$tentheloai = $row["tentheloai"];
								echo "<tr>";
								echo "<td name='masach'>$masach</td>";
								echo "<td name='tensach'>$tensach</td>";
								echo "<td name='namxb'>$namxb</td>";
								echo "<td name='matheloai'>$tentheloai</td>";
								echo '<td ><input type="checkbox" name="check-box" onclick="javascript:checkButton()" /></td>';
								echo "</tr>";									
							}
						}
					 ?>
					 
					</tbody>
				</table>
			</div>
		</div>
		<div class="modal fade" id="modalAdd">
			<div class="modal-dialog">
			<div class="modal-content">
			
				<!-- Modal Header -->
				<div class="modal-header">
				<h4 class="modal-title">Thêm mới</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				
				<!-- Modal body -->
				<form action="add_new.php" method="post">
					<div class="modal-body">
						<label for="">Chọn thể loại: </label>
						<select class="form-control" name="theloai">
							<?php
								$query = "SELECT * FROM LoaiSach";
								$result = $conn->query($query);
								if ($result->num_rows > 0) {
									// output data of each row
									while($row = $result->fetch_assoc()) 
									{
										echo "<option value=\"" . $row["matheloai"] . "\" >". $row["tentheloai"] ."</option>";							
									}
								}
								?>
						</select>
						<br />
						<label for="">Mã sách: </label>
						<input type="text" placeholder="Thêm mã sách" name="new-id" class="px-2" />
						&nbsp;<span class="text-danger">(*)</span>
						<br />
						<label for="">Tên sách: </label>
						<input type="text" placeholder="Thêm tên sách" name="new-name" class="px-2" />
						&nbsp;<span class="text-danger">(*)</span>
						<br/>
						<label for="">Năm xuất bản: </label>
						<input type="number" placeholder="Năm xuất bản" name="new-year" class="px-2" />
						&nbsp;<span class="text-danger">(*)</span>
					</div>
					
					<!-- Modal footer -->
					<div class="modal-footer">
						<button type="submit" class="btn btn-success">Thêm mới</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
					</div>
					
				</form>
			</div>
			</div>
		</div>
		<div class="modal fade" id="modalEdit">
			<div class="modal-dialog">
			<div class="modal-content">
			
				<!-- Modal Header -->
				<div class="modal-header">
				<h4 class="modal-title">Sửa thông tin</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<form action="edit.php" method="post">
					<!-- Modal body -->
					<div class="modal-body">
						<input id="masach" name="masach" hidden/>
						<label for="">Tên sách: </label>
						<input type="text" placeholder="Sửa tên sách" id="name" name="name" class="px-2" />
						&nbsp;<span class="text-danger">(*)</span>
						<br/>
						<label for="">Năm xuất bản: </label>
						<input type="number" placeholder="Sửa năm xuất bản" id="year" name="year" class="px-2" />
						&nbsp;<span class="text-danger">(*)</span>
					</div>
					
					<!-- Modal footer -->
					<div class="modal-footer">
						<button type="submit" class="btn btn-success">Save</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>
			</div>
		</div>
		<div class="modal fade" id="modalDelete">
			<div class="modal-dialog">
			<div class="modal-content">
			
				<!-- Modal Header -->
				<div class="modal-header">
				<h4 class="modal-title">Xóa thông tin</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<form action="delete.php" method="post">
					<!-- Modal body -->
					<div class="modal-body">
						Bạn có chắc chắn muốn xóa sách "<span id="d-sach" name="d-sach"></span>" không?
						<input name="delete_id" id="d-id" hidden />
					</div>
					
					<!-- Modal footer -->
					<div class="modal-footer">
						<button type="submit" class="btn btn-danger">Xóa</button>
						<button type="button" class="btn btn-success" data-dismiss="modal">Hủy</button>
					</div>
				</form>
			</div>
			</div>
		</div>
		<script>

			document.getElementById("check-all").onclick = function() {
				let checkboxes = document.getElementsByName('check-box');
				if(document.getElementById("check-all").checked == true) {

					for (var i = 0; i < checkboxes.length; i++){
						checkboxes[i].checked = true;
					}
					// document.getElementById("delete").classList.remove("disabled");
				}
				else {
					for (var i = 0; i < checkboxes.length; i++){
						checkboxes[i].checked = false;
						
					}
					document.getElementById("delete").classList.add("disabled");
					document.getElementById("edit").classList.add("disabled");
				}
			}
			function checkButton() {
				let count = countChecked();
				if(count == 1) {
					let me = getCheckedNode();
					document.getElementById("delete").classList.remove("disabled");
					document.getElementById("edit").classList.remove("disabled");
					document.getElementById("name").value = me.parentElement.parentElement.children.tensach.innerText;
					document.getElementById("year").value = me.parentElement.parentElement.children.namxb.innerText;
					document.getElementById("masach").value = me.parentElement.parentElement.children.masach.innerText;
					document.getElementById("d-id").value = me.parentElement.parentElement.children.masach.innerText;
					document.getElementById("d-sach").innerHTML = me.parentElement.parentElement.children.tensach.innerText;
				}
				else {
					if(count == 0) {
						document.getElementById("delete").classList.add("disabled");
						document.getElementById("edit").classList.add("disabled");
					}
					else {
						document.getElementById("delete").classList.add("disabled");
						document.getElementById("edit").classList.add("disabled");
					}
				}
			}
			function countChecked() {
				let checkboxes = document.getElementsByName('check-box');
				let count = 0;
				for(let i = 0; i < checkboxes.length; i++) {
					if(checkboxes[i].checked == true) count++;
				}
				return count;
			}
			function getCheckedNode() {
				let checkboxes = document.getElementsByName('check-box');
				for(let i = 0; i < checkboxes.length; i++) {
					if(checkboxes[i].checked == true) return checkboxes[i];
				}
				return null;
			}
		</script>
		<?php
			$conn->close();
		?>
	</div>
</body>
</html>
