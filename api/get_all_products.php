<?php
// http://127.0.0.1:1234/api/get_all_products.php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once('../database/connection.php');
try {
    // lấy dữ liệu từ db
    $query = "SELECT id, name, price, quantity, image, description, categoryId FROM products";
    $result = $dbConn->query($query);
    $products = $result->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(
        array(
            "status" => true,
            "massage" => "Lấy dữ liệu thành công",
            "data" => $products
        )
    );
} catch (Exception $e) {
    echo json_encode(
        array(
            "status" => false,
            "massage" => $e->getMessage()
        )
    );
}
