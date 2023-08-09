<?php 
// http://127.0.0.1:1234/api/login.php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once('../database/connection.php');
include_once("./jwt.php");
try {
    // đọc dữ liệu từ body request
    $data = json_decode(file_get_contents("php://input"));
    $email = $data->email;
    $password = $data->password;
    // kiểm tra dữ liệu
    if(empty($email) || empty($password)) {
        throw new Exception("Không được để trống");
    }
    // kiểm tra email đã tồn tại chưa
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = $dbConn->query($query);
    $user = $result->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        throw new Exception("Email chưa được đăng ký");
    } else {
        // kiểm tra mật khẩu
        $pwd = $user['password'];
        if($password != $pwd) {
            throw new Exception("Mật khẩu không chính xác");
        } else {
            //tạo token
            $token= array(
                "id"=> $user['id'],
                "email"=> $user['email'],
                "name"=> $user['name'],
                "exp"=> (time()+ 60)
            );
            $headers = array('alg'=> 'HS256','type'=>'JWT');
            $jwt= generate_jwt($headers,$token);
            echo json_encode(
                array(
                    "status" => true,
                    "message" => "Đăng nhập thành công",
                    "token" => $jwt
                )
            );
        }
    }
} catch (Exception $e) {
    echo json_encode(
        array(
            "status" => false,
            "message" => $e->getMessage()
        )
    );
}
//jwt: json web token
//access token: 1 ngày
//refresh token : 7 days
