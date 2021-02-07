<?php

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Gets all products in database
function getProducts(){
    $db = dbConnect(); 
    $sql = ' SELECT * FROM product '; 
    $stmt = $db->prepare($sql);
    $stmt->execute(); 
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    $stmt->closeCursor(); 
    return $products; 
}

// Gets one product with matching id
function getOneProduct($id, $products) {
    foreach($products as $product) {
        if ($product['prod_id'] == $id) {
            return $product;
        }
    };
    // if there's no match, return fail
    return 0;
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

function getProductsBySearch($products, $searchTerm) {
    $results = [];
    foreach($products as $product) {
        $name = strtolower($product['prod_name']);
        $search = strtolower($searchTerm);
        if( strpos( $name, $search ) !== false) {
            array_push($results, $product);
        }
    }
    return $results;
}

?>