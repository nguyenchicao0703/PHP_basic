<?php
include_once("../database/connection.php");
// start session, lưu trạng thái login
session_start();
// kiểm tra nếu đã đăng nhập thì chuyển đến trang index
if (isset($_SESSION['email'])) {
    header("Location: index.php");
}
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $pswd = $_POST['pswd'];
    // lấy tài khoản theo email
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $dbConn->query($sql);
    // lấy thông tin tài khoản
    $user = $result->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        // không có tài khoản
        echo "Tài khoản không tồn tại";
        exit();
    } else {

        // kiểm tra mật khẩu
        if ($user['password'] !== $pswd) {
            echo "Mật khẩu không chính xác";
            exit();
        } else {
            // lưu trạng thái đăng nhập
            $_SESSION['email'] = $email;
            // đăng nhập thành công
            echo "Mật khẩu chính xác";
            header("Location: index.php");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Đăng nhập</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .divider:after,
        .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }
    </style>
</head>

<body>
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex align-items-center justify-content-center h-100">
                <div class="col-md-8 col-lg-7 col-xl-6">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.svg" class="img-fluid" alt="Phone image">
                </div>
                <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                    <form action="./login.php" method="post">
                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <input type="email" name="email" class="form-control form-control-lg" placeholder="Email" />
                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-4">
                            <input type="password" name="pswd" class="form-control form-control-lg" placeholder="Password" />
                        </div>

                        <div class="d-flex justify-content-around align-items-center mb-4">
                            <!-- Checkbox -->
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="form1Example3" checked />
                                <label class="form-check-label" for="form1Example3"> Nhớ mật khẩu </label>
                            </div>
                            <a href="./reset_password.php">Quên mật khẩu?</a>
                        </div>

                        <!-- Submit button -->
                        <button name="submit" type="submit" class="btn btn-primary btn-lg btn-block" style="width:100%">Sign in</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>

</html>