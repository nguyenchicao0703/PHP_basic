<?php
// http://127.0.0.1:1234/api/get_all_products.php?keyword=1&sort=1&limit=3&page=2
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once('../database/connection.php');
try {
    // đọc keyword từ url
    $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : "";
    $sort = isset($_GET['sort']) ? $_GET['sort'] : 0;
    if (!is_numeric($sort)) {
        $sort = 0;
    }
    if ($sort == 0) {
        $sort = 'p.id asc';
    } else if ($sort == 1) {
        $sort = 'p.id desc';
    } else if ($sort == 2) {
        $sort = 'p.price asc';
    } else if ($sort == 3) {
        $sort = 'p.price desc';
    }
    $limit = isset($_GET['limit']) ? $_GET['limit'] : 3;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    if (!is_numeric($limit)) {
        $limit = 3;
    }
    if (!is_numeric($page)) {
        $page = 1;
    }
    // tính offset
    $offset = ($page - 1) * $limit;
    // lấy dữ liệu từ db
    $query = "SELECT p.id, p.name, p.price, p.quantity, p.image, 
            p.description, p.categoryId, c.name as 'categoryName' 
            FROM products p 
            INNER JOIN categories c 
            ON p.`categoryId` = c.id 
            WHERE p.name like '%$keyword%'
            ORDER BY $sort 
            LIMIT $offset, $limit";
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
