<?php
// http://localhost:1234/category/update.php?id=1
// import connection
include_once("../database/connection.php");
// lấy danh sách danh mục trong db
$categories = $dbConn->query("SELECT id, name, image FROM categories");
// lấy id từ url
$id = $_GET['id'];
// kiểm tra id phải có && có phải là số hay không
if (!$id || !is_numeric($id)) {
    // chuyển qua trang 404.php
    header('Location: ../web/404.php');
    exit();
}
// lấy ra sản phẩm có id = $id
$sql = "SELECT id, name, image FROM categories WHERE id = '$id'";
// thực hiện câu lệnh sql
$result = $dbConn->query($sql);
$product = $result->fetch(PDO::FETCH_ASSOC);

$name = $product['name'];
$image = $product['image'];
?>

<?php
// xử lý post dữ liệu
// kiểm tra nếu là post submit thì mới xử lý
// lấy ra thông tin file
if (isset($_POST['submit'])) {
    $currentDirectory = getcwd();
    $uploadDirectory = "../uploads/";
    $fileName = $_FILES['image']['name'];
    $fileTmpName  = $_FILES['image']['tmp_name'];
    $uploadPath = $currentDirectory . $uploadDirectory . basename($fileName);
    // upload file
    move_uploaded_file($fileTmpName, $uploadPath);

    $name = $_POST['name']; // đọc theo name của input
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $id = $_POST['id'];
    $categoryId = $_POST['categoryId'];
    $description = $_POST['description'];
    // hình
    if (!$fileName) {
        $sql = "UPDATE categories SET name = '$name' where id = $id";
    } else {
        $image = "http://127.0.0.1/1234:uploads/" . $fileName;
        $sql = "UPDATE categories SET name = '$name', image = '$image' where id = $id";
    }
    $result = $dbConn->exec($sql);
    // chuyển hướng trang web về index.php
    header("Location: index.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Thêm mới sản phẩm</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="container mt-3">
        <h2>Thông tin sản phẩm</h2>
        <form action="update.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
            <div class="mb-3 mt-3">
                <label for="name">Tên sản phẩm:</label>
                <input type="hidden" value="<?php echo $id; ?>" name="id" />
                <input value="<?php echo $name; ?>" type="text" class="form-control" placeholder="Enter name" name="name">
            </div>
            <div class="mb-3">
                <label for="image">Ảnh sản phẩm:</label>
                <input type="file" class="form-control" id="image" placeholder="Enter image" name="image">
                <img width="100px" height="100px" src="<?php echo $image; ?>" id="image-display" alt="Hình ảnh sản phẩm">
            </div>

            <button name="submit" type="submit" class="btn btn-primary">Sửa</button>
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