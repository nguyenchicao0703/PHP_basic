<?php
// http://127.0.0.1:1234/delete.php/id=1
// import connection
include_once("../database/connection.php");
// đọc id từ url
$id = $_GET['id'];
// xóa sản phẩm có id = $id
$sql = "DELETE FROM categories WHERE id = $id";
// thực thi câu lệnh
$result = $dbConn->exec($sql);
// điều hướng về trang index.php
header("Location: index.php");
?>