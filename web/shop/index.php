<?php
// MODEL
session_start();

echo "YO!";
exit;

require_once 'model/shop-model.php';
require_once 'library/functions.php';
// Get the database connection file
require_once 'library/dbConnect.php';

$products = getProducts();

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL){
  $action = filter_input(INPUT_GET, 'action');
}

switch ($action){
  case 'shop':
    $productsDisplay = buildProductsDisplay($products);
    include 'view/browse.php';
    break;

  case 'add-to-cart':
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $product = getOneProduct($id);
    // add item to cart in model
    addtoCart($product);
    // set message for success
    $_SESSION['message'] = "$product[name] successfully added to cart.";
    $productsDisplay = buildProductsDisplay($products);
    include 'view/browse.php';
    break;

  case 'cart':
    $orders = array_count_values(array_column($_SESSION['cart'], 'id'));
    // echo "<pre>" . print_r($orders, true) . "</pre>" ;
    if (count($orders) != 0) {
      $cartDisplay = buildCartDisplay($products, $orders);
    } else {
      $cartDisplay = "<h2>Your cart is empty.</h2>";
    }
    include 'view/cart.php';
    break;

  case 'delete-from-cart':
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $deleteOutcome = deleteFromCart($id);
    // Check if delete is successful
    if ($deleteOutcome) {
      $_SESSION['message'] = "Item deleted.";
    } else {
      $_SESSION['message'] = "An error occurred. Could not delete item";
    }
    // build cart display
    $orders = array_count_values(array_column($_SESSION['cart'], 'id'));
    if (count($orders) != 0) {
      $cartDisplay = buildCartDisplay($products, $orders);
    } else {
      $cartDisplay = "<h3>Your cart is empty.</h3>";
    }
    include 'view/cart.php';
    break;

  case 'checkout':
    include 'view/checkout.php';
    break;

  case 'complete':
    $firstName = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
    $lastName = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_NUMBER_INT);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
    $postalCode = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_NUMBER_INT);
    $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
    $country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING);

    $orders = array_count_values(array_column($_SESSION['cart'], 'id'));

    // Update inventory items (NOT FUNCTIONAL YET)
    // foreach($orders as $key => $value) {
    //     $outcome = removeFromInventory($key);
    //     if ($outcome) {
    //       echo "";
    //     } else {
    //       // if update fails, inform user and send back to cart
    //       $product = getOneProduct($key);
    //       $_SESSION['message'] = "Purchase not completed. $product[name] is sold out. :(";
    //       include 'view/cart.php';
    //       break;
    //     }
    // }

    // build summary display
    $summaryDisplay = buildSummaryDisplay($products, $orders);
    
    // Empty cart after displaying summary
    unset($_SESSION['cart']);

    $name = $firstName . " " . $lastName;
    $completeAddress = $address . " " . $postalCode . "<br>" . $city . " " . $country;
    include 'view/confirmation.php';
    break;

  default:
    include 'view/homepage.php';
}


?>