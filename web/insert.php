<?php
include_once("../database/connection.php");
$categories = $dbConn->query("SELECT id, name FROM categories");
?>

<?php
// xử lý post dữ liệu
// kiểm tra nếu là post submit thì mới xử lý
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    $categoryId = $_POST['categoryId'];
    $target_dir = "../uploads/";
    //Vị trí file lưu tạm trong server (file sẽ lưu trong uploads, với tên giống tên ban đầu)
    $target_file   = $target_dir . basename($_FILES["image"]["name"]);
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO products (name, image, description, price, quantity, categoryId) VALUES ('$name', '$target_file', '$description', '$price', '$quantity', '$categoryId' )";
        $result = $dbConn->exec($sql);
        header("Location: index.php");
    } else {
        echo "Có lỗi xảy ra khi upload file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <title>Thêm sản phẩm</title>
</head>

<body>
    <div class="container mt-3">
        <h2>Thêm sản phẩm</h2>
        <form action="./insert.php" method="post" id="form" enctype="multipart/form-data">
            <div class="mb-3 mt-3">
                <label for="name">Tên sản phẩm:</label>
                <input type="text" class="form-control" placeholder="Enter name" id="name" name="name">
            </div>
            <div class="mb-3">
                <label for="price">Giá sản phẩm:</label>
                <input type="number" class="form-control" placeholder="Enter price" name="price">
            </div>
            <div class="mb-3">
                <label for="quantity">Số lượng sản phẩm:</label>
                <input type="number" class="form-control" placeholder="Enter quantity" name="quantity">
            </div>
            <div class="mb-3">
                <label for="image">Ảnh sản phẩm:</label>
                <input type="file" class="form-control" placeholder="Enter image" id="image" name="image">
                <img id="image-display" alt="Hình ảnh sản phẩm" width="150px" height="150px">
            </div>
            <div class="mb-3">
                <label for="description">Mô tả sản phẩm:</label>
                <textarea class="form-control" rows="5" id="description" name="description"></textarea>
            </div>
            <div class="mb-3">
                <label for="categoryId">Danh mục: </label>
                <select class="form-control" name="categoryId">
                    <?php
                    while ($row = $categories->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                    }
                    ?>
                </select>
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