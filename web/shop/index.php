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
    $categories = getCategories();
    $categoriesDisplay = buildCategoriesSelect($categories, 0);
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

    // if item is in stock
    if ($product['prod_stock'] != 0) {
      addtoCart($product);
      // set message for success
      $_SESSION['message'] = "$product[prod_name] successfully added to cart.";
    } else {
      // if not, alert user and return to browse page
      $_SESSION['message'] = "$product[prod_name] is sold out. :(";
    }

    $productsDisplay = buildProductsDisplay($products);
    $categories = getCategories();
    $categoriesDisplay = buildCategoriesSelect($categories, 0);
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
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $fname = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_STRING);
    $lname = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_STRING);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_NUMBER_INT);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
    $postal_code = filter_input(INPUT_POST, 'postal_code', FILTER_SANITIZE_NUMBER_INT);
    $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
    $country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING);

    // check if customer email is already in db
    $outcome = checkExistingEmail($email);
    // if there's no match, add customer to db
    if ($outcome == 0) {
      $addCustomerResult = addCustomer($email);
      // if successful, get customer id
      if ($addCustomerResult == 1) {
        $customer = getCustomer($email);
        $customer_id = $customer['customer_id'];
      } else {
        $_SESSION['message'] = "An error occurred. Could not add contact information. :(";
        $orders = array_count_values(array_column($_SESSION['cart'], 'prod_id'));
        $cartDisplay = buildCartDisplay($products, $orders);
        include 'view/cart.php';
      }
    } else {
      // if there's a match, get customer_id
      $customer = getCustomer($email);
      $customer_id = $customer['customer_id'];
    };

    // then create order and get order_id
    $order_id = createOrder($customer_id);

    // create recipient for oder
    $recipient_id = createRecipient($fname, $lname, $phone, $address, $postal_code, $city, $country, $order_id);

    // add recipient to order
    $addOrderRecipientResult = addOrderRecipient($order_id, $recipient_id);

    // Get orders from session
    $orders = array_count_values(array_column($_SESSION['cart'], 'prod_id'));

    // if order update was successful, attach products to order
    if ($addOrderRecipientResult == 1) {
      $products_in_cart = $_SESSION['cart'];
      // echo "<pre>" . print_r($products_ordered, true) . "</pre>" ;

      foreach($products_in_cart as $product) {
        $addProductOrderResult = addProductOrder($order_id, $product['prod_id']);
        echo "product added to order!";
        // if product has been added to order successfully, remove item from inventory
        if ($addProductOrderResult == 1) {
          $removeFromInventoryResult = removeFromInventory($product['prod_id']);
          // if inventory update failed
          if ($removeFromInventory != 1) {
            $_SESSION['message'] = "An error occurred. Could not update inventory. :(";
            $cartDisplay = buildCartDisplay($products, $orders);
            include 'view/cart.php';
          } else {
            echo "Inventory updated!";
          };
        } else {
          $_SESSION['message'] = "An error occurred. Could not add products to order. :(";
          $cartDisplay = buildCartDisplay($products, $orders);
          include 'view/cart.php';
        };
      };

    } else {
      $_SESSION['message'] = "An error occurred. Could not add recipient to order. :(";
      $orders = array_count_values(array_column($_SESSION['cart'], 'prod_id'));
      $cartDisplay = buildCartDisplay($products, $orders);
      include 'view/cart.php';
    }

    // build summary display
    $summaryDisplay = buildSummaryDisplay($products, $orders);
    
    // Empty cart after displaying summary
    unset($_SESSION['cart']);

    $name = $fname . " " . $lname;
    $completeAddress = $address . " " . $postal_code . "<br>" . $city . " " . $country;
    include 'view/confirmation.php';
    break;

  default:
    include 'view/homepage.php';
    break;
}


?>