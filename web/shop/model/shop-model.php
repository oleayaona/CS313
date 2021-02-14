<?php

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Gets all products in database
function getProducts(){
    $db = dbConnect(); 
    $sql = ' SELECT * FROM product'; 
    $stmt = $db->prepare($sql);
    $stmt->execute(); 
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    $stmt->closeCursor(); 
    return $products; 
}

function getProductsByCategory($category) {
    $db = dbConnect(); 
    $sql = ' SELECT * FROM product WHERE prod_category = :category'; 
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':category', $category, PDO::PARAM_INT);
    $stmt->execute(); 
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    $stmt->closeCursor(); 
    return $products; 
}

// Gets one product with matching id
function getOneProduct($id) {
    $db = dbConnect(); 
    $sql = ' SELECT * FROM product WHERE prod_id = :id'; 
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute(); 
    $product = $stmt->fetch(PDO::FETCH_ASSOC); 
    $stmt->closeCursor(); 
    return $product; 
}

function getCategories(){
    $db = dbConnect(); 
    $sql = ' SELECT * FROM category '; 
    $stmt = $db->prepare($sql);
    $stmt->execute(); 
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    $stmt->closeCursor(); 
    return $results;
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

// Get products using search keyword
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


// Checks for existing customer mail
function checkExistingEmail($customer_email) {
    $db = dbConnect(); 
    $sql = ' SELECT * FROM customer WHERE customer_email = :customer_email'; 
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':customer_email', $customer_email, PDO::PARAM_STR);
    $stmt->execute(); 
    $match = $stmt->fetch(PDO::FETCH_ASSOC); 
    $stmt->closeCursor(); 

    // return 0 if false, return 1 is true
    if (empty($match)) {
        return 0;
    } else {
        return 1;
    }

}

// Adds customer to db
function addCustomer($customer_email) {
    $db = dbConnect();
    $sql = 'INSERT INTO customer (customer_email) VALUES (:customer_email)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':customer_email', $customer_email, PDO::PARAM_STR);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

// Retrieves a customer's info from db
function getCustomer($customer_email) {
    $db = dbConnect();
    $sql = 'SELECT * FROM customer WHERE customer_email = :customer_email';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':customer_email', $customer_email, PDO::PARAM_STR);
    $stmt->execute(); 
    $customer = $stmt->fetch(PDO::FETCH_ASSOC); 
    $stmt->closeCursor(); 
    return $customer; 
}

// Create order in db
function createOrder($customer_id) {
    $db = dbConnect();
    $sql = 'INSERT INTO public.order (customer_id) VALUES (:customer_id)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':customer_id', $customer_id, PDO::PARAM_INT);
    $stmt->execute();
    $order_id = $db->lastInsertId('order_order_id_seq');
    $stmt->closeCursor();
    return $order_id;
}

// Create recipient in db
function createRecipient($fname, $lname, $phone, $address, $postal_code, $city, $country, $order_id) {
    $db = dbConnect();
    $sql = 'INSERT INTO recipient (fname, lname, phone, address, postal_code, city, country, order_id)
        VALUES (:fname, :lname, :phone, :address, :postal_code, :city, :country, :order_id)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':fname', $fname, PDO::PARAM_STR);
    $stmt->bindValue(':lname', $lname, PDO::PARAM_STR);
    $stmt->bindValue(':phone', $phone, PDO::PARAM_STR);
    $stmt->bindValue(':address', $address, PDO::PARAM_STR);
    $stmt->bindValue(':postal_code', $postal_code, PDO::PARAM_INT);
    $stmt->bindValue(':city', $city, PDO::PARAM_STR);
    $stmt->bindValue(':country', $country, PDO::PARAM_STR);
    $stmt->bindValue(':order_id', $order_id, PDO::PARAM_INT);
    $stmt->execute();
    
    $recipient_id = $db->lastInsertId('recipient_recipient_id_seq'); 
    $stmt->closeCursor();

    return $recipient_id;
}

// Attach recipient to order
function addOrderRecipient($order_id, $recipient_id) {
    $db = dbConnect();
    $sql = 'UPDATE public.order SET recipient_id = :recipient_id WHERE order_id = :order_id';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':recipient_id', $recipient_id, PDO::PARAM_INT);
    $stmt->bindValue(':order_id', $order_id, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();

    return $rowsChanged;
}

// Binds products to orders
function addProductOrder($order_id, $prod_id) {
    $db = dbConnect();
    $sql = 'INSERT INTO order_item (order_id, prod_id) VALUES (:order_id, :prod_id)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':order_id', $order_id, PDO::PARAM_INT);
    $stmt->bindValue(':prod_id', $prod_id, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

// Remove item from inventory
function removeFromInventory($prod_id) {
    $db = dbConnect();
    $sql = 'UPDATE product SET prod_stock -= 1 WHERE prod_id = :prod_id';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':prod_id', $prod_id, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();

    return $rowsChanged;
}

?>