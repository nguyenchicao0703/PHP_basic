<?php
include_once("../database/connection.php");
// kiểm tra nếu chưa đăng nhập thì chuyển về trang login
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
}
$result = $dbConn->query("SELECT id, name, description, price, quantity, image, categoryId FROM products");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Danh sách sản phẩm</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>
    <div class="container mt-3">
        <p>
            <a href="./insert.php" class="btn btn-primary">Thêm sản phẩm</a>
            <a href="../category/index.php" class="btn btn-success">Danh mục</a>
            <a href="./logout.php" class="btn btn-danger">Thoát</a>
        </p>
        <h2>Danh sách sản phẩm</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Giá sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Mô tả</th>
                    <th>Hình ảnh</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['price'] . " VNĐ</td>";
                    echo "<td>" . $row['quantity'] . "</td>";
                    echo "<td>" . $row['description'] . "</td>";
                    echo "<td> <img src='" . $row['image'] . "'  width='100px' height='100px''/></td>";
                    echo "<td>
                            <a href='update.php?id=" . $row['id'] . "' class='btn btn-primary'>Sửa</a>
                            <a onclick='confirmDelete(" . $row['id'] . ")' class='btn btn-danger''>Xóa</a>
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