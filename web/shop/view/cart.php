<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Julius+Sans+One&family=Open+Sans:wght@300;400&family=Playfair+Display&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda:ital@0;1&display=swap" rel="stylesheet">
    <link href="./shop.css" rel="stylesheet">
</head>

<body>
    <header>
        <div class="logo">
            <h1>HOMEY</h1>
            <p>Lifestyle and Home Decor</p>
        </div>
        <nav>
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/shop/modules/nav.php'; ?>
        </nav>
    </header>

    <main>
        <section class="cart-container">
        <?php
            if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];
            }
        ?>
        <h2>YOUR CART</h2>
            <?php
                if (isset($cartDisplay)) {
                    echo $cartDisplay;
                }
            ?>
        </section>
    </main>

    <footer>
        <p>&#169; Homey. All rights reserved.</p>
        <p>Olea Yaona | BYU-Idaho | CSE-341</p>
    </footer>
<script>
    // make sure search bar is not empty
    var validate = function(event) {
        var input = document.querySelector('#search');
        if (input.value.length == 0) {
            event.preventDefault();
            input.focus();
        }
    };

    // get form
    var form = document.querySelector("#search-form");

    // attach event listener
    form.addEventListener("submit", validate, true);
</script>
</body>

</html><?php unset($_SESSION['message'])?>