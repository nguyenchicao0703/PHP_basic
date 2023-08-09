<?php
// http://127.0.0.1:1234/web/reset_password.php?email=abc@gmail&token=123456
include_once('../database/connection.php');
try {
    if (isset($_POST['submit'])) {
        // khi nhấn nút submit
        $email = $_POST['email'];
        $token = $_POST['token'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        // kiểm tra email và token có trong db không
        $query = "SELECT id FROM reset_password
                    WHERE email = '$email'
                    AND token = '$token'
                    AND avaiable = 1
                    -- token chưa được sử dụng
                    -- token còn hiệu lục trong 1 giờ
                    AND createAt >= DATE_SUB(NOW(), INTERVAl 1 HOUR)";
        $result = $dbConn->query($query);
        // nếu đã dùng thì không cho reset password
        if (!$result) {
            Header("Location: 404.php");
        }
        // cập nhật mật khẩu mới
        $dbConn->query("UPDATE users SET password = '$password' WHERE email='$email'");
        // cập nhật token đã được sử dụng
        $dbConn->query("UPDATE reset_password SET avaiable = 0
                        WHERE email = '$email'
                        AND token = '$token'");
        // chuyển hướng về trang login
        Header("Location: login.php");
    } else {
        // khi người dùng bấm link trong email
        $email = $_GET['email'];
        $token = $_GET['token'];
        // kiểm tra email và token có trong url không
        if (!isset($email) || !isset($token)) {
            Header("Location: 404.php");
        }
        // kiểm tra email và token có trong db không
        $query = "SELECT id FROM reset_password
                    WHERE email = '$email'
                    AND token = '$token'
                    AND avaiable = 1
                    -- token chưa được sử dụng  
                    -- token còn hiệu lục trong 1 giờ
                    AND createAt >= DATE_SUB(NOW(), INTERVAl 1 HOUR)";
        $result = $dbConn->query($query);
        // nếu đã dùng thì không cho reset password
        if (!$result) {
            Header("Location: 404.php");
        }
    }
} catch (Exception $e) {
    Header("Location: 404.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <title>Đổi mật khẩu</title>
</head>

<body>
    <div class="container mt-3">
        <h2>Đổi mật khẩu</h2>
        <form action="reset_password.php" method="post">
            <div class="mb-3 mt-3">
                <label for="password">Mật khẩu mới</label>
                <input type="hidden" name="email" value="<?php echo $email; ?>">
                <input type="hidden" name="token" value="<?php echo $token; ?>">
                <input type="password" class="form-control" placeholder="Enter password" name="password">
            </div>
            <div class="mb-3">
                <label for="confirm_password">Nhập lại mật khẩu mới</label>
                <input type="password" class="form-control" placeholder="Enter confirm password" name="confirm_password">
            </div>
            <button name="submit" type="submit" class="btn btn-primary">Đổi mật khẩu</button>
        </form>
    </div>
</body>

</html>