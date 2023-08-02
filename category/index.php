<?php
// import connection
include_once("../database/connection.php");
// start session, lưu trạng thái login
session_start();
// kiểm tra nếu đã đăng nhập thì chuyển hướng về trang chủ
if (isset($_SESSION['email'])) header("Loacation: login.php");
$result = $dbConn->query("SELECT id, name, image FROM categories");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Danh sách thể loại</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>

    <div class="container mt-3">
        <p>
            <a href="insert.php" class="btn btn-primary">Thêm thể loại</a>
            <a href="../web/index.php" class="btn btn-danger">Trở về sản phẩm</a>
        </p>
        <h2>Danh sách thể loại</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Mã</th>
                    <th>Tên thể loại</th>
                    <th>Hình ảnh</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td> <img src='" . $row['image'] . "'  width='100px' height='100px''/></td>";
                    echo "<td>
                            <a href='update.php?id=" . $row['id'] . "' class='btn btn-primary'>Sửa</a>
                            <a onclick='confirmDelete(" . $row['id'] . ")' class='btn btn-danger'>Xóa</a>
                        </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>

<script>
    const confirmDelete = (id) => {
        swal({
                title: "Bạn có chắc chắn không?",
                text: "Xóa sẽ không thể phục hồi được!!!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.location.href = `delete.php?id=${id}`;
                }
            });
    }
</script>

</html>