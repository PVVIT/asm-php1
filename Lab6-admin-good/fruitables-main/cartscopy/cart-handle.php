<?php
ini_set('display_errors', '1');
require_once('./cart-services.php');
include_once('../coupon/DBUtil.php');
$carts = new Cart();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    if ($action == 'add') { 
        $carts->add(
            array(
                'id' => $_POST['id'],
                'name' => $_POST['name'],
                'price' => $_POST['price'],
                'img' => $_POST['img']
            )
        );
    } else if ($action == 'clear') {
        $carts->clear();
    } else if ($action == 'delete') {
        $carts->removeItem($_POST['id']);
    } else if ($action == 'update') {
        $carts->updateItemQuantity($_POST['id'], $_POST['quantity']);
    } else if ($action == "save_order") {
        // save order 
        $dbHelper = new DBUntil();
        $isCreatedOrder = $dbHelper->insert( 
            'orders',
            array(
                'userId' => 'userId', // cái này lấy từ session đăng nhập
                'total' => $carts->getTotal(),
                'status' => 0,
                'createdAt' => date('Y-m-d H:i:s'),
                'phone' => 'phone',
                'name' => 'phạm văn vũ',
                'email' => 'user@gmail.com'
            )
        ); 

    }
    header('Location: cart.php');
}
