<?php

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

$products = array( 
    array(
        "id" => 0,
        "name" => "Elegant Clock", 
        "price" => "699",
        "description" => "A very elegant and retro vibe bedside clock.",
        "image" => "../images/clock.png",
        "stock" => "6"), 
    array(
        "id" => 1,
        "name" => "Cute Scented Candles", 
        "price" => "299",
        "description" => "A lively array of citrus fruit candles designed to brighten up your day.",
        "image" => "../images/candles.png",
        "stock" => "12"), 
    array(
        "id" => 2,
        "name" => "Vintage Desk Lamp", 
        "price" => "2499",
        "description" => "A gorgeous vintage-styled lamp that can make any space cozy. It has a fabric lampshade and a body made out of beech wood.",
        "image" => "../images/lamp.png",
        "stock" => "10"), 
    array(
        "id" => 3,
        "name" => "Classic Water Goblet", 
        "price" => "399",
        "description" => "An elegant and very delicate piece of dining ware. Perfect for a stylish table spread.",
        "image" => "../images/glass.png",
        "stock" => "6"), 
    array(
        "id" => 4,
        "name" => "Cement Clock", 
        "price" => "1299",
        "description" => "Sturdy and stylish. These clocks are sure to grab your everybody's eye.",
        "image" => "../images/cement-clock.png",
        "stock" => "3"), 
    array(
        "id" => 5,
        "name" => "Clam Shell Jewelry Holder", 
        "price" => "999",
        "description" => "A brilliant and gorgeous way to keep your jewelry in order.",
        "image" => "../images/shell.png",
        "stock" => "12")
);

function getProducts(){
    GLOBAL $products;
    return $products;
}

function getOneProduct($id) {
    GLOBAL $products;
    foreach($products as $product) {
        if ($product['id'] == $id) {
            return $product;
        }
    }
    echo "That product doesn't exist.";
}

function getCartItems() {
    return $_SESSION['cart'];
}

function addToCart($product) {
    $_SESSION['cart'][] = $product;
}

function deleteFromCart($id){
    // echo "<pre>" . print_r($_SESSION['cart'], true) . "</pre>" ;
    for ($i = 0; $i <= count($_SESSION['cart']); $i++) {
        if ($_SESSION['cart'][$i]['id'] == $id) {
            array_splice($_SESSION['cart'],$i, 1);
            // echo "<pre>" . print_r($_SESSION['cart'], true) . "</pre>" ;
            return 1;
        } else {
            return 0;
        }
      }
}

function removeFromInventory($id) {
    GLOBAL $products;
    foreach($products as $product) {
        if ($product['id'] == $id) {
            $product['stock'] -= 1;
            return 1;
        }
    }
    return 0;
}

?>