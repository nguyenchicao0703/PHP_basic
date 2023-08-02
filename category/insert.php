<?php
// import connection
include_once("../database/connection.php");
$categories = $dbConn->query("SELECT id, name FROM categories");
// lấy danh sách danh mục trong db
?>

<?php
// xử lý post dữ liệu
// kiểm tra nếu là post submit thì mới xử lý
if (isset($_POST['submit'])) {
    $name = $_POST['name']; // đọc theo name của input
    $target_dir    = "../uploads/";
    //Vị trí file lưu tạm trong server (file sẽ lưu trong uploads, với tên giống tên ban đầu)
    $target_file   = $target_dir . basename($_FILES["image"]["name"]);
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {

        $sql = "INSERT INTO categories (name, image) VALUES ('$name', '$target_file')";
        $_sql = $dbConn->exec($sql);
        echo 'vô được rồi nè';
        header("Location: index.php");
    } else {
        echo "Có lỗi xảy ra khi upload file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Thêm thể loại</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="container mt-3">
        <h2>Thêm thể loại</h2>
        <form action="insert.php" method="post" enctype="multipart/form-data">
            <div class="mb-3 mt-3">
                <label for="name">Tên sản phẩm:</label>
                <input type="text" class="form-control" placeholder="Enter name" name="name">
            </div>
            <div class="mb-3">
                <label for="image">Ảnh sản phẩm:</label>
                <input type="file" class="form-control" placeholder="Enter image" id="image" name="image">
                <img id="image-display" width="100px" height="100px" alt="Hình ảnh sản phẩm">
            </div>
            <button name="submit" type="submit" class="btn btn-primary">Thêm mới</button>
        </form>
    </div>

    <script>
        // hiện ảnh khi chọn file
        const image = document.getElementById('image');
        const imageDisplay = document.getElementById('image-display');
        image.addEventListener('change', (e) => {
            const file = e.target.files[0];
            const fileReader = new FileReader();
            fileReader.onload = () => {
                imageDisplay.src = fileReader.result;
            }
            fileReader.readAsDataURL(file);
        });
    </script>

</body>

</html>