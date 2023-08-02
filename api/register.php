<?php
// http://127.0.0.1:1234/api/register.php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once("../database/connection.php");
try {
    // đọc dữ liệu từ body request
    $data = json_decode(file_get_contents("php://input"));
    $email = $data->email;
    $password = $data->password;
    $name = $data->name;
    // kiểm tra dữ liệu
    if(empty($email) || empty($password) || empty($name)) {
        throw new Exception("Không được để trống");
    }
    // kiểm tra email đã tồn tại chưa
    $query = "SELECT * FROM users WHERE email = '$email'";
    $stmt = $dbConn->prepare($query);
    $stmt->execute();
    $num = $stmt->rowCount();
    if ($num > 0) {
        throw new Exception("Email đã tồn tại");
    } else {
        // tạo tài khoản
        $query = "INSERT INTO users SET email = '$email', password ='$password', name = '$name'";
        $stmt = $dbConn->prepare($query);
        $stmt->execute();
        echo json_encode(
            array(
                "status" => true,
                "message" => "Đăng ký thành công"
            )
        );
    }
} catch (Exception $e) {
    echo json_encode(
        array(
            "status" => false,
            "message" => $e->getMessage()
        )
    );
}
