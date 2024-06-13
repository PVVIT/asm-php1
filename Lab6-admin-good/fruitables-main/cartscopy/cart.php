<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./cart.css">
</head>

<body>
    <?php include_once('./cart-services.php');
    $carts = new Cart();

    include_once('../coupon/DBUtil.php');
    ini_set('display_errors', '1');

    $dbHelper = new DBUntil();

    $errors = [];
    $discount = 0;
    function checkCode($code)
    {
        /**
         *  còn hạn sử dụng
         *          */
        // 6/6-> 9/6 
        global $dbHelper;
        $sql = $dbHelper->select(
            "SELECT * FROM coupon WHERE code = :code AND quantity > 0 AND 
        starDate <= :currentDate AND endDate >= :currentDate",
            array(
                'code' => $code,
                'currentDate' => date("Y-m-d")
            )
        );
        if (count($sql) > 0) {
            return $sql[0];
        } else {
            return  null;
        }
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) == 'checkCode') {
        if (!empty($_POST['code'])) {
            $isCheck =  checkCode($_POST['code']);
            if (!empty($isCheck)) {
                $discount =   $isCheck['discount'];
            }
        } elseif ($_POST['action'] == 'delete' && isset($_POST['item_id'])) {
            $item_id = $_POST['item_id'];
            $carts->removeItem($item_id);
        } elseif ($_POST['action'] == 'update' && isset($_POST['item_id']) && isset($_POST['quantity'])) {
            $item_id = $_POST['item_id'];
            $quantity = intval($_POST['quantity']);
            $carts->updateItemQuantity($item_id, $quantity);
        }
    }

    ?>
    <div class="container padding-bottom-3x mb-1">
        <!-- Alert-->
        <!-- Shopping Cart-->
        <div class="table-responsive shopping-cart">
            <table class="table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Subtotal</th>
                        <th class="text-center">Discount</th>
                        <th class="text-center">
                            <form method="post" action="cart-handle.php">
                                <button type="submit" name="action" value="clear" class="btn btn-danger">clear</button>
                            </form>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $carts = new Cart();
                    foreach ($carts->getCart() as $item) { ?>
                        <tr>
                            <td>
                                <div class="product-item">
                                    <a class="product-thumb" href="#"><img src="<?php echo $item['img'] ?>" alt="Product"></a>
                                    <div class="product-info">
                                        <h4 class="product-title">
                                            name: <?php echo $item['name'] ?></br>
                                            price: <?php echo $item['price'] ?>
                                        </h4>
                                    </div>
                            </td>
                            <td class="text-center">
                                <form method="post" action="">
                                    <div class="count-input">
                                        <select class="form-control" name="quantity">
                                            <option value="<?php echo $item['quantity'] ?>"><?php echo $item['quantity'] ?></option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    <input type="hidden" name="item_id" value="<?php echo $item['id']; ?>">
                                    <button type="submit" name="action" value="update" class="btn btn-primary">Update</button>
                                </form>
                            </td>
                            <td class="text-center text-lg text-medium"><?php echo $item['price'] ?></td>
                            <td class="text-center text-lg text-medium">0</td>
                            <td class="text-center">
                                <form method="post" action="">
                                    <input type="hidden" name="item_id" value="<?php echo $item['id']; ?>">
                                    <button type="submit" name="action" value="delete" class="btn btn-link text-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="shopping-cart-footer">
            <div class="column">
                <form class="coupon-form" action="" method="post">
                    <input name="code" class="form-control form-control-sm" type="text" placeholder="Coupon code" required="">
                    <button class="btn btn-outline-primary btn-sm" name="action" value="checkCode" type="submit">Apply
                        Coupon</button>
                </form>
            </div>
            <div class="column text-lg">Discount: <span class="text-medium"><?php echo  floatval($discount * $carts->getTotal() / 100)  ?></span>
            </div>
            <div class="column text-lg">Total: <span class="text-medium"><?php echo floatval($carts->getTotal() - ($discount * $carts->getTotal()) / 100) ?></span>
            </div>
        </div>
        <div class="shopping-cart-footer">
            <div class="column"><a class="btn btn-outline-secondary" href="../index.php"><i class="icon-arrow-left"></i>&nbsp;Back
                    to Shopping</a></div>
            <div class="column">
                <a class="btn btn-success" href="./malefashion-master/checkout.php">Checkout</a>
                <a class="btn btn-danger" href="../coupon/index.php">Coupon</a>

            </div>
        </div>
    </div>
</body>

</html>