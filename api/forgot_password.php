<?php
// http://127.0.0.1:1234/api/forgot_password.php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once('../database/connection.php');

use PHPMailer\PHPMailer\PHPMailer;

include_once $_SERVER['DOCUMENT_ROOT'] . '../utilities/PHPMailer-master/src/PHPMailer.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '../utilities/PHPMailer-master/src/SMTP.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '../utilities/PHPMailer-master/src/Exception.php';
try {
    // đọc email từ boby
    $data = json_decode(file_get_contents("php://input"));
    $email = $data->email;
    // kiểm tra email có hay không
    if (!isset($email)) {
        throw new Exception("Dữ liệu không được để trống");
    }
    // kiểm tra email có trong db hay không
    $query = "SELECT id FROM users WHERE email = '$email'";
    $result = $dbConn->query($query);
    if (!$result) {
        echo json_encode(
            array(
                "status" => false,
                "message" => "Email không tồn tại"
            )
        );
    }
    // tạo token bằng md5
    $token = md5($email . time());
    // lưu token vào db
    $dbConn->query("INSERT INTO reset_password (email, token) VALUES ('$email', '$token')");
    // gửi email
    $link = "<a href='http://127.0.0.1:1234/web/reset_password.php?email="
        . $email . "&token=" . $token . "'>Click to reset password</a>";
    $mail = new PHPMailer();
    $mail->CharSet = "utf-8";
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Username = "chicao0703";
    $mail->Password = "rwmhosyrwdfjutqy";
    $mail->SMTPSecure = "ssl";
    $mail->Host = "ssl://smtp.gmail.com";
    $mail->Port = "465";
    $mail->From = "chicao0703@gmail.com";
    $mail->FromName = "Jennie my love";
    $mail->addAddress($email, 'Hello');
    $mail->Subject = "Reset Password";
    $mail->isHTML(true);
    $mail->Body = "Click on this link to reset password " . $link . " ";
    $res = $mail->Send();
    if ($res) {
        echo json_encode(
            array(
                "status" => true,
                "message" => "Email sent."
            )
        );
    } else {
        echo json_encode(
            array(
                "status" => false,
                "message" => "Email sent failed."
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
