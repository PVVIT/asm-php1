<?php

session_start();

class Cart
{
    public $items = array();
    public function __construct()
    {
        if (!isset($_SESSION['carts'])) {
            $_SESSION['carts'] = [];
        }
        // $_SESSION['carts'] = array();
        $this->items = $_SESSION['carts'];
    }
    public function add($product)
    {
        //array('id' => 1, 'name' => 'abc', 'price' =>12)
        $productId = $product['id'];
        if (isset($this->items[$productId])) {
            echo "update";
            $this->items[$productId]['quantity']++;
        } else {
            echo "add";
            $product['quantity'] = 1;
            $this->items[$productId] = $product;
        }
        $this->setCart();
    }

    public function updateItemQuantity($item_id, $quantity) {
        foreach ($this->items as &$item) {
            if ($item['id'] == $item_id) {
                $item['quantity'] = $quantity;
                break;
            }
        }
        $this->setCart();
    }
    
    public function removeItem($itemId) {
        foreach ($this->items as $key => $item) {
            if ($item['id'] == $itemId) {
                unset($this->items[$key]);
                // Lưu lại trạng thái của giỏ hàng nếu cần thiết
                $this->setCart();
                break;
            }
        }
    }
    public function clear()
    {
        $this->items = array();
        $this->setCart();
    }

    public function update($quantity, $productId)
    {
    }

    public function setCart()
    {
        $_SESSION['carts'] = $this->items;
    }

    public function getCart()
    {
        return $this->items;
    }

    public function getTotal()
    {
        $sum = 0;
        foreach ($this->items as $product) {
            $sum += $product['price'] * $product['quantity'];
        }
        return $sum;
    }
}
