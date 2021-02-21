<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Order</title>
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
        <p id='shop-message'>
            <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
            ?>
        </p>
        <div class="view-order-container">
            <h2>My order</h2>
                <form action="index.php" method="POST">
                    <label for="order_id">Order Number</label><br>
                    <input type="text" name="order_id" id="order_id" placeholder="Order Number" oninput="numberOnly('order_id');" <?php if(isset($order_id)){echo "value='$order_id'";} ?> required><br>
                    <label for="order_id">Email</label><br>
                    <p>Please enter the email you used to place the order.</p>
                    <input type="email" name="email" id="email" placeholder="Email" <?php if(isset($email)){echo "value='$email'";} ?> required><br>
                    
                    <input type="submit" name="submit" value="VIEW MY ORDER">
                    <!-- To send the name-value pair for login -->
                    <input type="hidden" name="action" value="view-order-details">
                </form>
            </div>
    </main>

    <footer>
        <p>&#169; Homey. All rights reserved.</p>
        <p>Olea Yaona | BYU-Idaho | CSE-341</p>
    </footer>
<script>
    // Number only input
    function numberOnly(id){
        var input = document.getElementById(id).value.replace(/\D/g, '');
        document.getElementById(id).value = input;
    }
</script>
</body>

</html><?php unset($_SESSION['message']) ?>