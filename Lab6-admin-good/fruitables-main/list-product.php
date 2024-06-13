<?php
include_once('./DBUntil.php');
include_once('./cart.php');
ini_set('display_errors', '1');

$dbHelper = new DBUntil();

// Lấy thông tin sản phẩm từ cơ sở dữ liệu dựa trên id được chuyển đến trang
if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    $product = $dbHelper->select("SELECT * FROM product WHERE id = :id", ['id' => $productId]);
    // Kiểm tra nếu có sản phẩm có id tương ứng
    if ($product) {
        $product = $product[0];
    } else {
        // Nếu không có sản phẩm, chuyển hướng người dùng đến trang không tìm thấy
        header('Location: 404.php');
        exit();
    }
} else {
    // Nếu không có id sản phẩm được chuyển đến, chuyển hướng người dùng đến trang không tìm thấy
    header('Location: 404.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Chi tiết sản phẩm</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Option 1: Include in HTML -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>

<body>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <?php if ($product['picture']) : ?>
                    <img width="500px" src="<?php echo htmlspecialchars($product['picture']); ?>" class="product-img h-100" alt="<?php echo htmlspecialchars($product['name']); ?>">
                <?php endif; ?>
            </div>
            <div class="col-md-6">
                <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                <p><strong>Giá:</strong> <?php echo htmlspecialchars($product['price']); ?> VNĐ</p>
                <form action="./cart-handle.php" method="GET">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                    <button type="submit" class="btn btn-primary"><i class='bi bi-cart'></i> Thêm vào giỏ hàng</button>
                </form>
                <a href="index.php" class="btn btn-secondary mt-3">Quay lại sản phẩm</a>
            </div>
        </div>
    </div>



    <?php
    
?>
    



</body>

</html>