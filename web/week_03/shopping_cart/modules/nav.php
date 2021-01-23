<ul class="nav">
    <li><a href="./index.php">HOME</a></li>
    <li><a href="./index.php?action=shop">SHOP</a></li>
    <li><a href="./index.php?action=cart">CART</a></li>
    <li>
        <a id="cart-icon" href="./index.php?action=cart">
            <img id="cart" src="./images/cart.png" alt="cart icon">
            <p id="cart-num">
                <?php 
                    if (isset($_SESSION['cart'])) {
                        echo count($_SESSION['cart']);
                    } else {
                        echo "0";
                    }
                ?>
            </p>
        </a>
    </li>
</ul>