<?php

// Build a display for products page
function buildProductsDisplay($products){
    $display = '<ul class="products">';
    foreach ($products as $product) {
     $display .= "<li><a href='./index.php?action=product-info&id=" . urlencode($product['prod_id']) . "'>";
     $display .= "<img class='product-img' src='./images/$product[prod_img]' alt='$product[prod_name]'></a>";
     $display .= "<a href='../index.php?action=product-info&id=" . urlencode($product['prod_id']) . "'><h2>" . strtoupper($product['prod_name']) . "</h2></a>";
     $display .= "<h4>&#8369;". number_format($product['prod_price'], 2) ."</h4>";
     $display .= "<a href='./index.php?action=add-to-cart&id=" . urlencode($product['prod_id']) . "'><h5 class='add-cart'>ADD TO CART</h3></a>";
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
            if ($key == $product['id']) {
                $total += $product['price'];
                $display .= "<tr class='cart-row'>";
                $display .= "<td><img class='product-img' src='./images/$product[image]' alt='$product[name]'></td>";
                $display .= "<td>
                                <h3>$product[name]</h3>
                                <p>$product[stock] items left</p>
                                <a href='./index.php?action=delete-from-cart&id=" . urlencode($product['id']) . "'><p>REMOVE</p></a>
                            </td>";
                $display .= "<td><p>&#8369;" . number_format($product['price'], 2) . "</p></td>";
                $display .= "<td><p>$value</p></td>";
                $display .= "<td><p>&#8369;" . number_format($value*$product['price'], 2) . "</p></td>";
                $display .= '</tr>';
            }
        }
    }
    $display .= "<tr><td></td><td></td><td></td><td></td><td><p id='subtotal'>SUBTOTAL</p><h3>&#8369;" . number_format($total, 2) . "</h3><a href='./index.php?action=checkout'><h4 id='checkout-btn'>CHECK OUT</h4></a></td></tr>";
    $display .= '</table>';
    return $display;
}

function buildSummaryDisplay($products, $orders) {
    $total = 0;
    $display = '<ul class="summary-list">';
    foreach($orders as $key => $value) {
        foreach ($products as $product) {
            if ($key == $product['id']) {
                $total += $product['price'];
                $display .= "<li class='summary-item'>";
                $display .= "<p>$value</p>";
                $display .= "<img class='product-img' src='./images/$product[image]' alt='$product[name]'>";
                $display .= "<h4>$product[name]</h4>";
                $display .= "<p>&#8369;" . number_format($value*$product['price'], 2) . "</p>";
            }
        }
    }
    $display .= "<li><h3>TOTAL</h3><p>&#8369;". number_format($total) . "</p></li>";
    $display .= '</ul>';
    return $display;
}

?>