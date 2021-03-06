<?php

// Build a display for products page
function buildProductsDisplay($products){
    $display = '<ul class="products">';
    foreach ($products as $product) {
     $display .= "<li><a href='./index.php?action=product-info&id=" . urlencode($product['prod_id']) . "'>";
     $display .= "<img class='product-img' src='./images/$product[prod_img]' alt='$product[prod_name]'></a>";
     $display .= "<a href='./index.php?action=product-info&id=" . urlencode($product['prod_id']) . "'><h2>" . strtoupper($product['prod_name']) . "</h2></a>";
     $display .= "<h4>&#8369;". number_format($product['prod_price'], 2) ."</h4>";
     $display .= "<a href='./index.php?action=add-to-cart&id=" . urlencode($product['prod_id']) . "'><h5 class='add-cart'>ADD TO CART</h5></a>";
     $display .= '</li>';
    }
    $display .= '</ul>';
    return $display;
}

// Build products list for cart
function buildCartDisplay($products, $orders) {
    $total = 0;
    $display = '<table class="cart">';
    $display .= "<tr><th></th><th>Product</th><th>Price</th><th>Quantity</th><th>Total</th></tr>";
    foreach($orders as $key => $value) {
        foreach ($products as $product) {
            if ($key == $product['prod_id']) {
                $total += $product['prod_price'];
                $display .= "<tr class='cart-row'>";
                $display .= "<td><img class='product-img' src='./images/$product[prod_img]' alt='$product[prod_name]'></td>";
                $display .= "<td>
                                <h3>$product[prod_name]</h3>
                                <p class='items-left'>$product[prod_stock] items left</p>
                                <a href='./index.php?action=delete-from-cart&prod_id=" . urlencode($product['prod_id']) . "'><p>REMOVE</p></a>
                            </td>";
                $display .= "<td><p>&#8369;" . number_format($product['prod_price'], 2) . "</p></td>";
                $display .= "<td><p>$value</p></td>";
                $display .= "<td><p>&#8369;" . number_format($value*$product['prod_price'], 2) . "</p></td>";
                $display .= '</tr>';
            }
        }
    }
    $display .= "<tr><td></td><td></td><td></td><td></td><td><p id='subtotal'>SUBTOTAL</p><h3>&#8369;" . number_format($total, 2) . "</h3><a href='./index.php?action=checkout'><h4 id='checkout-btn'>CHECK OUT</h4></a></td></tr>";
    $display .= '</table>';
    return $display;
}

// Build display for order summary
function buildSummaryDisplay($products, $orders) {
    $total = 0;
    $display = '<ul class="summary-list">';
    foreach($orders as $key => $value) {
        foreach ($products as $product) {
            if ($key == $product['prod_id']) {
                $total += $product['prod_price'];
                $display .= "<li class='summary-item'>";
                $display .= "<p>$value</p>";
                $display .= "<img class='product-img' src='./images/$product[prod_img]' alt='$product[prod_name]'>";
                $display .= "<h4>$product[prod_name]</h4>";
                $display .= "<p>&#8369;" . number_format($value*$product['prod_price'], 2) . "</p>";
            }
        }
    }
    $display .= "<li><h3>TOTAL</h3><p>&#8369;". number_format($total) . "</p></li>";
    $display .= '</ul>';
    return $display;
}

// Builds a select element for product categories in the db
function buildCategoriesSelect($categories, $selected) {
    $display = '<form action="index.php" method="GET" class="categories">';
    $display .= '<label for="category">Filter: </label><select name="category" id="category" onchange="this.form.submit()">';
    $display .= "<option value='0'>All</option>";
    foreach ($categories as $category) {
        if ($category['category_id'] == $selected) {
            $display .= "<option value='$category[category_id]' selected>$category[category_name]</option> ";
        } else {
            $display .= "<option value='$category[category_id]'>$category[category_name]</option> ";
        }
    }
    $display .= '</select>';
    $display .= '<input type="hidden" name="action" value="filter"></form>';
    return $display;
}

// Builds display for product info page
function buildProductInfoDisplay($product) {
    $display = '<section class="info-display">';
    $display .= "<img src='./images/$product[prod_img]' alt='$product[prod_name]'>";
    $display .= "<div><h2>$product[prod_name]</h2>";
    $display .= '<p>&#8369;'. number_format($product['prod_price'], 2) ."</p><p>$product[prod_description]</p>";
    $display .= "<p class='items-left'>$product[prod_stock] items left</p>";
    $display .= '<a href="./index.php?action=add-to-cart&id=' . urlencode($product['prod_id']) . '"><h5 class="add-cart">ADD TO CART</h5></a>';
    $display .= '</div> </section>';
    return $display;
}

?>