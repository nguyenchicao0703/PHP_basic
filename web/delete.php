<?php 
// http://127.0.0.1:1234/web/delete.php?id=1
include_once("../database/connection.php");
// đọc id từ url
$id = $_GET['id'];
// xóa sản phẩm có id = $id
$sql = "DELETE FROM products WHERE id = $id";
// thực thi câu lệnh
$result = $dbConn->exec($sql);
// điều hướng về trang index.php
header("Location: index.php");
?>