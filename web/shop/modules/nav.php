<ul class="nav">
    <li id="search-row">  
        <form action="./index.php" method="GET" id="search-form">
            <input type="text" id="search" name="search" placeholder="Search...">
            <button id="search-btn" type="submit"><img src="./images/search-icon.png" alt="search icon"></button>
            <input type="hidden" name="action" value="search">
        </form>
    </li>
    <li><a href="./index.php">HOME</a></li>
    <li><a href="./index.php?action=shop">SHOP</a></li>
    <li><a href="./index.php?action=view-order">MY ORDER</a></li>
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