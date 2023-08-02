<?php
include_once("../database/connection.php");
// nếu là submit thì mới xử lý
if (isset($_POST['submit'])) {
    //Vị trí file lưu tạm trong server (file sẽ lưu trong uploads, với tên giống tên ban đầu)
    $currentDirectory = getcwd();
    $uploadDirectory = "../uploads/";
    $fileName = $_FILES['image']['name'];
    $fileTmpName  = $_FILES['image']['tmp_name'];
    $uploadPath = $currentDirectory . $uploadDirectory . basename($fileName);
    // upload file
    move_uploaded_file($fileTmpName, $uploadPath);
    // upload file
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    $categoryId = $_POST['categoryId'];
    if (!$fileName) {
        $sql = "UPDATE products SET name = '$name', price = '$price', quantity = '$quantity',  categoryId = '$categoryId', description = '$description' where id = $id";
    } else {
        $image = "http://127.0.0.1/1234:uploads/" . $fileName;
        $sql = "UPDATE products SET name = '$name', price = '$price', quantity = '$quantity',  categoryId = '$categoryId', image = '$image', description = '$description' where id = $id";
    }
    // thực thi câu lệnh sql
    $result = $dbConn->exec($sql);
    header("Location: index.php");
} else {
    $categories = $dbConn->query("SELECT id, name, image FROM categories");
    // http://127.0.0.1:1234/web/update.php?id=1
    // đọc id từ url
    $id = $_GET['id'];
    // kiểm tra id phải có và có phải là số hay không
    if (!$id || !is_numeric($id)) {
        header("Location: ../web/404.php");
        exit();
    }
    // lấy sản phẩm có id = $id
    $sql = "SELECT id, name, description, price, quantity, image, categoryId FROM products WHERE id = '$id'";
    $result = $dbConn->query($sql);
    // lấy ra một bản ghi
    $product = $result->fetch(PDO::FETCH_ASSOC);
    // kiểm tra nếu không có bản ghi thì hiện lỗi
    if (!$product) {
        echo "Không tồn tại sản phẩm";
        exit();
    }
    // lấy chi tiết sản phẩm
    $id = $product['id'];
    $name = $product['name'];
    $price = $product['price'];
    $quantity = $product['quantity'];
    $image = $product['image'];
    $description = $product['description'];
    $categoryId = $product['categoryId'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <title>Chỉnh sửa thể loại</title>
</head>

<body>
    <div class="container mt-3">
        <h2>Chỉnh sửa thể loại</h2>
        <form action="./update.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
            <div class="mb-3 mt-3">
                <label for="name">Tên sản phẩm:</label>
                <input type="hidden" value="<?php echo $id; ?>" name="id">
                <input value="<?php echo $name; ?>" type="text" class="form-control" placeholder="Enter name" name="name">
            </div>
            <div class="mb-3">
                <label for="price">Giá sản phẩm:</label>
                <input value="<?php echo $price; ?>" type="number" class="form-control" placeholder="Enter price" name="price">
            </div>
            <div class="mb-3">
                <label for="quantity">Số lượng sản phẩm:</label>
                <input value="<?php echo $quantity; ?>" type="number" class="form-control" placeholder="Enter quantity" name="quantity">
            </div>
            <div class="mb-3">
                <label for="image">Ảnh sản phẩm:</label>
                <input type="file" class="form-control" placeholder="Enter image" id="image" name="image">
                <img src="<?php echo $image; ?>" id="image-display" alt="Hình ảnh sản phẩm" width="150px" height="150px">
            </div>
            <div class="mb-3">
                <label for="description">Mô tả sản phẩm:</label>
                <textarea class="form-control" rows="5" id="description" name="description"><?php echo $description; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="categoryId">Thể loại: </label>
                <select class="form-control" name="categoryId">
                    <?php
                    while ($row = $categories->fetch(PDO::FETCH_ASSOC)) {
                        if ($row['id'] === $categories->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option selected='" . $row['id'] . "'>" . $row['name'] . "</option>";
                        } else {
                            echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <button name="submit" type="submit" class="btn btn-primary">Sửa</button>
        </form>
    </div>
</body>

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

</html>