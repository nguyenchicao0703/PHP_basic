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
    $image = $_POST['imageUrl'];
    // $target_dir = "../uploads/";
    // vị trí file lưu tạm trong server (file sẽ lưu trong uploads, với tên giống tên ban đầu)
    // $target_file   = $target_dir . basename($_FILES["image"]["name"]);
    // if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
    $sql = "INSERT INTO products (name, image, description, price, quantity, categoryId) VALUES ('$name', '$image', '$description', '$price', '$quantity', '$categoryId' )";
    $result = $dbConn->exec($sql);
    header("Location: index.php");
    // } else {
    //     echo "Có lỗi xảy ra khi upload file.";
    // }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/5.4.0/firebase.js"></script>
    <title>Thêm sản phẩm</title>
</head>

<body>
    <div class="container mt-3">
        <h2>Thêm sản phẩm</h2>
        <form action="./insert.php" method="post" id="form">
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
                <input onchange="onChangeFile()" type="file" class="form-control" id="img-file" name="image">
                <img id="img-view" alt="Hình ảnh sản phẩm" width="150px" height="150px">
                <input type="hidden" name="imageUrl" id="imageUrl">
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
        // setup firebase
        const firebaseConfig = {
            apiKey: "AIzaSyBJVW-ppXz-YnOElcuJDqM7azhAOmh5wEA",
            authDomain: "phpbasic-9de3c.firebaseapp.com",
            projectId: "phpbasic-9de3c",
            storageBucket: "phpbasic-9de3c.appspot.com",
            messagingSenderId: "54310671874",
            appId: "1:54310671874:web:3ca4487a4e908ec341f91b",
            measurementId: "G-8ML7KPW9LW"
        };
        firebase.initializeApp(firebaseConfig);
        // hiện ảnh khi chọn file
        const onChangeFile = () => {
            const file = document.getElementById('img-file').files[0];
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('img-view').src = e.target.result;
            }
            reader.readAsDataURL(file);
            // upload
            const ref = firebase.storage().ref(new Date().getTime() + '-' + file.name);
            const uploadTask = ref.put(file);
            uploadTask.on(firebase.storage.TaskEvent.STATE_CHANGED,
                (snapshot) => {},
                (error) => {console.log('firebase error: ',error)},
                () => {
                    uploadTask.snapshot.ref.getDownloadURL().then(url => {
                        console.log('>>>>> File available at:', url);
                        document.getElementById('imageUrl').value = url;
                    })
                }
            );
        }
        // hiện ảnh khi chọn file
        // const image = document.getElementById('image');
        // const imageDisplay = document.getElementById('image-display');
        // image.addEventListener('change', (e) => {
        //     const file = e.target.files[0];
        //     const fileReader = new FileReader();
        //     fileReader.onload = () => {
        //         imageDisplay.src = fileReader.result;
        //     }
        //     fileReader.readAsDataURL(file);
        // });
    </script>
</body>

</html>