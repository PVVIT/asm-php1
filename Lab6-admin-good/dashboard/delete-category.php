<?php
include_once "DBUntil.php";
session_start();
$id = $_GET['id'];
var_dump($id);

$dbhelper = new DBUntil();

$category = $dbhelper->delete("category", "id = $id");
if ($category) {
     $_SESSION['success_message'] = "Dữ liệu đã được xóa thành công!";
}
header("Location: category.php");


?>