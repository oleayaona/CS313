<?php
// MODEL
session_start();

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
    // Get categories
    $categories = getCategories();
    $categoriesDisplay = buildCategoriesSelect($categories, 0);
    $productsDisplay = buildProductsDisplay($products);
    include 'view/browse.php';
    break;

  case 'filter':
    $category = filter_input(INPUT_GET, 'category', FILTER_SANITIZE_NUMBER_INT);

    $categories = getCategories();
    $categoriesDisplay = buildCategoriesSelect($categories, $category);

    // If all products
    if ($category == 0) {
      $productsDisplay = buildProductsDisplay($products);
    } else {
      // if specific category
      $productsByCategory = getProductsByCategory($category);
      $productsDisplay = buildProductsDisplay($productsByCategory);
    }
    include 'view/browse.php';
    break;

  case 'search':
    $searchTerm = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING);
    $productsBySearch = getProductsBySearch($products, $searchTerm);
    // check if there are results
    if (count($productsBySearch) != 0) {
      $productsDisplay = buildProductsDisplay($productsBySearch);
    } else {
      $_SESSION['message'] = "Sorry, no matches. :(";
    }
    include 'view/browse.php';
    break;

  case 'product-info':
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $product = getOneProduct($id);
    $productInfoDisplay = buildProductInfoDisplay($product);
    include 'view/product_details.php';
    break;

  // Case for when user wants to add an item to cart
  case 'add-to-cart':
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $product = getOneProduct($id);
    
    // add item to cart in model
    if ($product != 0) {
      // if successful
      addtoCart($product);
    } else {
      // if not, alert user and return to browse page
      $_SESSION['message'] = "$product[prod_name] could not be added to cart.";
      $productsDisplay = buildProductsDisplay($products);
      include 'view/browse.php';
    }

    // set message for success
    $_SESSION['message'] = "$product[prod_name] successfully added to cart.";
    $productsDisplay = buildProductsDisplay($products);
    include 'view/browse.php';
    break;

  case 'cart':
    $orders = array_count_values(array_column($_SESSION['cart'], 'prod_id'));
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
    $orders = array_count_values(array_column($_SESSION['cart'], 'prod_id'));
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

    $orders = array_count_values(array_column($_SESSION['cart'], 'prod_id'));

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